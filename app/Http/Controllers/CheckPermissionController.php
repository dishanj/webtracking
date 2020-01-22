<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;
use Route;
use DB;

class CheckPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $current_route = Route::currentRouteName();
        $role_id = Sentinel::getUser()->roleId;
        if($role_id != 1 && $current_route != "user.changemypassword"){
            // $result = DB::select(DB::raw(
            //                     "SELECT 
            //                         COUNT(rp.id) AS num
            //                     FROM
            //                         rolePermissions rp
            //                             INNER JOIN
            //                         permissions p ON rp.permissionId = p.id
            //                     WHERE
            //                         rp.roleId = $role_id
            //                             AND p.name = '$current_route'
            //                                 AND rp.status = 1"
            //                 ));
            $result = DB::select(DB::raw(
                                "SELECT 
                                    COUNT(rp.id) AS num
                                FROM
                                    rolePermissions rp
                                        INNER JOIN
                                    permissions p ON rp.permissionId = p.id
                                        INNER JOIN
                                    menuPermissions mp ON mp.permissionId = p.id
                                        INNER JOIN
                                    tbl_menu tm ON tm.id = mp.menuId
                                WHERE
                                    rp.roleId = $role_id
                                        AND p.name = '$current_route'
                                        AND rp.status = 1
                                        AND mp.status = 1
                                        AND tm.status = 1
                                        AND tm.url != '#'"            
                            ));
            return $result[0]->num;
        }
        return 1;
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
    public function store(Request $request)
    {
        //
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
        //
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
        //
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
}
