<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patients = Patient::orderBy('id', 'asc')->paginate(10);
        return view('backend.patients.index')->with('patients', $patients);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.patients.create');
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
            'ssn' => 'required|numeric',
            'phone' => 'required|string|max:11',
            'gender' => 'required|string',
            'dateofbirth' => 'required|date',
            'address' => 'required|string|max:255'
        ]);

        
        $patient = new Patient;

        $patient->name = $request->input('name');
        $patient->ssn = $request->input('ssn');
        $patient->phone = $request->input('phone');
        $patient->gender = $request->input('gender');
        $patient->dateofbirth = $request->input('dateofbirth');
        $patient->address = $request->input('address');
        
        $patient->save();
        
        return redirect('/patients');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $patient =  Patient::find($id);
        return view('backend.patients.show')->with('patient', $patient);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $patient = Patient::find($id);
        return view('backend.patients.edit')->with('patient', $patient);
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
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'ssn' => 'required|numeric',
            'phone' => 'required|string|max:11|min:11',
            'gender' => 'required|string',
            'dateofbirth' => 'required|date',
            'address' => 'required|string|max:255'
        ]);

        
        $patient = Patient::find($id);

        $patient->name = $request->input('name');
        $patient->ssn = $request->input('ssn');
        $patient->phone = $request->input('phone');
        $patient->gender = $request->input('gender');
        $patient->dateofbirth = $request->input('dateofbirth');
        $patient->address = $request->input('address');
        
        $patient->save();
        
        return redirect('/patients');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
