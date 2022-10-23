<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NursesController;
use App\Http\Controllers\DoctorsController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\AssignRoleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\PharmacistsController;
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\ReceptionistsController;
use App\Http\Controllers\RolePermissionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
    


Route::get('/', function() {
    return redirect('/login');
});

Auth::routes();
//Route::get('/login', [LoginController::class, 'index'])->name('login');
//Route::post('/login', [LoginController::class, 'store']);

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
Route::get('/profile/edit', [HomeController::class, 'profileEdit'])->name('profile.edit');
Route::put('/profile/update', [HomeController::class, 'profileUpdate'])->name('profile.update');
Route::get('/profile/changepassword', [HomeController::class, 'changePassword'])->name('profile.change.password');
Route::post('/profile/changepassword', [HomeController::class, 'updatePassword'])->name('profile.changepassword');


/**
 * ADMIN ROUTE
 */
Route::group(['middleware' => ['auth', 'role:Admin']], function() {

    // Roles & Permissions
    Route::get('/roles-permissions', [RolePermissionController::class, 'rolesIndex'])->name('roles-permissions');

    // Roles
    Route::get('/roles/create', [RolePermissionController::class, 'rolesCreate'])->name('roles.create');
    Route::post('/roles/store', [RolePermissionController::class, 'rolesStore'])->name('roles.store');
    Route::get('/roles/{id}/edit', [RolePermissionController::class, 'rolesEdit'])->name('roles.edit');
    Route::put('/roles/{id}/update', [RolePermissionController::class, 'rolesUpdate'])->name('roles.update');

    // Permissons
    Route::get('/permissions/create', [RolePermissionController::class, 'permissionsCreate'])->name('permissions.create');
    Route::post('/permissions/store', [RolePermissionController::class, 'permissionsStore'])->name('permissions.store');
    Route::get('/permissions/{id}/edit', [RolePermissionController::class, 'permissionsEdit'])->name('permissions.edit');
    Route::put('/permissions/{id}/update', [RolePermissionController::class, 'permissionsUpdate'])->name('permissions.update');

    // Assign Role
    Route::get('/assign-role', [AssignRoleController::class, 'index'])->name('assign-role.index');
    Route::get('/assign-role/{id}', [AssignRoleController::class, 'show'])->name('assign-role.show')->where('id', '[0-9]+');
    Route::get('/assign-role/create', [AssignRoleController::class, 'create'])->name('assign-role.create');
    Route::post('/assign-role/store', [AssignRoleController::class, 'store'])->name('assign-role.store');
    Route::get('/assign-role/{id}/edit', [AssignRoleController::class, 'edit'])->name('assign-role.edit')->where('id', '[0-9]+');
    Route::put('/assign-role/{id}/update', [AssignRoleController::class, 'update'])->name('assign-role.update')->where('id', '[0-9]+');
    Route::delete('/assign-role/{id}/destroy', [AssignRoleController::class, 'destroy'])->name('assign-role.destroy')->where('id', '[0-9]+');

    // Doctors
    Route::get('/doctors', [DoctorsController::class, 'index'])->name('doctors.index');
    Route::get('/doctors/{id}', [DoctorsController::class, 'show'])->name('doctors.show')->where('id', '[0-9]+');
    Route::get('/doctors/create', [DoctorsController::class, 'create'])->name('doctors.create');
    Route::post('/doctors/store', [DoctorsController::class, 'store'])->name('doctors.store');
    Route::get('/doctors/{id}/edit', [DoctorsController::class, 'edit'])->name('doctors.edit')->where('id', '[0-9]+');
    Route::put('/doctors/{id}/update', [DoctorsController::class, 'update'])->name('doctors.update')->where('id', '[0-9]+');
    Route::delete('/doctors/{id}/destroy', [DoctorsController::class, 'destroy'])->name('doctors.destroy')->where('id', '[0-9]+');

    // Nurses
    Route::get('/nurses', [NursesController::class, 'index'])->name('nurses.index');
    Route::get('/nurses/{id}', [NursesController::class, 'show'])->name('nurses.show')->where('id', '[0-9]+');
    Route::get('/nurses/create', [NursesController::class, 'create'])->name('nurses.create');
    Route::post('/nurses/store', [NursesController::class, 'store'])->name('nurses.store');
    Route::get('/nurses/{id}/edit', [NursesController::class, 'edit'])->name('nurses.edit')->where('id', '[0-9]+');
    Route::put('/nurses/{id}/update', [NursesController::class, 'update'])->name('nurses.update')->where('id', '[0-9]+');
    Route::delete('/nurses/{id}/destroy', [NursesController::class, 'destroy'])->name('nurses.destroy')->where('id', '[0-9]+');

    // Pharmacists
    Route::get('/pharmacists', [PharmacistsController::class, 'index'])->name('pharmacists.index');
    Route::get('/pharmacists/{id}', [PharmacistsController::class, 'show'])->name('pharmacists.show')->where('id', '[0-9]+');
    Route::get('/pharmacists/create', [PharmacistsController::class, 'create'])->name('pharmacists.create');
    Route::post('/pharmacists/store', [PharmacistsController::class, 'store'])->name('pharmacists.store');
    Route::get('/pharmacists/{id}/edit', [PharmacistsController::class, 'edit'])->name('pharmacists.edit')->where('id', '[0-9]+');
    Route::put('/pharmacists/{id}/update', [PharmacistsController::class, 'update'])->name('pharmacists.update')->where('id', '[0-9]+');
    Route::delete('/pharmacists/{id}/destroy', [PharmacistsController::class, 'destroy'])->name('pharmacists.destroy')->where('id', '[0-9]+');

    // Receptionists
    Route::get('/receptionists', [ReceptionistsController::class, 'index'])->name('receptionists.index');
    Route::get('/receptionists/{id}', [ReceptionistsController::class, 'show'])->name('receptionists.show')->where('id', '[0-9]+');
    Route::get('/receptionists/create', [ReceptionistsController::class, 'create'])->name('receptionists.create');
    Route::post('/receptionists/store', [ReceptionistsController::class, 'store'])->name('receptionists.store');
    Route::get('/receptionists/{id}/edit', [ReceptionistsController::class, 'edit'])->name('receptionists.edit')->where('id', '[0-9]+');
    Route::put('/receptionists/{id}/update', [ReceptionistsController::class, 'update'])->name('receptionists.update')->where('id', '[0-9]+');
    Route::delete('/receptionists/{id}/destroy', [ReceptionistsController::class, 'destroy'])->name('receptionists.destroy')->where('id', '[0-9]+');

    // Departments
    Route::get('/departments', [DepartmentsController::class, 'index'])->name('departments.index');
    Route::get('/departments/create', [DepartmentsController::class, 'create'])->name('departments.create');
    Route::post('/departments/store', [DepartmentsController::class, 'store'])->name('departments.store');
    Route::get('/departments/{id}/edit', [DepartmentsController::class, 'edit'])->name('departments.edit')->where('id', '[0-9]+');
    Route::put('/departments/{id}/update', [DepartmentsController::class, 'update'])->name('departments.update')->where('id', '[0-9]+');
    Route::delete('/departments/{id}/destroy', [DepartmentsController::class, 'destroy'])->name('departments.destroy')->where('id', '[0-9]+');

    // Patients
    // Route::get('/patients', [PatientsController::class, 'index'])->name('patients.index');
    // Route::get('/patients/{id}', [PatientsController::class, 'show'])->name('patients.show')->where('id', '[0-9]+');
    // Route::get('/patients/create', [PatientsController::class, 'create'])->name('patients.create');
    // Route::post('/patients/store', [PatientsController::class, 'store'])->name('patients.store');
    // Route::get('/patients/{id}/edit', [PatientsController::class, 'edit'])->name('patients.edit')->where('id', '[0-9]+');
    // Route::put('/patients/{id}/update', [PatientsController::class, 'update'])->name('patients.update')->where('id', '[0-9]+');
    // Route::delete('/patients/{id}/destroy', [PatientsController::class, 'destroy'])->name('patients.destroy')->where('id', '[0-9]+');

});


