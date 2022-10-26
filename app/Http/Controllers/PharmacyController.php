PharmacyController.php
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
7 Jun 2022 by Ahmed AbdElrahman
Opened
20:38 by me
Created
23 Oct 2022
No description
Viewers can download
<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PharmacyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medicines = DB::table('pharmacies')->join('medicines', 'pharmacies.medicine_id', '=', 'medicines.id')->paginate(10);
        return view('backend.pharmacy.index')->with('medicines', $medicines);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexMedicines()
    {
        $medicines = Medicine::orderBy('id', 'asc')->paginate(10);
        return view('backend.medicines.index')->with('medicines', $medicines);
    }

    public function addToPharmacy() {
        
        $medicines = Medicine::all();

        if ($medicines->isEmpty()) {
            return redirect()->route('medicines.create');
        }

        return view('backend.pharmacy.add')->with('medicines', $medicines);
    }

    public function store(Request $request) {

        $this->validate($request, [
            'medicine_id' => 'required|numeric',
            'quantity' => 'required|numeric'
        ]);

        $pharmacy = new Pharmacy;

        $pharmacy->medicine_id = $request->input('medicine_id');
        $pharmacy->quantity = $request->input('quantity');

        $pharmacy->save();

        return redirect()->route('pharmacy.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createMedicines()
    {
        return view('backend.medicines.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeMedicines(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'manufacturar' => 'required|string|max:255',
            'price' => 'required|numeric'
        ]);
       
        $medicine  = new Medicine();

        $medicine->name = $request->input('name');
        $medicine->manufacturar = $request->input('manufacturar');
        $medicine->price = $request->input('price');

        $medicine->save();
       
        return redirect()->route('medicines.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showMedicines($id)
    {
        $medicine = Medicine::find($id);
        return view('backend.medicines.show')->with('medicine', $medicine);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pharmacy = Pharmacy::find($id);
        $medicine = DB::table('pharmacies')->join('medicines', 'pharmacies.medicine_id', '=', 'medicines.id')->where('medicines.id', '=', $id)->get(['pharmacies.id', 'medicines.name', 'pharmacies.quantity']);
        return view('backend.pharmacy.edit')->with('medicine', $medicine);
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
            'quantity' => 'required|numeric'
        ]);

        $pharmacy = Pharmacy::find($id);
        
        $pharmacy->quantity = $request->input('quantity');

        $pharmacy->save();
        
        return redirect()->route('pharmacy.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editMedicines($id)
    {
        $medicine = Medicine::find($id);
        return view('backend.medicines.edit')->with('medicine', $medicine);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateMedicines(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'manufacturar' => 'required|string|max:255',
            'price' => 'required|numeric'
        ]);
       
        $medicine  = Medicine::find($id);

        $medicine->name = $request->input('name');
        $medicine->manufacturar = $request->input('manufacturar');
        $medicine->price = $request->input('price');

        $medicine->save(); 
       
        return redirect()->route('medicines.index');
    }
}