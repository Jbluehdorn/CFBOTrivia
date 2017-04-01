<?php

namespace App\Http\Controllers;

use App\SubmittedAnswer;
use App\Form;
use App\Question;
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

        return view('trivia/form')->with(compact('form', 'questionTime'));
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
     * Submit an answer
     *
     * @param string answerBody
     * @param int questionID
     */
    public function submitAnswer(Request $request) {
        $body = $request->input('answerBody');
        $questionID = $request->input('questionID');

        $answer = new SubmittedAnswer();
        $answer->body = $body;
        $answer->question_id = $questionID;
        $answer->user_id = Auth::User()->id;

        return $answer->save() ? 'true' : 'false';
    }
}
