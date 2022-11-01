<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function roleIndex()
    {
        $roles = Role::with('permissions')->get();
        return view('backend.roles.index')->with('roles', $roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rolesCreate()
    {
        $permissions = Permission::latest()->get();
        return view('backend.roles.create')->with('permissions', $permissions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function rolesStore(Request $request) {

        $this->validate($request, [
            'name' => 'required|string|max:255|unique:roles'
        ]);

        $role = Role::create(['name' => $request->name]);
        $role->givePermissionTo($request->selectedpermissions);

        return redirect('/roles-permissions');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rolesEdit($id) {

        $role = Role::with('permissions')->find($id);
        $permissions = Permission::latest()->get();

        return view('backend.roles.edit')->with([
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rolesUpdate(Request $request, $id) {

        $this->validate($request, [
            'name' => 'required|string|max:255|unique:roles,name,'.$id
        ]);

        $role = Role::findById($id);
        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->selectedpermissions);

        return redirect('/roles-permissions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return back();
    }

    /**
     * PERMISSIONS CREATE
     */
    public function permissionsCreate() {
        
        $roles = Role::latest()->get();
        $permissions = Permission::latest()->get();

        return view('backend.permissions.create')->with([
            'roles' => $roles,
            'permissions' => $permissions
        ]);
    }

    /**
     * PERMISSIONS STORE
     */
    public function permissionsStore(Request $request) {

        $this->validate($request, [
            'name' => 'required|string|max:255|unique:permissions'
        ]);

        $permission = Permission::create(['name' => $request->name]);
        $permission->assignRole($request->selectedroles);

        $roles = Role::latest()->get();
        $permissions = Permission::latest()->get();

        return view('backend.permissions.create')->with([
            'roles' => $roles,
            'permissions' => $permissions
        ]);
    }

    /**
     * PERMISSIONS EDIT
     */
    public function permissionsEdit($id) {

        $permission = Permission::with('roles')->find($id);
        $roles = Role::latest()->get();

        return view('backend.permissions.edit')->with([
            'roles' => $roles,
            'permissions' => $permission
        ]);
    }

    /**
     * PERMISSIONS UPDATE
     */
    public  function permissionsUpdate(Request $request, $id) {

        $this->validate($request, [
            'name' => 'required|string|max:255|unique:permissions,name,'.$id
        ]);

        $permission = Permission::findById($id);
        $permission->update(['name' => $request->name]);
        $permission->syncRoles($request->selectedroles);

        return redirect('/roles-permissions');
    }

}
