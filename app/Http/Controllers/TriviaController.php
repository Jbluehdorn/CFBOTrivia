<?php

namespace App\Http\Controllers;

use App\SubmittedAnswer;
use App\Form;
use App\Question;
use App\Season;
use Auth;
use Illuminate\Http\Request;

class TriviaController extends Controller
{
  /**
  * Get the current trivia form view
  *
  * @return view
  */
  public function getCurrentForm() {
    $form = Form::active();
    $questionTime = config('trivia.time_per_question');

    if($form->checkForUserSubmissions(Auth::User()->id)) {
      return redirect('/formSubmitted');
    } else {
      return view('trivia/form')->with(compact('form', 'questionTime'));
    }
  }

  /**
  * Get the questions for a form without any attached answers
  *
  * @param $formId
  * @return Array of App/Question
  */
  public function GetQuestions($formId) {
    $questions = Question::where('form_id', $formId)->paginate(1);

    //Remove data that users could use to cheat
    foreach($questions as $question) {
      unset($question->answers);
      unset($question->submittedAnswers);
    }

    return $questions;
  }

  /**
  * Submits all answers for a user
  *
  * @param Request $request
  */
  public function submitAllAnswers(Request $request) {
    $answers = $request->input('answers');

    foreach($answers as $answer) {
      $this->submitAnswer($answer['questionID'], $answer['answerBody']);
    }
  }

  /**
  * Submit an answer
  *
  * @param string answerBody
  * @param int questionID
  */
  public function submitAnswer($questionID, $body) {
    $answer = new SubmittedAnswer();
    $answer->body = $body;
    $answer->question_id = $questionID;
    $answer->user_id = Auth::User()->id;
    $answer->grade();

    return $answer->save() ? 'true' : 'false';
  }


  /**
  * View all submissions for the logged in user
  *
  * @return View
  */
  public function viewSubmissions() {
    $seasons = Season::get();

    return view('trivia/submissions')->with(compact('seasons'));
  }

  public function GetUserTotalScore($formId) {
    $season = Season::find($formId);

    $season->GetUserTotalScore(Auth::User());

    return $season->totalCorrect;
  }

  /**
  * Get all of the users past trivia submissions except for the active form
  *
  * @return array
  */
  public function getUserSubmissions() {
    $formObjs = Form::where('isActive', false)->orderBy('created_at', 'DESC')->get();
    $submissions = [];

    foreach($formObjs as $form) {
      $submissionObj = [];
      $submissionObj['form_title'] = $form->title;
      $submissionObj['season'] = $form->season->title;
      $submissionObj['submitted_answers'] = Auth::User()->getAllFormSubmissions($form->id);

      if(count($submissionObj['submitted_answers']))
      array_push($submissions, $submissionObj);
    }

    return $submissions;
  }

  /**
  * Get the submissions for a single form
  *
  * @param $formID
  * @return submission
  */
  public function getSingleFormSubmissions($formID) {
    $formObj = Form::find($formID);

    $submission = [];
    $submission['form_title'] = $formObj->title;
    $submission['submitted_answers'] = Auth::User()->getAllFormSubmissions($formObj->id);

    return $submission;
  }

  public function ResetSubmissions() {
    $form = Form::where('isActive', true)->first();

    foreach($form->questions as $question) {
      foreach($question->submittedAnswers as $answer) {
        if($answer->user_id == Auth::User()->id) {
          $answer->delete();
        }
      }
    }

    return redirect('/');
  }
}
