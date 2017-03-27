<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Form;

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
}
