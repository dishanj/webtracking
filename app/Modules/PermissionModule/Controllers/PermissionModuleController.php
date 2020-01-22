<?php

namespace App\Modules\PermissionModule\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\PermissionModule\Requests\PermissionRequest;
use App\Http\Controllers\CheckPermissionController;
use App\Modules\PermissionModule\Models\PermissionModule;
use DB;

class PermissionModuleController extends Controller
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
        return view("PermissionModule::index");
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
    public function store(PermissionRequest $request)
    {
        DB::beginTransaction();
        try{
            $permission = $this->check->index();

            if($permission > 0){

                $permission = $request['permission'];
                PermissionModule::create([
                    "name" => $permission,
                    "status" => STATUS_ACTIVE
                ]);
                DB::commit();
                return redirect( 'permission/add' )->with([ 'success' => true,
                        'success.message'=> 'Permission added successfully!',
                        'success.title' => 'Well Done!' ]);
            }else{
                return redirect( 'permission/add' )->with([ 'warning' => true,
                        'warning.message'=> 'Permission Denied!',
                        'warning.title' => 'Sorry!' ]);
            }
        }catch(\Exception $e){
            DB::rollBack();
            return redirect( 'permission/add' )->with([ 'error' => true,
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
            $data = PermissionModule::find($id);
            return view('PermissionModule::edit')->with(['data' => $data]);

        }else{
            return redirect( 'permission/list' )->with([ 'warning' => true,
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
    public function update(PermissionRequest $request)
    {
        DB::beginTransaction();
        try{
            $permission = $request['permission'];
            $id = $request['id_txt'];
            
            $data = PermissionModule::find($id);
            $data->name = $permission;
            $data->save();

            DB::commit();
            return redirect('permission/edit/'.$id )->with(['success' => true,
                'success.message'=> 'Employee Updated successfully!',
                'success.title' => 'Well Done!' ]);
        }catch(\Exception $e){
            DB::rollBack();
            return redirect('permission/edit/'.$id )->with(['error' => true,
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
        $permission = PermissionModule::paginate(10);
        return view("PermissionModule::list")->with(['permission' => $permission]);
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

                $data = PermissionModule::find($id);
                $data->status = $status_bool;
                $data->save();

                DB::commit();
                return 1;
            }else{
                DB::rollBack();
                return 0;
            }
        }catch(\Exception $e){
            DB::rollBack();
            return redirect('permission/list');
        }
    }
}
