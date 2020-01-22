<?php

namespace App\Modules\RoleModule\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CheckPermissionController;
use App\Modules\PermissionModule\Models\PermissionModule;
use App\Modules\RoleModule\Models\RoleModule;
use App\Modules\RoleModule\Models\RolePermissionModule;
use App\Modules\RoleModule\Requests\RoleRequest;
use DB;

class RoleModuleController extends Controller
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
        $data = PermissionModule::where('id','!=',1)->pluck('name','id');
        return view("RoleModule::index")->with(['data' => $data]);
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
    public function store(RoleRequest $request)
    {
        DB::beginTransaction();
        try{
            $permission = $this->check->index();

            if($permission > 0){

                $role_name = $request['role_name'];
                $access = $request['permission'];

                $role = RoleModule::create([
                            "slug" => $role_name,
                            "name" => $role_name
                        ]);

                foreach ($access as $key => $value) {
                    $perm = RolePermissionModule::create([
                                'roleId' => $role->id,
                                'permissionId' => $value,
                                'status' => 1
                            ]);
                }
                
                DB::commit();
                return redirect( 'roles/add' )->with([ 'success' => true,
                        'success.message'=> 'Permission added successfully!',
                        'success.title' => 'Well Done!' ]);
            }else{
                DB::rollBack();
                return redirect( 'roles/add' )->with([ 'warning' => true,
                        'warning.message'=> 'Permission Denied!',
                        'warning.title' => 'Sorry!' ]);
            }
        }catch(\Exception $e){
            DB::rollBack();
            return redirect( 'roles/add' )->with([ 'error' => true,
                'error.message'=> $e->getMessage(),
                'error.title' => 'Ooops!' ]);
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
            $roles = RoleModule::find($id);
            $all_access = PermissionModule::where('id','!=',1)->where('status',1)->pluck('name','id');

            $access = [];
            $access_list = RolePermissionModule::where('roleId',$id)->where('status',1)->get();
            foreach ($access_list as $key => $value) {
                array_push($access, $value->permissionId);
            }
            return view('RoleModule::edit')->with(['roles' => $roles,'access' => $access,'all_access' => $all_access]);

        }else{
            return redirect( 'roles/list' )->with([ 'warning' => true,
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
    public function update(RoleRequest $request)
    {
        DB::beginTransaction();
        try{

            $id = $request['id_txt'];
            $role = $request['role_name'];
            $permission = $request['permission'];

            $role = RoleModule::where('id','=',$id)->update(['name' => $role]);

            $permission_deny = RolePermissionModule::where('roleId',$id)->update(['status' => 0]);
            foreach ($permission as $key => $value) {
                $perm = RolePermissionModule::create([
                            'roleId' => $id,
                            'permissionId' => $value,
                            'status' => 1
                        ]);
            }

            DB::commit();
            return redirect('roles/edit/'.$id )->with(['success' => true,
                'success.message'=> 'Role Updated successfully!',
                'success.title' => 'Well Done!' ]);
        }catch(\Exception $e){
            DB::rollBack();
            return redirect('roles/edit/'.$id )->with(['error' => true,
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

    public function listView()
    {
        $roles = RoleModule::select('roles.id','roles.name',DB::raw("GROUP_CONCAT(permissions.name) AS permission"))
                        ->leftJoin('rolePermissions','rolePermissions.roleId','=','roles.id')
                        ->leftJoin('permissions','permissions.id','=','rolePermissions.permissionId')
                        ->where('roles.id','!=',1)
                        ->where('rolePermissions.status',1)
                        ->groupBy('roles.id')
                        ->paginate(10);
        return view("RoleModule::list")->with(['roles' => $roles]);
    }
}