/**
 * DOCTOR ROUTE
 */
Route::group(['middleware' => ['auth', 'role:Doctor']], function() {

    Route::get('/doctor/appointments', [AppointmentsController::class, 'doctorIndex'])->name('doctor.appointments.index');
    Route::get('/doctor/appointments/{id}', [AppointmentsController::class, 'doctorShow'])->name('doctor.appointments.show')->where('id', '[0-9]+');
    Route::get('/doctor/appointments/{id}/prescription', [AppointmentsController::class, 'doctorCreate'])->name('doctor.appointments.create')->where('id', '[0-9]+');
    Route::post('/doctor/appointments/{id}/prescription', [AppointmentsController::class, 'doctorStore'])->name('doctor.appointments.store')->where('id', '[0-9]+');
    Route::get('/doctor/appointments/{id}/edit', [AppointmentsController::class, 'doctorEdit'])->name('doctor.appointments.edit')->where('id', '[0-9]+');
    Route::put('/doctor/appointments/{id}/update', [AppointmentsController::class, 'doctorUpdate'])->name('doctor.appointments.update')->where('id', '[0-9]+');

});


/**
 * PHARMACIST ROUTE
 */
Route::group(['middleware' => ['auth', 'role:Pharmacist']], function() {

    // Pharmacy
    Route::get('/pharmacy', [PharmacyController::class, 'index'])->name('pharmacy.index');
    Route::get('/pharmacy/add', [PharmacyController::class, 'addToPharmacy'])->name('pharmacy.add');
    Route::post('/pharmacy/store', [PharmacyController::class, 'store'])->name('pharmacy.store');
    Route::get('/pharmacy/{id}/edit', [PharmacyController::class, 'edit'])->name('pharmacy.edit')->where('id', '[0-9]+');
    Route::put('/pharmacy/{id}/update', [PharmacyController::class, 'update'])->name('pharmacy.update')->where('id', '[0-9]+');
    
    // Medicines
    Route::get('/pharmacy/medicines', [PharmacyController::class, 'indexMedicines'])->name('medicines.index');
    Route::get('/pharmacy/medicines/{id}', [PharmacyController::class, 'showMedicines'])->name('medicines.show')->where('id', '[0-9]+');
    Route::get('/pharmacy/medicines/create', [PharmacyController::class, 'createMedicines'])->name('medicines.create');
    Route::post('/pharmacy/medicines/store', [PharmacyController::class, 'storeMedicines'])->name('medicines.store');
    Route::get('/pharmacy/medicines/{id}/edit', [PharmacyController::class, 'editMedicines'])->name('medicines.edit')->where('id', '[0-9]+');
    Route::put('/pharmacy/medicines/{id}/update', [PharmacyController::class, 'updateMedicines'])->name('medicines.update')->where('id', '[0-9]+');
    
});


