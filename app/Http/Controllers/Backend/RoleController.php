<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Exports\PermissionExport;
use App\Imports\PermissionImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use DB;

class RoleController extends Controller
{
    public function AllPermission(){
        $permissions = Permission::latest()->get();
        return view('backend.pages.permission.all_permission', compact('permissions'));
    }

    public function AddPermission(){
        return view('backend.pages.permission.add_permission');
    }

    public function StorePermission(Request $request){
        $permission = Permission::create([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);

        $notification = array(
            'message' => 'Quyền đã được tạo thành công',
            'alert-type' => 'success'
        );
        return redirect()->route('all.permission')->with('message', 'Quyền đã được tạo thành công')->with('alert-type', 'success');
    }

    public function EditPermission($id){
        $permission = Permission::find($id);
        return view('backend.pages.permission.edit_permission', compact('permission'));
    }

    public function UpdatePermission(Request $request){
        $per_id = $request->id;
        Permission::find($per_id)->update([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);

        $notification = array(
            'message' => 'Quyền đã được cập nhật thành công',
            'alert-type' => 'success'
        );
        return redirect()->route('all.permission')->with('message', 'Quyền đã được cập nhật thành công')->with('alert-type', 'success');
    }

    public function DeletePermission($id){
        Permission::find($id)->delete();

        $notification = array(
            'message' => 'Quyền đã được xóa thành công',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Quyền đã được xóa thành công')->with('alert-type', 'success');
    }

    public function ImportPermission(){
        return view('backend.pages.permission.import_permisson');
    }

    public function Export(){
        return Excel::download(new PermissionExport, 'permissions.xlsx');
    }

    public function Import(Request $request){
        Excel::import(new PermissionImport, $request->file('import_file'));

        $notification = array(
            'message' => 'Nhập quyền thành công',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Nhập quyền thành công')->with('alert-type', 'success');
    }

    public function AllRoles(){
        $roles = Role::latest()->get();
        return view('backend.pages.roles.all_roles', compact('roles'));
    }

    public function AddRoles(){
        return view('backend.pages.roles.add_roles');
    }

    public function StoreRoles(Request $request){
        Role::create([
            'name' => $request->name,
        ]);

        $notification = array(
            'message' => 'Vai trò đã được tạo thành công',
            'alert-type' => 'success'
        );
        return redirect()->route('all.roles')->with('message', 'Vai trò đã được tạo thành công')->with('alert-type', 'success');
    }

    public function EditRoles($id){
        $roles = Role::find($id);
        return view('backend.pages.roles.edit_roles', compact('roles'));
    }

    public function UpdateRoles(Request $request){
        $role_id = $request->id;
        Role::find($role_id)->update([
            'name' => $request->name,
        ]);

        $notification = array(
            'message' => 'Vai trò đã được cập nhật thành công',
            'alert-type' => 'success'
        );
        return redirect()->route('all.roles')->with('message', 'Vai trò đã được cập nhật thành công')->with('alert-type', 'success');
    }

    public function DeleteRoles($id){
        Role::find($id)->delete();
        $notification = array(
            'message' => 'Vai trò đã được xóa thành công',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Vai trò đã được xóa thành công')->with('alert-type', 'success');
    }

    public function AddRolesPermission(){
        $roles = Role::all();
        $permissions = Permission::all();
        $permission_groups = User::getpermissionGroups();
        return view('backend.pages.rolesetup.add_roles_permission', compact('roles', 'permissions', 'permission_groups'));
    }

    public function RolePermissionStore(Request $request){
        $data = array();
        $permissions = $request->permission;
        foreach($permissions as $key => $item){
            $data['role_id'] = $request->role_id;
            $data['permission_id'] = $item;

            DB::table('role_has_permissions')->insert($data);
        }

        $notification = array(
            'message' => 'Quyền vai trò đã được thêm thành công',
            'alert-type' => 'success'
        );
        return redirect()->route('all.roles.permission')->with('message', 'Quyền vai trò đã được thêm thành công')->with('alert-type', 'success');
    }

    public function AllRolesPermission(){
        $roles = Role::all();
        return view('backend.pages.rolesetup.all_roles_permission', compact('roles'));
    }

    public function AdminEditRoles($id){
        $role = Role::find($id);
        $permissions = Permission::all();
        $permission_groups = User::getpermissionGroups();
        return view('backend.pages.rolesetup.edit_roles_permission', compact('role', 'permissions', 'permission_groups'));
    }

    public function AdminRolesUpdate(Request $request, $id){
        $role = Role::find($id);

        if (!empty($request->permission)) {
            $permissions = Permission::whereIn('id', $request->permission)->get();
            $role->syncPermissions($permissions);
        }

        $notification = array(
            'message' => 'Quyền vai trò đã được cập nhật thành công',
            'alert-type' => 'success'
        );
        return redirect()->route('all.roles.permission')->with('message', 'Quyền vai trò đã được cập nhật thành công')->with('alert-type', 'success');
    }

    public function AdminDeleteRoles($id){
        $role = Role::find($id);
        if(!is_null($role)){
            $role->delete();
        }

        $notification = array(
            'message' => 'Quyền vai trò đã được xóa thành công',
            'alert-type' => 'success'
        );
        return redirect()->back()->with('message', 'Quyền vai trò đã được xóa thành công')->with('alert-type', 'success');
    }
}
