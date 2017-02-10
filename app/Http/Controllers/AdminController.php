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
     * Home page for the admin side of the application
     */
    public function index() {
        $forms = $this->getAllForms();
        return view('admin/all')->with(compact('forms'));
    }

    /**
     * New form page
     */
    public function newForm() {
        return view('admin/new');
    }


    public function createForm(Request $request) {
        $form = new Form($request->all());
        $form->save();

        return $form;
    }

    /**
     * Edit a form
     * @param $id
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
        $forms = Form::all();
        return $forms->toArray();
    }
}
