<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Form;
use App\Answer;
use App\Question;

class AdminController extends Controller
{
    /**
     * AdminController constructor
     * Middleware: Authentication
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Home page which contains a list of all forms
     *
     * @return $this
     */
    public function index() {
        $forms = Form::get();
        return view('admin/all')->with(compact('forms'));
    }

    /**
     * View for the new Form page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newForm() {
        return view('admin/new');
    }


    /**
     * Create a new form and then go to the edit page
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function createForm(Request $request) {
        $form = new Form($request->all());
        $form->save();

        return redirect('/admin/edit/' . $form->id);
    }

    /**
     * Go to the form edit page for a requested id
     *
     * @param $id
     * @return $this
     */
    public function editForm($id) {
        $form = Form::find($id);
        return view('admin/edit')->with(compact('form'));
    }

    /**
     * Get all Forms
     * @return [Form]
     */
    public function getAllForms() {
        $forms = Form::get();
        return $forms->toArray();
    }

    /**
     * Set a form as the active form and the rest to inactive
     *
     * @param Request $request
     * @return [Form]
     */
    public function setActiveForm(Request $request) {
        $id = $request->formId;

        $forms = Form::get();
        foreach($forms as $form) {
            $form->isActive = $form->id == $id;
            $form->save();
        }

        return $forms;
    }

    public function saveFormChanges(Request $request) {
        $form = $request->form;

        foreach(request('form.questions') as $question) {
            $questionObj = new Question();

            switch($question['type']) {
                case 'new':
                    $questionObj->body = $question['body'];
                    $questionObj->form_id = $form['id'];
                    $questionObj->save();
                    break;
                case 'update':
                    $questionObj = isset($question['id']) ? Question::find($question['id']) :
                        Question::where('form_id', $form['id'])
                            ->where('body', $question['body'])
                            ->first();
                    $questionObj->body = $question['body'];
                    $questionObj->save();
                    break;
                case 'destroy':
                    $questionObj = isset($question['id']) ? Question::find($question['id']) :
                        Question::where('form_id', $form['id'])
                            ->where('body', $question['body'])
                            ->first();
                    if(count($questionObj) > 0) {
                        $questionObj->delete();
                    }
                    break;
            }

            //Verify the question exists before trying to loop through it
            if(count($questionObj) > 0) {
                foreach ($question['answers'] as $answer) {
                    switch ($answer['type']) {
                        case 'new':
                            $answerObj = new Answer();
                            $answerObj->question_id = $questionObj->id;
                            $answerObj->body = $answer['body'] ?? '';
                            $answerObj->save();
                            break;
                        case 'update':
                            $answerObj = isset($answer['id']) ? Answer::find($answer['id']) :
                                Answer::where('body', $answer['body'])->first();
                            $answerObj->body = $answer['body'] ?? '';
                            $answerObj->save();
                            break;
                        case 'destroy':
                            $answerObj = isset($answer['id']) ? Answer::find($answer['id']) :
                                Answer::where('body', $answer['body'])->first();
                            if(count($answerObj) > 0) {
                                $answerObj->delete();
                            }
                            break;
                    }
                }
            }
        }

        return $form;
    }
}
