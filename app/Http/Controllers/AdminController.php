<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('admin/all');
    }

    /**
     * New form page
     */
    public function newForm() {
        return view('admin/new');
    }
}
