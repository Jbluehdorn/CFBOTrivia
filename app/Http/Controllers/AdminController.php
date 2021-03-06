<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Form;
use App\Answer;
use App\Question;
use App\Season;
use App\Services\ReportingService;

class AdminController extends Controller
{
    /**
     * Home page which contains a list of all forms
     *
     * @return $this
     */
    public function index() {
        $forms = Form::get();
        $seasons = Season::get();

        return view('admin/all')->with(compact('forms', 'seasons'));
    }

    /**
     * View for the new Form page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newForm() {
        $seasons = Season::get();

        return view('admin/new')->with(compact('seasons'));
    }

    /**
     * View for the new Season page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newSeason() {
        return view('admin/newSeason');
    }

    public function reports() {
        return view('admin/reports');
    }

    public function getReports(ReportingService $reportingService, $seasonId) {
        return $reportingService->getReports($seasonId);
    }

    public function getSeasons() {
        return json_encode(Season::get());
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
     * Create a new season and redirect to the admin homepage
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function createSeason(Request $request) {
        $season = new Season($request->all());

        $season->save();

        return redirect('/admin');
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
     * @param int formId
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


    /**
     * Set the selected form as inactive
     *
     * @param int formId
     * @return App/Form
     */
    public function setInactiveForm(Request $request) {
        $form = Form::find($request->formId);
        $form->isActive = false;
        $form->save();

        return $form;
    }

    /**
     * Save all various changes to the form
     *
     * @param Request $request
     * @return mixed
     */
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

        $saveForm = Form::find($form['id']);
        $saveForm->rules_blurb = $form['rules_blurb'];
        $saveForm->save();

        return $form;
    }
}
