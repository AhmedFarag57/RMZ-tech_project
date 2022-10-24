<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Medicine;
use App\Models\Appointment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Medicine_bill;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AppointmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appointments = Appointment::orderBy('id', 'asc')->paginate(10);

        return view('backend.appointments.index')->with('appointments', $appointments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $doctors = Doctor::all();
        if ($doctors->isEmpty()) {
            $title = 'Error';
            $message = "No Doctor Has Assign Yet";
            $route = 'home';
            $action = 'Back to Home.';
            return view('errors.message')->with([
                'title' => $title,
                'message' => $message,
                'route' => $route,
                'action' => $action
            ]);
        }

        $patient = Patient::count();
        if ($patient == 0) {
            return redirect()->route('patients.create');
        }

        return view('backend.appointments.create')->with('doctors', $doctors);
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
            'ssn' => 'required',
            'doc_id' => 'required|numeric',
            'datetime' => 'required'
        ]);

        $patient = Patient::where('ssn', '=', $request->input('ssn'))->get('id');

        if ($patient->isEmpty()) {
            return 'no ssn';
        }

        $status = false;
        $patient_id = $patient[0]['id'];

        Appointment::create([
            'doc_id' => $request->input('doc_id'),
            'patient_id' => $patient_id,
            'appointment_status' => $status,
            'appointment_date' =>$request->input('datetime'),
            'diagnosis' => ''
        ]);

        return redirect()->route('appointments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $appointment = Appointment::find($id);
        return view('backend.appointments.show')->with('appointment', $appointment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $appointment = Appointment::find($id);
        $doctors = Doctor::all();
        return view('backend.appointments.edit')->with([
            'appointment' => $appointment,
            'doctors' => $doctors
        ]);
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
            'doc_id' => 'required|numeric',
            'datetime' => 'required'
        ]);

        $appointment = Appointment::find($id);

        $appointment->update([
            'doc_id' => $request->input('doc_id'),
            'appointment_date' =>$request->input('datetime')
        ]);

        return redirect()->route('appointments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $appointment = Appointment::find($id);
        if ($appointment) {

            $appointment->delete();
            return redirect()->route('appointments.index');
        }

        return redirect()->route('appointments.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function checkout($id)
    {
        $appointment = Appointment::find($id);

        $status = true;

        $appointment->update([
            'appointment_status' => $status
        ]);

        return redirect()->route('appointments.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function doctorIndex()
    {
        $user = Auth::user();

        $appointments = DB::table('appointments')->join('doctors', 'appointments.doc_id', '=', 'doctors.id')
            ->join('patients', 'appointments.patient_id', '=', 'patients.id')
            ->where('doctors.id', $user->doctor->id)
            ->select([
                'appointments.id',
                'patients.name',
                'appointments.appointment_date',
                'appointments.appointment_status'
            ])
            ->paginate(10);

        return view('backend.appointments_doc.index')->with('appointments', $appointments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function doctorCreate($id)
    {
        $appointment = Appointment::find($id);
        $medicines = Medicine::all();
        return view('backend.appointments_doc.create')->with([
            'appointment' => $appointment,
            'medicines' => $medicines
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function doctorStore(Request $request, $id)
    {
        $this->validate($request, [
            'diagnosis' => 'required'
        ]);

        $appointment = Appointment::find($id);
        $status = true;
        $appointment->update([

            'diagnosis' => $request->diagnosis,
            'appointment_status' => $status
        ]);

        return redirect()->route('doctor.appointments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function doctorShow($id)
    {
        $appointment = Appointment::findOrFail($id);

        //$medicine_bill = Medicine_bill::find($appointment->id)->get('medicines_id');
        $medicine_bill = DB::select('SELECT medicines_id FROM medicine_bills WHERE appointment_id = ?', [$appointment->id]);

        $medicines_id = explode(',', $medicine_bill[0]->medicines_id);

        foreach ($medicines_id as $medicine_id) {

            $medicines = Medicine::find($medicine_id)->get('name');
        }

        return view('backend.appointments_doc.show')->with([
            'appointment'=> $appointment,
            'medicines' => $medicines
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function doctorEdit($id)
    {
        $appointment = Appointment::findOrFail($id);

        $medicine_bill = Medicine_bill::find($appointment->id)->get('medicines_id');

        $medicines_id = explode(',', $medicine_bill[0]->medicines_id);

        foreach ($medicines_id as $medicine_id) {

            $medicines = Medicine::find($medicine_id)->get();
        }

        $allMedicines = Medicine::all();

        return view('backend.appointments_doc.edit')->with([
            'appointment'=> $appointment,
            'medicines' => $medicines,
            'allMedicines' => $allMedicines
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function doctorUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'diagnosis' => 'required'
        ]);

        $appointment = Appointment::find($id);
        $appointment->update([

            'diagnosis' => $request->diagnosis
        ]);

        return redirect()->route('doctor.appointments.index');
    }
}
