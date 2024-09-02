<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mot;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\Translate\TranslateClient;
use Illuminate\Support\Facades\Log;

class GoogleTextToSpeechController extends Controller
{
    private TextToSpeechClient $textToSpeechClient;
    private TranslateClient $translateClient;

    public function __construct()
    {
        try {
            $credentialsPath          = storage_path('app/lexidoo-credentials.json');
            $this->textToSpeechClient = new TextToSpeechClient([
                'credentials' => json_decode(file_get_contents($credentialsPath), true),
            ]);
            $this->translateClient = new TranslateClient([
                'credentials' => json_decode(file_get_contents($credentialsPath), true),
            ]);
            Log::info('TextToSpeechClient et TranslateClient initialisés avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'initialisation de TextToSpeechClient ou TranslateClient : ' . $e->getMessage() . ' - ' . $e->getTraceAsString());
        }
    }

    public function generateMissingAudios()
    {
        $mots_without_audio = Mot::whereNull("audioblob")->get();
        Log::info('Nombre de mots sans audio : ' . $mots_without_audio->count());
        Log::info('Requête SQL générée : ' . Mot::whereNull("audioblob")->toSql());

        foreach ($mots_without_audio as $mot) {
            ini_set('max_execution_time', 0);

            Log::info('Traitement du mot : ' . $mot->nom . ' (ID : ' . $mot->id . ')');

            $translatedText = $this->translateText($mot->nom, 'en-GB');

            if ($translatedText) {
                Log::info('Mot traduit : ' . $translatedText);

                $audioContent = $this->generateAudioOfString($translatedText);

                if ($audioContent) {
                    Log::info('Audio généré pour le mot traduit : ' . $translatedText . ' - Taille : ' . strlen($audioContent));

                    // Stocker le fichier audio sous forme de BLOB dans la base de données
                    $mot->audioblob = $audioContent;

                    // Vérifie si l'audio est bien en train d'être sauvegardé
                    if ($mot->save()) {
                        Log::info('Audio enregistré avec succès pour le mot traduit : ' . $translatedText);
                        Log::info('Objet Mot mis à jour : ' . print_r($mot->toArray(), true));
                    } else {
                        Log::error('Échec de l\'enregistrement de l\'audio pour le mot traduit : ' . $translatedText);
                    }
                } else {
                    Log::error('L\'audio n\'a pas pu être généré pour le mot traduit : ' . $translatedText);
                }
            } else {
                Log::error('La traduction n\'a pas pu être générée pour le mot : ' . $mot->nom);
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

    public function translateText($text, $targetLanguage)
    {
        Log::info('Appel de translateText pour le texte : ' . $text);

        try {
            $response = $this->translateClient->translate($text, [
                'target' => $targetLanguage,
            ]);
            $translatedText = $response['text'];

            if ($translatedText) {
                Log::info('Texte traduit : ' . $translatedText);
            } else {
                Log::warning('Aucun texte traduit pour : ' . $text);
            }

            return $translatedText;
        } catch (\Exception $e) {
            Log::error('Erreur lors de la traduction du texte : ' . $e->getMessage() . ' - ' . $e->getTraceAsString());
            return null;
        }
    }
}
