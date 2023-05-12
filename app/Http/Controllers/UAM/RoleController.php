<?php

namespace App\Http\Controllers\UAM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use DataTables;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:role-list|role_create|role-edit|role-delete',['only'=>['index','store']]);
        $this->middleware('permission:role-create',['only'=>['create','store']]);
        $this->middleware('permission:role-edit',['only'=>['edit','update']]);
        $this->middleware('permission:role-delete',['only'=>['destroy']]);
    }

    public function index(Request $request){

        return view('roles.index');

       // return view('roles.index',compact('roles'))->with('i',($request->input('page',1)-1)*5);
    }

    public function create(){
        $permission = Permission::get();
        return view('roles.create',compact('permission'));
    }

    public function store(Request $request){
        $this->validate($request,[
            'name'=>'required|unique:roles,name',
            'permission'=>'required',
        ]);

        $role = Role::create(['name'=>$request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')->with('success','Role created successfully');
    }

    public function show($id){
        $role = Role::find($id);
        $rolePermission = Permission::join('role_has_permissions','role_has_permissions.permission_id','=','permissions.id')
        ->where('role_has_permissions.role_id','$id')
        ->get();

        return view('roles.show',compact('role','permissions'));
    }

    public function edit($id){
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermission = DB::table('role_has_permissions')->where('role_has_permissions.role_id',$id)
        ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
        ->all();
        return view('roles.edit',compact('role','permission','rolepermissions'));
    }

    public function update(Request $request, $id){
        $this->validate($request,[
            'name'=>'required',
            'permission'=>'required',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));
        return redirect()->route('roles.index')->with('success','Role updated successfully');
    }

    public function destroy($id){
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('roles.index')->with('success','Role deleted successfully');
    }

    public function getListDT(Request $request){
        if($request->ajax()){
            $roles = Role::orderBy('id','DESC');
        return DataTables::of($roles)
        ->addColumn('action',function($row){
            $action = '<a href="'.action([\App\Http\Controllers\UAM\RoleController::class,'edit'],[$row->id]).'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
            $action .= '&nbsp <button data-href="'.action([\App\Http\Controllers\UAM\RoleController::class,'destroy'],[$row->id]).'" class="btn btn-xs btn-danger delete_role_button"><i class="glyphicon glyphicon-trash"></i> Hapus</button>';
            return $action;
        })
        ->rawColumns(['action'])
        ->make(true);
        }
    }
}
