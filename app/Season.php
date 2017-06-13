<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Utility\SortUtility;

class Season extends Model
{
  protected $fillable = [
    'title'
  ];

  public function Forms() {
    return $this->hasMany('App\Form');
  }

  //Get the total amount of correct answers in the season based on the amount of
  //accepted amount of questions per season
  public function GetUserTotalScore(User $user) {
    $total = 0;
    $topScoresPerSeason = config('trivia.top_scores_per_season');

    //Get the users scores
    $scores = $this->getScoresArray($user);

    //Limit array to maximum size
    $scores = array_slice($scores, 0, $topScoresPerSeason);

    //Total all the top scores
    foreach($scores as $score) {
      $total += $score;
    }

    $this->totalCorrect = $total;

    return $total;
  }

  public function getRankings() {
    $users = User::get();
    $usersWithSubmissions = [];
    $len = count($users);

    foreach($users as $user) {
      if($user->hasSubmissionsInSeason($this->id))
        array_push($usersWithSubmissions, $user);
    }

    return $usersWithSubmissions;
  }

  /**
  * Gets all the scores for a user in a given season
  *
  * @param $user - App/User
  * @return array of scores in descending order
  */
  private function getScoresArray($user) {
    $submissions = [];
    $scores = [];
    $forms = $this->forms;

    //Put all the submissions in an array
    foreach($forms as $form) {
      $submissionObj = $user->getAllFormSubmissions($form->id);
      array_push($submissions, $submissionObj);
    }

    //Put the score from each submission into an array
    foreach($submissions as $submission) {
      array_push($scores, $this->calcSubmissionTotal($submission));
    }

    //Sort the array in descending order
    return array_reverse(SortUtility::QuickSort($scores));
  }

  /**
  * Calculate the percent correct for a form
  *
  * @param $submissionObj
  * @return float
  */
  private function calcSubmissionPercentage($submissionObj) {
    $score = $this->calcSubmissionTotal($submissionObj);
    $count = count($submissionObj);

    return $score / $count;
  }

  /**
  * Calculate the total correct answers in a form
  *
  * @param $submissionObj
  * @return int
  */
  private function calcSubmissionTotal($submissionObj) {
    $total = 0;

    foreach($submissionObj as $obj) {
      $total += $obj->correct;
    }

    return $total;
  }
}
