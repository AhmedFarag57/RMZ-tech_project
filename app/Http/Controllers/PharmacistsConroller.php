PharmacistsController.php
Who has access

System properties
Type
PHP
Size
5 KB
Storage used
5 KBOwned by Pharos University in Alexandria
Location
samir
Owner
Ahmed AbdElrahman
Modified
4 Jun 2022 by Ahmed AbdElrahman
Opened
20:36 by me
Created
23 Oct 2022
No description
Viewers can download
<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\pharmacist;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class PharmacistsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pharmacists = Pharmacist::orderBy('id', 'asc')->paginate(10);
        return view('backend.pharmacists.index')->with('pharmacists', $pharmacists);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.pharmacists.create');
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


        $user->pharmacist()->create([
            'phone' => $request->phone,
            'gender' => $request->gender,
            'dateofbirth' => $request->dateofbirth,
            'address' => $request->address,
            'salary' => $request->salary,
            'period' => $request->period
        ]);

        $user->assignRole('Pharmacist');
        
        return redirect('/pharmacists');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pharmacist = Pharmacist::find($id);
        return view('backend.pharmacists.show')->with('pharmacist', $pharmacist);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pharmacist = Pharmacist::find($id);
        return view('backend.pharmacists.edit')->with('pharmacist', $pharmacist);
        
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
        $pharmacist = Pharmacist::find($id);
        
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|string|max:255|unique:users,email,'.$pharmacist->user_id,
            'phone' => 'required|string|max:255',
            'gender' => 'required|string',
            'dateofbirth' => 'required|date',
            'address' => 'required|string|max:255',
            'salary' => 'required|numeric',
            'period' => 'required|string'
        ]);

        $user = User::findOrFail($pharmacist->user_id);

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


        $user->pharmacist()->update([
            'phone' => $request->phone,
            'gender' => $request->gender,
            'dateofbirth' => $request->dateofbirth,
            'address' => $request->address,
            'salary' => $request->salary,
            'period' => $request->period,
            
        ]);

        return redirect('/pharmacists');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pharmacist = Pharmacist::find($id);
        $user = User::findOrFail($pharmacist->user_id);

        $user->pharmacist()->delete();

        $user->removeRole('Pharmacist');
        
        if ($user->delete()) {
            if($user->profile_picture != 'avatar.png') {
                $image_path = public_path() . '/images/profile/' . $user->profile_picture;
                if (is_file($image_path) && file_exists($image_path)) {
                    unlink($image_path);
                }
            }
        }
        
        return redirect('/pharmacists');
    }
}