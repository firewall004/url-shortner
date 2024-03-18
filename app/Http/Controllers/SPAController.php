<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class SPAController extends Controller
{
    public function index(): View
    {
        return view('spa');
    }
}
