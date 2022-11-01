<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Pharmacist;
use App\Models\Receptionist;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        $user = Auth::user();

        if($user->hasRole('Admin')) {
            $doctors = Doctor::latest()->get();
            $patients = Patient::latest()->get();

            return view('home')->with([
                'doctors' => $doctors,
                'patients' => $patients
            ]);
        }
        else if($user->hasRole('Doctor')) {
            $doctor = Doctor::with([])->findOrFail($user->doctor->id);

            return view('home')->with('doctor', $doctor);
        }
        else if($user->hasRole('Receptionist')) {
            $receptionist = Receptionist::find($user->receptionist->id);
            
            return view('home')->with('receptionist', $receptionist);
        }
        else if($user->hasRole('Pharmacist')) {
            $pharmacist = Pharmacist::find($user->pharmacist->id);

            return view('home')->with('pharmacist', $pharmacist);
        }
        else {
            $title = 'Error';
            $message = 'The signed in user is not assigned to a role for the application';
            $route = 'home';
            $action = 'Back to Home.';
            return view('errors.message')->with([
                'title' => $title,
                'message' => $message,
                'route' => $route,
                'action' => $action
            ]);
        }
    }

    /**
     * Show the User profile.
     */
    public function profile()
    {
        return view('profile.index');
    }

    /**
     * Show the User Edit profile .
     */
    public function profileEdit(){
        return view('profile.edit');
    }

    /**
     * Update the User profile.
     */
    public function profileUpdate(Request $request){
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.auth()->id()
        ]);

        if ($request->hasFile('profile_picture')) {
            $profile = Str::slug(auth()->user()->name).'-'.auth()->id().'.'.$request->profile_picture->getClientOriginalExtension();
            $request->profile_picture->move(public_path('images/profile'), $profile);
        } else {
            $profile = 'avatar.png';
        }

        $user = auth()->user();

        $user->update([
            'name'              => $request->name,
            'email'             => $request->email,
            'profile_picture'   => $profile
        ]);

        return redirect()->route('profile');
    }

    /**
     * Show the User change password.
     * 
     */
    public function changePassword()
    {
        return view('profile.changepassword');
    }

    /**
     * Update the User password.
     * 
     */
    public function updatePassword(Request $request)
    {
        if (!(Hash::check($request->get('currentpassword'), Auth::user()->password))) {
            return back()->with([
                'msg_currentpassword' => 'Your current password does not matches with the password you provided! Please try again.'
            ]);
        }
        if(strcmp($request->get('currentpassword'), $request->get('newpassword')) == 0){
            return back()->with([
                'msg_currentpassword' => 'New Password cannot be same as your current password! Please choose a different password.'
            ]);
        }

        $this->validate($request, [
            'currentpassword' => 'required',
            'newpassword'     => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        $user->password = bcrypt($request->get('newpassword'));
        $user->save();

        Auth::logout();

        return redirect()->route('login');
    }
}
