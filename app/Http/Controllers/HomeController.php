<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use App\Models\Summary;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SummaryExport;

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
        $ctrlSummary = Summary::findOrFail($summary_id);

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

    public function exportSummary($sumid)
    {
        $summary = Summary::findOrFail($sumid);
        return Excel::download(new SummaryExport($summary->id), 'imbalance-analysis.xlsx');
    }

    public function postChangePassword(Request $request)
    {
        $request->validate([
            'current_password'=> [function ($attribute, $value, $fail) {
                if (!Hash::check($value, auth()->user()->password)) {
                    $fail('Current password not matched.');
                }
            }],
            'password' => [function ($attr, $val, $fail)
            {
                if (Hash::check($val, auth()->user()->password)) {
                    $fail('Old and New passwords are same.');
                }
            }, 'confirmed', 'min:8']
            //'password' => 'confirmed|min:8',
        ]);

        $user = auth()->user();
        if(isset($request->password)){
            $user->password=Hash::make($request->password);
        }

        $user->save();
        session()->flash('success', 'You have changed your password successfully!');
        return redirect(route('home'));
    }

    public function getChangePasswordPage()
    {
        return view('auth.passwords.change_password');
    }
}
