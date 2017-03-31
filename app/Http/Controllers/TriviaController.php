<?php

namespace App\Http\Controllers;

use App\Form;
use App\Question;
use Illuminate\Http\Request;

class TriviaController extends Controller
{
    public function getCurrentForm() {
        $form = Form::active();
        $questionTime = config('trivia.time_per_question');

        return view('trivia/form')->with(compact('form', 'questionTime'));
    }

    public function GetQuestions($formId) {
        $questions = Question::where('form_id', $formId)->paginate(1);

        //Remove data that users could use to cheat
        foreach($questions as $question) {
            unset($question->answers);
            unset($question->submittedAnswers);
        }

        return $questions;
    }
}
