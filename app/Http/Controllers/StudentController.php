<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(): View
    {
        return view('student', []);
    }
}
