<?php

namespace App\Modules\UserModule\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\UserModule\Requests\UserRequest;
use App\Http\Controllers\CheckPermissionController;
use App\User;
use App\Modules\MenuModule\Models\MenuModule;
use App\Modules\MenuModule\Models\IconModule;
use App\Modules\MenuModule\Models\MenuPermissionModule;
use App\Modules\RoleModule\Models\RoleModule;
use Illuminate\Support\Facades\Validator;
use Route;
use Sentinel;
use DB;
use Hash;

class UserModuleController extends Controller
{

    public function __construct()
    {
        $this->check = new CheckPermissionController();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permission = $this->check->index();

        if($permission > 0){
            $role = RoleModule::where('id','!=',1)->pluck('name','id');
            $role->prepend('Select Role','');

            return view("UserModule::index")->with(['role' => $role]);
        }else{
            return redirect( '/' )->with([ 'warning' => true,
                    'warning.message'=> 'Permission Denied!',
                    'warning.title' => 'Sorry!' ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        DB::beginTransaction();
        try{
            $user_name = $request['user_name'];
            $password = $request['password'];
            $first_name = $request['first_name'];
            $last_name = $request['last_name'];
            $user_role  = $request['user_role'];

            $user = Sentinel::registerAndActivate([
                'email'  => $user_name,
                'password'   => $password,
                'first_name' => $first_name,
                'last_name'  => $last_name    
            ]);
            $role = Sentinel::findRoleById($user_role);
            $role->users()->attach($user);

            $usertbl = User::find($user->id);
            $usertbl->roleId = $user_role;
            $usertbl->status = 1;
            $usertbl->save();

            DB::commit();
            return redirect( 'user/add' )->with([ 'success' => true,
                'success.message'=> 'User added successfully!',
                'success.title' => 'Well Done!' ]);

        }catch(\Exception $e){
            DB::rollBack();
            return redirect( 'user/add' )->with([ 'error' => true,
                'error.message'=> $e->getMessage(),
                'error.title' => 'Ooops!' ]);
            // return response()->json(["status" => "Something went wrong"],400);
        }
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
    public function edit($id)
    {
        $permission = $this->check->index();

        if($permission > 0){

            $user = User::find($id);
            $all_role = RoleModule::where('id','!=',1)->pluck('name','id');
            $all_role->prepend('Select Role','');

            $merchant = MerchantModule::where('status',2)->pluck('name','id');
            $merchant->prepend('Select Merchant','');

            return view("UserModule::edit")->with(['user' => $user,
                                                    'all_role' => $all_role,
                                                    'merchant' => $merchant
                                                ]);
        }else{
            return redirect( '/' )->with([ 'warning' => true,
                    'warning.message'=> 'Permission Denied!',
                    'warning.title' => 'Sorry!' ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'user_role' => 'required',
        ]);

        DB::beginTransaction();
        try{

            $id = $request['user_id'];
            $first_name = $request['first_name'];
            $last_name = $request['last_name'];
            $role = $request['user_role'];

            $user = User::find($id);
            $user->roleId = $role;
            $user->first_name = $first_name;
            $user->last_name = $last_name;
            $user->save();

            DB::commit();
            return redirect('user/edit/'.$id )->with(['success' => true,
                'success.message'=> 'User Updated successfully!',
                'success.title' => 'Well Done!' ]);
        }catch(\Exception $e){
            DB::rollBack();
            return redirect('user/edit/'.$id )->with(['error' => true,
                'error.message'=> $e->getMessage(),
                'error.title' => 'Ooops!' ]);
        }
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


    public function listView(Request $request)
    {
        $permission = $this->check->index();

        if($permission > 0){

            if(isset($request->roles) && $request->roles != 0){
                $user = User::select('users.id','users.email','roles.name','users.status','roles.name as role',DB::raw("CONCAT(users.first_name,' ',users.last_name) AS name"))
                            ->join('roles','roles.id','=','users.roleId')
                            ->where('roles.id','!=',1)
                            ->where('users.roleId','=',$request->roles)
                            ->paginate(10);    
            }else{
                $user = User::select('users.id','users.email','roles.name','users.status','roles.name as role',DB::raw("CONCAT(users.first_name,' ',users.last_name) AS name"))
                            ->join('roles','roles.id','=','users.roleId')
                            ->where('roles.id','!=',1)
                            ->paginate(10);
            }
            $roles = RoleModule::where('id','!=',1)->pluck('name','id');    
            $roles->prepend('All Roles',0); 

            return view("UserModule::list")->with(['roles' => $roles,'user' => $user]);
        }else{
            return redirect( '/' )->with([ 'warning' => true,
                    'warning.message'=> 'Permission Denied!',
                    'warning.title' => 'Sorry!' ]);
        }
    }

    public function changeStatus(Request $request)
    {
        $status = $request->status;
        $id = $request->id;
        if($status == "true"){
            $status_bool = 1;
        }else{
            $status_bool = 0;
        }
        DB::beginTransaction();
        try{
            $permission = $this->check->index();

            if($permission > 0){

                $user = User::find($id);
                $user->status = $status_bool;
                $user->save();

                DB::commit();
                return 1;

            }else{
                DB::rollBack();
                return 0;
            }
        }catch(\Exception $e){
            DB::rollBack();
            return redirect('user/list');
        }
    }

    public function changePwdView($id)
    {
        $permission = $this->check->index();

        if($permission > 0){

            return view("UserModule::change-password")->with(['id' => $id]);
        }else{
            return redirect( '/' )->with([ 'warning' => true,
                    'warning.message'=> 'Permission Denied!',
                    'warning.title' => 'Sorry!' ]);
        }            
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'password_confirm' => 'required'
        ]);

        $id = $request['user_id'];
        $pwd = $request['password'];

        DB::beginTransaction();
        try{
            $user = User::find($id);
            $user->password = Hash::make($pwd);
            $user->save();
            DB::commit();
            return redirect('user/reset/'.$id)->with(['success' => true,
                'success.message'=> 'Password Updated successfully!',
                'success.title' => 'Well Done!' ]);
        }catch(\Exception $e){
            DB::rollBack();
            return redirect('user/reset/'.$id)->with(['error' => true,
                'error.message'=> $e->getMessage(),
                'error.title' => 'Ooops!' ]);
        }
    }

    public function changeMyPassword()
    {
        $permission = $this->check->index();

        if($permission > 0){
            return view("UserModule::change-my-password");
        }else{
            return redirect( '/' )->with([ 'warning' => true,
                'warning.message'=> 'Permission Denied!',
                'warning.title' => 'Sorry!' ]);
        }
    }

    public function updateMyPassword(Request $request)
    {

        $user = Sentinel::getUser();

        $validator =  Validator::make($request->all(), [
            'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!\Hash::check($value, $user->password)) {
                    return $fail(__('The current password is incorrect.'));
                }
            }],
            'password' => 'required|min:6',
            'password_confirmation' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('user/change-my-password'.$request->get('reset_token'))
                ->withErrors($validator)
                ->withInput();
        }

        $user->password = Hash::make($request->get('password'));
        $user->save();

        return redirect( 'user/profile' )->with([ 'success' => true,
            'success.message'=> 'Password updated Successfully!',
            'success.title' => 'Well Done!' ]);
    }

    public function profile()
    {
        $permission = $this->check->index();

        if($permission > 0){
            return view("UserModule::profile");
        }else{
            return redirect( '/' )->with([ 'warning' => true,
                'warning.message'=> 'Permission Denied!',
                'warning.title' => 'Sorry!' ]);
        }
    }
}
