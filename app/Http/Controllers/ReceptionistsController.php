<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Receptionist;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ReceptionistsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $receptionists = Receptionist::orderBy('id', 'asc')->paginate(10);
        return view('backend.receptionists.index')->with('receptionists', $receptionists);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.receptionists.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|string|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:255',
            'gender' => 'required|string',
            'dateofbirth' => 'required|date',
            'address' => 'required|string|max:255',
            'salary' => 'required|numeric',
            'period' => 'required|string'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        if($request->hasFile('profile_picture')){
            $profile = Str::slug($request->name) . '-' . $user->id . '.'.$request->profile_picture->getClientOriginalExtension();
            $request->profile_picture->move(public_path('images/profile'), $profile);
        }
        else {
            $profile = 'avatar.png';
        }

        $user->update([
            'profile_picture' => $profile
        ]);


        $user->receptionist()->create([
            'phone' => $request->phone,
            'gender' => $request->gender,
            'dateofbirth' => $request->dateofbirth,
            'address' => $request->address,
            'salary' => $request->salary,
            'period' => $request->period
        ]);

        $user->assignRole('Receptionist');
        
        return redirect('/receptionists');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $receptionist = Receptionist::find($id);
        return view('backend.receptionists.show')->with('receptionist', $receptionist);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $receptionist = Receptionist::find($id);
        return view('backend.receptionists.edit')->with('receptionist', $receptionist);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $receptionist = Receptionist::find($id);
        
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|string|max:255|unique:users,email,'.$receptionist->user_id,
            'phone' => 'required|string|max:255',
            'gender' => 'required|string',
            'dateofbirth' => 'required|date',
            'address' => 'required|string|max:255',
            'salary' => 'required|numeric',
            'period' => 'required|string'
        ]);

        $user = User::findOrFail($receptionist->user_id);

        if($request->hasFile('profile_picture')){
            $profile = Str::slug($request->name) . '-' . $user->id . '.'.$request->profile_picture->getClientOriginalExtension();
            $request->profile_picture->move(public_path('images/profile'), $profile);
        }
        else {
            $profile = $user->profile_picture;
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'profile_picture' => $profile
        ]);


        $user->receptionist()->update([
            'phone' => $request->phone,
            'gender' => $request->gender,
            'dateofbirth' => $request->dateofbirth,
            'address' => $request->address,
            'salary' => $request->salary,
            'period' => $request->period
        ]);

        return redirect('/receptionists');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $receptionist = Receptionist::find($id);
        $user = User::findOrFail($receptionist->user_id);

        $user->receptionist()->delete();

        $user->removeRole('Receptionist');
        if ($user->delete()) {
            if($user->profile_picture != 'avatar.png') {
                $image_path = public_path() . '/images/profile/' . $user->profile_picture;
                if (is_file($image_path) && file_exists($image_path)) {
                    unlink($image_path);
                }
            }
        }
        
        return redirect('/receptionists');
    }
}