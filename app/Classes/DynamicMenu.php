<?php

/**
 * @Author: Thisaru
 * @Date:   2018-04-02 12:07:06
 * @Last Modified by:   Thisaru
 * @Last Modified time: 2018-10-17 16:32:00
 */
namespace App\Classes;

use Auth;
use Sentinel;
use DB;


/**
* 
*/
class DynamicMenu 
{
	

	static function generateMenu($items = array(), $parent_id = 0)
	{
		if(Sentinel::check()){
			$role_id = Sentinel::getUser()->roleId;
			if($role_id == 1){
				$items = DB::select(DB::raw(
							"SELECT 
							    tm.id,
							    tm.menu_name,
							    tm.url,
							    tm.parent_id,
							    tm.icon,
							    tm.icon_id,
							    tm.sequence,
							    tm.status
							FROM
							    tbl_menu tm
							WHERE
							    tm.status = 1
							GROUP BY tm.id
							ORDER BY tm.parent_id , tm.sequence ASC"
						));
			}else{
				$items = DB::select(DB::raw(
							"SELECT 
							    tm.id,
							    tm.menu_name,
							    tm.url,
							    tm.parent_id,
							    tm.icon,
							    tm.icon_id,
							    tm.sequence,
							    tm.status
							FROM
							    rolePermissions rp
							        INNER JOIN
							    menuPermissions mp ON mp.permissionId = rp.permissionId
							        INNER JOIN
							    tbl_menu tm ON tm.id = mp.menuId
							WHERE
							    rp.roleId = $role_id AND rp.status = 1 AND tm.status = 1
							GROUP BY mp.menuId
							ORDER BY tm.parent_id , tm.sequence ASC"
						));
			}

			$tree = "";
			if(count($items) > 0){
				foreach ($items as $key => $value) {
			    	if($value->parent_id == $parent_id){
			    		if($value->url == "#"){
				    		$tree .= 	"<li class=\"treeview\">";
			    		}else{
			    			$tree .= 	"<li>";
			    		}
			    		$tree .= 	"<a href=". url($value->url) ." >";
			    		$tree .=  		"<i class=\"".$value->icon."\"></i><span>".$value->menu_name ."</span>";
			    		$tree .= 	"</a>";
			    		$tree .= 	"<ul class=\"treeview-menu\" >";
			    		$tree .= 		DynamicMenu::generateMenu($value, $value->id);
			    		$tree .= 	"</ul>";
			    		$tree .= "</li>";
			    	}
			    }
			}
		    return $tree;
				
		}
	}
}