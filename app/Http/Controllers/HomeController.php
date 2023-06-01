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
        if (in_array($aUser->role,['CiC','user','viewer']) && $aUser->client_id != $client_id) {
            abort(403);
        }
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
        if (in_array($aUser->role,['CiC','user','viewer']) && $aUser->client_id != $ctrlProject->client_id) {
            abort(403);
        }

        return view('line', compact('ctrlProject', 'aUser'));
    }

    /**
     * Show the application dashboard (operations of a line).
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function operation($line_id)
    {
        $aUser = auth()->user();
        $ctrlLine = Line::findOrFail($line_id);
        if (in_array($aUser->role,['CiC','user','viewer']) && $aUser->client_id != $ctrlLine->project->client_id) {
            abort(403);
        }
        
        return view('operation', compact('ctrlLine','aUser'));
    }

    public function exportSummary($projid)
    {
        $aUser = auth()->user();
        $project = Project::findOrFail($projid);
        if (in_array($aUser->role,['CiC','user','viewer']) && $aUser->client_id != $project->client_id) {
            abort(403);
        }

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
        if (in_array($aUser->role, ['Master','superadmin','admin','CiC'])) {
            $permRoles = explode(',',$this->permittedRoles($aUser->role));

            $user = "";

            if ($request->u) {
                $request->validate(['u'=>'exists:users,email']);
                $user = User::where('email', $request->u)->select('id','name','email','role','client_id','project_id','assigned_to')->first();

                // Securing Master user
                if ($user->email == "masrurbinmorshed@gmail.com" && $aUser->email != "masrurbinmorshed@gmail.com") {
                    abort(404);
                }

                // 'hdn' means HIDDEN
                session()->flash('hdn_edit_user',TRUE);
                session()->flash('hdn_edit_user_id', $user->id);
                session()->flash('hdn_edit_user_email',$user->email);
            }

            return view('users.create', compact('aUser','permRoles','user'));
        } else {
            abort(404);
        }
    }

    public function getAllUserPage(Request $request)
    {
        $aUser = auth()->user();
        if (in_array($aUser->role, ['Master','superadmin','admin','CiC'])) {
            $permRoles = explode(',',$this->permittedRoles($aUser->role));
            $users = User::select('id','name','email','role','client_id','project_id','assigned_to')->with(['client:id,client_code','assignedTo:id,name'])->whereIn('role',$permRoles);

            if ($aUser->role == 'CiC') {
                $users = $users->where('assigned_to', $aUser->id)->orWhere('client_id',$aUser->client_id)->orWhere('id', $aUser->id);
            }
            $users = $users->get()->mapToGroups(function ($item)
            {
                return [$item['role'] => $item];
            });/*dd($users['CiC'][0]);*/

            return view('users.all_users', compact('users'));
        } else {
            abort(403);
        }
    }

    public function postUser(Request $request)
    {
        $aUser = auth()->user();

        if (in_array($aUser->role, ['Master','superadmin','admin','CiC'])) {
            $permRoles = $this->permittedRoles($aUser->role);

            $data = $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users,email,'.session()->get('hdn_edit_user_id'),
                'role' => 'required|string|in:'.$permRoles,
            ]);

            if (in_array($request->role, ['CiC', 'user', 'viewer'])) {
                $request->validate([
                    'client_code' => 'required|string|regex:/^CL-[A-Z]{2}-(?!000)\d{3}$/|exists:clients,client_code',
                ]);
                $data['client_id'] = Client::select('id')->where('client_code', $request->client_code)->first()->id;
            } else { $data['client_id'] = NULL; }

            if ($request->role == "user") {
                $request->validate([
                    'user_id' => 'required|exists:users,id',
                ]);
                $data['assigned_to'] = $request->user_id;
            } else { $data['assigned_to'] = NULL; }

            // Securing Master user
            if ($data['email'] == "masrurbinmorshed@gmail.com" && $aUser->email != "masrurbinmorshed@gmail.com") {
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

            // Securing Master user
            if ($user->email == "masrurbinmorshed@gmail.com" && $aUser->email != "masrurbinmorshed@gmail.com") {
                abort(404);
            }
            
            $user->delete();
            session()->flash('success', 'User deleted successfully.');
            return redirect(route('users.all'));
        } else {
            abort(404);
        }
    }

    public function permittedRoles($aUserRole)
    {
        switch ($aUserRole) {
            case 'Master':
                $permRoles = 'Master,superadmin,admin,CiC,user,viewer';
                break;

            case 'superadmin':
                $permRoles = 'superadmin,admin,CiC,user,viewer';
                break;

            case 'admin':
                $permRoles = 'admin,CiC,user,viewer';
                break;

            default:
                $permRoles = 'CiC,user,viewer';
                break;
        }

        return $permRoles;
    }
}
