<?php

namespace App\Modules\MenuModule\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CheckPermissionController;
use App\Modules\MenuModule\Requests\MenuRequest;
use App\Modules\PermissionModule\Models\PermissionModule;
use App\Modules\MenuModule\Models\MenuModule;
use App\Modules\MenuModule\Models\IconModule;
use App\Modules\MenuModule\Models\MenuPermissionModule;
use DB;

class MenuModuleController extends Controller
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

            $icon = IconModule::select(DB::raw("CONCAT(unicode,' ',icon) AS icon"),'id')->pluck('icon','id');
            $icon->prepend('Select Icon','');
            $menus = MenuModule::pluck('menu_name','id');
            $menus->prepend('Select Parent',0);
            $access = PermissionModule::where('id','!=',1)->pluck('name','id');
            return view("MenuModule::index")->with(['icon' => $icon,'menus' => $menus,'access' => $access]);
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
    public function store(MenuRequest $request)
    {
        DB::beginTransaction();
        try{
            
            $label = $request['labels'];
            $icon_id = $request['menu_icon'];
            $url = $request['menu_url'];
            $parent = $request['parent_menu'];
            $permission = $request['permission'];

            $icon_ar = IconModule::where('id','=',$icon_id)->first();
            $icon = 'fa '.$icon_ar->icon;
            $sequence = MenuModule::where('parent_id','=',$parent)->count() + 1;
            
            $menu = MenuModule::create([
                        'menu_name' => $label,
                        'url' => $url,
                        'parent_id' => $parent,
                        'icon' => $icon,
                        'icon_id' => $icon_id,
                        'sequence' => $sequence,
                        'status' => STATUS_ACTIVE
                    ]);
            foreach ($permission as $key => $value) {
                $perm = MenuPermissionModule::create([
                            'permissionId' => $value,
                            'menuId' => $menu->id,
                            'status' => STATUS_ACTIVE
                        ]);
            }
            DB::commit();
            return redirect( 'menu/add' )->with([ 'success' => true,
                'success.message'=> 'Menu added successfully!',
                'success.title' => 'Well Done!' ]);
        }catch(\Exception $e){
            DB::rollBack();
            return redirect( 'menu/add' )->with([ 'error' => true,
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

            $all_icon = IconModule::select(DB::raw("CONCAT(unicode,' ',icon) AS icon"),'id')->pluck('icon','id');
            $all_icon->prepend('Select Icon','');
            $all_menu = MenuModule::pluck('menu_name','id');
            $all_menu->prepend('Select Parent',0);
            $all_role = PermissionModule::where('id','!=',1)->pluck('name','id');

            $access = [];
            $selected_menu = MenuModule::find($id);
            $permission_list = MenuPermissionModule::where('menuId',$id)->where('status',STATUS_ACTIVE)->get();

            foreach ($permission_list as $key => $value) {
                array_push($access, $value->permissionId);
            }
            return view('MenuModule::edit')->with(['all_icon' => $all_icon,
                                        'all_menu' => $all_menu,
                                        'all_role' => $all_role,
                                        'selected_menu' =>$selected_menu,
                                        'permission_roles' => $access,
                                        'menu_id' => $id]);

        }else{
            return redirect( 'menu/list' )->with([ 'warning' => true,
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
    public function update(MenuRequest $request)
    {
        DB::beginTransaction();
        try{
            $menu_id = $request['menu_id'];
            $label = $request['labels'];
            $icon_id = $request['menu_icon'];
            $url = $request['menu_url'];
            $parent = $request['parent_menu'];
            $permission = $request['permission'];

            $icon_ar = IconModule::where('id','=',$icon_id)->first();
            $icon = 'fa '.$icon_ar->icon;
            
            $menus = MenuModule::find($menu_id);
            $menus->menu_name = $label;
            $menus->url = $url;
            $menus->parent_id = $parent;
            $menus->icon = $icon;
            $menus->icon_id = $icon_id;
            $menus->save();

            if(sizeof($permission) > 0){
                $permission_deny = MenuPermissionModule::where('menuId',$menu_id)->update(['status' => 0]);
                foreach ($permission as $key => $value) {
                    $perm = MenuPermissionModule::create([
                                'permissionId' => $value,
                                'menuId' => $menu_id,
                                'status' => STATUS_ACTIVE
                            ]);
                }
            }
            DB::commit();
            return redirect('menu/edit/'.$menu_id )->with(['success' => true,
                'success.message'=> 'Menu Updated successfully!',
                'success.title' => 'Well Done!' ]);
        }catch(\Exception $e){
            DB::rollBack();
            return redirect('menu/edit/'.$menu_id )->with(['error' => true,
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
        $permission = $this->check->index();

        if($permission > 0){

            $all_menu = MenuModule::select('tbl_menu.id','tbl_menu.menu_name','tbl_menu.icon','tbl_menu.status','tp.menu_name as parent')
                        ->leftJoin('tbl_menu as tp','tp.id','=','tbl_menu.parent_id')
                        ->paginate(10);
            return view("MenuModule::list")->with(['data' => $all_menu]);    

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

                $menus = MenuModule::find($id);
                $menus->status = $status_bool;
                $menus->save();

                DB::commit();
                return 1;

            }else{
                DB::rollBack();
                return 0;
            }
        }catch(\Exception $e){
            DB::rollBack();
            return redirect('menu/list');
        }
    }
}
