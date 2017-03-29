<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Form;
use App\Question;
use App\Answer;
use App\SubmittedAnswer;

class GradingController extends Controller
{
    /**
     * Home page for grading
     */
    public function home() {
        $forms = Form::get();
        return view('admin/grading/home')->with(compact('forms'));
    }

    /**
     * Page to grade a specific form
     *
     * @param $id
     */
    public function gradeForm($id) {
        $form = Form::find($id);

        return view('admin/grading/gradeForm')->with(compact('form'));
    }

    /**
     * Mark an answer as correct
     *
     * @param $questionID
     * @param $answerBody
     */
    public function markCorrect(Request $request) {
        $question = Question::find($request->input('questionID'));
        $answerBody = trim($request->input('answerBody'));

        //Ensure that the same answer isn't being added multiple times
        $answer = Answer::where('question_id', $question->id)->where('body', $answerBody)->first();
        //Create the answer object and save it
        if($answer == null) {
            $answer = new Answer();
            $answer->question_id = $question->id;
            $answer->body = ucfirst(trim($answerBody));
            $answer->save();
        }

        foreach($question->submittedAnswers as $submittedAnswer) {
            if(strtolower(trim($submittedAnswer->body)) == strtolower($answerBody)) {
                $answerObj = SubmittedAnswer::find($submittedAnswer->id);

                $answerObj->notable = false;
                $answerObj->correct = true;
                $answerObj->save();
            }
        }

        $question = $question->fresh();

        return $question;
    }

    /**
     * Marks an answer as incorrect
     *
     * @param Request $request
     * @return mixed
     */
    public function markWrong(Request $request) {
        $question = Question::find($request->input('questionID'));
        $answerBody = trim($request->input('answerBody'));

        $answer = Answer::where('question_id', $question->id)->where('body', $answerBody)->first();
        if($answer != null) {
            $answer->delete();
        }

        foreach($question->submittedAnswers as $submittedAnswer) {
            if(strtolower(trim($submittedAnswer->body)) == strtolower($answerBody)) {
                $answerObj = SubmittedAnswer::find($submittedAnswer->id);

                $answerObj->notable = false;
                $answerObj->correct = false;
                $answerObj->save();
            }
        }

        $question = $question->fresh();

        return $question;
    }

    /**
     * Mark an answer as wrong but notable
     *
     * @param Request $request
     * @return mixed
     */
    public function markNotable(Request $request) {
        $question = Question::find($request->input('questionID'));
        $answerBody = trim($request->input('answerBody'));

        $answer = Answer::where('question_id', $question->id)->where('body', $answerBody)->first();
        if($answer != null) {
            $answer->delete();
        }

        foreach($question->submittedAnswers as $submittedAnswer) {
            if(strtolower(trim($submittedAnswer->body)) == strtolower($answerBody)) {
                $answerObj = SubmittedAnswer::find($submittedAnswer->id);

                $answerObj->notable = true;
                $answerObj->correct = false;
                $answerObj->save();
            }
        }

        $question = $question->fresh();

        return $question;
    }
}
