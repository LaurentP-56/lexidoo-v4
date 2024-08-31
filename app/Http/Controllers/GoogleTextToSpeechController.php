<?php

namespace App\Http\Controllers;

use App\Models\Mot;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Illuminate\Support\Facades\Log;

class GoogleTextToSpeechController extends Controller
{
    private TextToSpeechClient $textToSpeechClient;

    public function __construct()
    {
        try {
            $credentialsPath = storage_path('app/lexidoo-credentials.json');
            $this->textToSpeechClient = new TextToSpeechClient([
                'credentials' => json_decode(file_get_contents($credentialsPath), true)
            ]);
            Log::info('TextToSpeechClient initialisé avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'initialisation de TextToSpeechClient : ' . $e->getMessage());
        }
    }

   public function generateMissingAudios()
{
    $mots_without_audio = Mot::whereNull("audioblob")->get();

    foreach ($mots_without_audio as $mot) {
        ini_set('max_execution_time', 0);

        Log::info('Génération de l\'audio pour le mot : ' . $mot->traduction);

        $audioContent = $this->generateAudioOfString($mot->traduction);
		Log::info('Audio content length: ' . strlen($audioContent));
dd($audioContent);


        if ($audioContent) {
            Log::info('Audio généré pour le mot : ' . $mot->traduction . ' - Taille : ' . strlen($audioContent));

            // Stocker le fichier audio sous forme de BLOB dans la base de données
            $mot->audioblob = $audioContent;

            // Ajoute un log avant la tentative d'enregistrement
            Log::info('Tentative d\'enregistrement de l\'audio pour le mot : ' . $mot->traduction);

            // Vérifie si l'audio est bien en train d'être sauvegardé
            if ($mot->save()) {
                Log::info('Audio enregistré avec succès pour le mot : ' . $mot->traduction);
            } else {
                Log::error('Échec de l\'enregistrement de l\'audio pour le mot : ' . $mot->traduction);
            }
        } else {
            Log::error('L\'audio n\'a pas pu être généré pour le mot : ' . $mot->traduction);
        }
    }

    return response()->json(['message' => 'Audios générés avec succès.'], 200);
}


public function generateAudioOfString($str)
{
    Log::info('Appel de generateAudioOfString pour le texte : ' . $str);

    $input = new \Google\Cloud\TextToSpeech\V1\SynthesisInput();
    $input->setText($str);

    $voice = new \Google\Cloud\TextToSpeech\V1\VoiceSelectionParams();
    $voice->setLanguageCode('en-GB');
    $voice->setName('en-GB-Wavenet-A');

    $audioConfig = new \Google\Cloud\TextToSpeech\V1\AudioConfig();
    $audioConfig->setAudioEncoding(\Google\Cloud\TextToSpeech\V1\AudioEncoding::LINEAR16);

    try {
        $response = $this->textToSpeechClient->synthesizeSpeech($input, $voice, $audioConfig);
        Log::info('Response from Google TTS: ' . print_r($response, true));
        $audioContent = $response->getAudioContent();
        
        if ($audioContent) {
            Log::info('Audio content length: ' . strlen($audioContent));
        } else {
            Log::warning('Aucun contenu audio généré pour : ' . $str);
        }

        return $audioContent;
    } catch (\Exception $e) {
        Log::error('Erreur lors de la génération de l\'audio : ' . $e->getMessage() . ' - ' . $e->getTraceAsString());
        return null;
    }
}


}
