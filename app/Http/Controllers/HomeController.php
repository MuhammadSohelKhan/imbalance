<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the application dashboard (lines of a summary).
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function line($summary_id)
    {
        $ctrlSummary = \App\Models\Summary::findOrFail($summary_id);

        return view('line', compact('ctrlSummary'));
    }

    /**
     * Show the application dashboard (operations of a line).
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function operation($line_id)
    {
        return view('operation', compact('line_id'));
    }
}
