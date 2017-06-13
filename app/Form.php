<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = [
        'title', 'season_id', 'rules_blurb'
    ];

    protected $with = [
        'questions', 'season'
    ];

    public function season() {
        return $this->belongsTo('App\Season');
    }

    public function questions() {
        return $this->hasMany('App\Question');
    }

    public function checkForUserSubmissions($userID) {
        $hasSubmissions = false;

        foreach($this->questions as $question) {
            foreach($question->submittedAnswers as $answer) {
                if($answer->user_id == $userID) {
                    $hasSubmissions = true;
                }
            }
        }

        return $hasSubmissions;
    }

    public static function active() {
        return static::where('isActive', true)->first();
    }
}
