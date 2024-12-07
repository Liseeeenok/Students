<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class FacultyController extends Controller
{
    public function index(): View
    {
        return view('faculty', []);
    }
}
