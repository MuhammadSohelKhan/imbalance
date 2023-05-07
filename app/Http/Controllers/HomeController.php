<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use App\Models\Client;
use App\Models\Project;
use App\Models\Line;
use App\Models\User;
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
        $aUser = auth()->user();
        return view('home', compact('aUser'));
    }

    /**
     * Show the application dashboard (lines of a summary).
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function projects($client_id)
    {
        $aUser = auth()->user();
        $ctrlClient = Client::findOrFail($client_id);

        return view('project', compact('ctrlClient', 'aUser'));
    }

    /**
     * Show the application dashboard (lines of a summary).
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function lines($project_id)
    {
        $aUser = auth()->user();
        $ctrlProject = Project::findOrFail($project_id);

        return view('line', compact('ctrlProject', 'aUser'));
    }

    /**
     * Show the application dashboard (operations of a line).
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function operation($line_id)
    {
        $ctrlLine = Line::findOrFail($line_id);
        return view('operation', compact('ctrlLine'));
    }

    public function exportSummary($projid)
    {
        $project = Project::findOrFail($projid);
        return Excel::download(new SummaryExport($project->id), 'imbalance-analysis.xlsx');
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

    public function getUserPage(Request $request)
    {
        $aUser = auth()->user();
        if (in_array($aUser->role, ['Master','superadmin'])) {
            $user = "";
            if ($request->u) {
                $request->validate(['u'=>'exists:users,email']);
                $user = User::where('email', $request->u)->select('id','name','email','role')->first();

                if ($user->email == "masrurbinmorshed@gmail.com" && $aUser->role != "Master") {
                    abort(404);
                }
                session()->flash('hdn_edit_user',TRUE);
                session()->flash('hdn_edit_user_id', $user->id);
                session()->flash('hdn_edit_user_email',$user->email);
            }
            return view('users.create', compact('aUser', 'user'));
        } else {
            abort(404);
        }
    }

    public function getAllUserPage(Request $request)
    {
        $aUser = auth()->user();
        if (in_array($aUser->role, ['Master','superadmin'])) {
            $users = User::select('id','name','email','role');

            if (in_array($aUser->role, ['superadmin'])) {
                $users = $users->where('role','!=','Master');
            }
            $users = $users->get();

            return view('users.all_users', compact('users'));
        } else {
            abort(403);
        }
    }

    public function postUser(Request $request)
    {
        $aUser = auth()->user();
        if (in_array($aUser->role, ['Master','superadmin'])) {
            $data = $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users,email,'.session()->get('hdn_edit_user_id'),
                'role' => 'required|string|in:superadmin,admin,user',
            ]);

            if ($data['email'] == "masrurbinmorshed@gmail.com" && $aUser->role != "Master") {
                abort(404);
            }

            if (!session()->has('hdn_edit_user')) {
                $password = $request->validate([
                    'password' => 'required|string|min:8|max:30|confirmed',
                ]);
                $data['password'] = Hash::make($password['password']);

                $newUser = User::create(array_merge($data, [
                    'email_verified_at' => now(),
                ]));
            } else {
                $newUser = User::where('id', session()->get('hdn_edit_user_id'))->where('email', session()->get('hdn_edit_user_email'))->first()->update($data);
            }

            if ($newUser) {
                session()->flash('success', 'User data stored successfully.');
            }
            return redirect(route('users.all'));
        } else {
            abort(403);
        }
    }

    public function deleteUser(User $user)
    {
        $aUser = auth()->user();
        if (in_array($aUser->role, ['Master','superadmin'])) {

            if ($user->email == "masrurbinmorshed@gmail.com" && $aUser->role != "Master") {
                abort(404);
            }
            
            $user->delete();
            session()->flash('success', 'User deleted successfully.');
            return redirect(route('users.all'));
        } else {
            abort(404);
        }
    }
}
