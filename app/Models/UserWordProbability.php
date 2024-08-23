<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWordProbability extends Model
{
    use HasFactory;

    protected $table    = 'user_word_probabilities';
    protected $fillable = ['user_id', 'mot_id', 'probability_of_appearance'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mot()
    {
        return $this->belongsTo(Mot::class);
    }
}
