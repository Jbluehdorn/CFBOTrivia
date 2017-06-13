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

  public function answers() {
    return $this->hasMany('App\SubmittedAnswer');
  }

  /**
  * Get all submitted answers for a single form
  *
  * @param $formID
  * @return array
  */
  public function getAllFormSubmissions($formID) {
    $form = Form::find($formID);
    $answers = [];

    $questions = $form->questions;

    foreach($questions as $question) {
      $answer = $question->submittedAnswers->where('user_id', $this->id)->first();

      if(!is_null($answer))
      array_push($answers, $answer);
    }

    return $answers;
  }

  /**
 	 * Check if the user has any submissions in a given season
 	 *
 	 * @param int - season ID
 	 * @return boolean - Do they have a submission?
	 */
  public function hasSubmissionsInSeason($seasonId) {
    $hasSubmissionsInSeason = false;
    $forms = Form::get();
    $seasonForms = [];
    $len = count($forms);

    //Get only the forms that pertain to the current season
    foreach($forms as $form) {
      if($form->season_id == $seasonId) {
        array_push($seasonForms, $form);
      }
    }

    //Check if the user has any submissions in the given season
    foreach($seasonForms as $form) {
      if(count($this->getAllFormSubmissions($form->id)) > 0) {
        $hasSubmissionsInSeason = true;
      }
    }

    return $hasSubmissionsInSeason;
  }
}