/**
 * RECEPTIONIST ROUTE
 */
Route::group(['middleware' => ['auth', 'role:Receptionist']], function() {

    // Patients
    Route::get('/patients', [PatientsController::class, 'index'])->name('patients.index');
    Route::get('/patients/{id}', [PatientsController::class, 'show'])->name('patients.show')->where('id', '[0-9]+');
    Route::get('/patients/create', [PatientsController::class, 'create'])->name('patients.create');
    Route::post('/patients/store', [PatientsController::class, 'store'])->name('patients.store');
    Route::get('/patients/{id}/edit', [PatientsController::class, 'edit'])->name('patients.edit')->where('id', '[0-9]+');
    Route::put('/patients/{id}/update', [PatientsController::class, 'update'])->name('patients.update')->where('id', '[0-9]+');

    // Appointments
    Route::get('/appointments', [AppointmentsController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/{id}', [AppointmentsController::class, 'show'])->name('appointments.show')->where('id', '[0-9]+');
    Route::get('/appointments/create', [AppointmentsController::class, 'create'])->name('appointments.create');
    Route::post('/appointments/store', [AppointmentsController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{id}/edit', [AppointmentsController::class, 'edit'])->name('appointments.edit')->where('id', '[0-9]+');
    Route::put('/appointments/{id}/update', [AppointmentsController::class, 'update'])->name('appointments.update')->where('id', '[0-9]+');
    Route::delete('/appointments/{id}/destroy', [AppointmentsController::class, 'destroy'])->name('appointments.destroy')->where('id', '[0-9]+');
    Route::get('/appointments/{id}/checkout', [AppointmentsController::class, 'checkout'])->name('appointments.checkout')->where('id', '[0-9]+');
    
});




