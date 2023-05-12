<?php

namespace App\Http\Controllers\UAM;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request){
        $data = User::orderBy('id','DESC')->paginate(5);
        return view('users.index',compact('data'))->with('i',($request->input('page',1)-1)*5);
    }

    public function create(){
        $roles = Role::pluck('name','name')->all();
        return view('users.create',compact('roles'));
    }

    public function store(Request $request){
        $this->validate($request,[
            'name'=>'required',
            'username'=>'required',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|same:confirm-password',
            'roles'=>"required"
        ]);
        $input = $request->all();
        $input['password']=Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));
        return redirect()->route('user.index')->with('success','User Created Success');
    }

    public function show($id){
        $user = User::find($id);
        return view('users.show',compact('user'));
    }

    public function edit($id){
        $user = User::find($id);
        $role = Role::pluck('name','name')->all();
        $userrole = $user->roles->pluck('name','name')->all();

        return view('users.edit',compact('user','roles','userRole'));
    }

    public function update(Request $request, $id){
        $this->validate($request,[
            'name'=>'required',
            'username'=>'required',
            'email'=>'required|email|unique:users,email,'.$id,
            'password'=>'same:confirm-password',
            'roles'=>'required',
        ]);

        $input = $request->all();
        if(!empty($input['password'])){
            $input['password']=Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')->with('success',"User updated successfully");
    }


    public function destroy($id){
        User::find($id)->delete();
        return redirect()->route('users.index')->with('success','User deleted successfully');
    }

    public function searchUser(Request $request){
        $q = $request->q;
        if($q != ""){
        $user = User::where ( 'name', 'LIKE', '%' . $q . '%' )->orWhere ( 'email', 'LIKE', '%' . $q . '%' )->paginate (5)->setPath ( '' );
        $pagination = $user->appends ( array (
           'q' =>  $request->q
         ) );
        if (count ( $user ) > 0)
         return view ( 'users.index' )->withDetails( $user )->withQuery ( $q );
        }
         return view ( 'users.index' )->withMessage( 'No Details found. Try to search again !' );

    }


}
