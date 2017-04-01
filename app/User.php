<?php

namespace App;

use App\Form;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getAllFormSubmissions($formID) {
        $form = Form::find($formID);
        $answers = [];

        $questions = $form->questions;

        foreach($questions as $question) {
            $answer = $question->submittedAnswers->where('user_id', $this->id)->first();

            array_push($answers, $answer);
        }

        return $answers;
    }
}
