<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Form;

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

    public function setActiveForm(Request $request) {
        $id = $request->formId;

        $forms = Form::get();
        foreach($forms as $form) {
            $form->isActive = $form->id == $id;
            $form->save();
        }

        return $forms;
    }
}
