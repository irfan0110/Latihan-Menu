<?php

use Illuminate\Support\Facades\DB;

function checkAccesMenu($role_id,$submenu_id,$access){
    $data = DB::table('access_menu_users')
                ->select('access')
                ->where('role_id', $role_id)
                ->where('submenu_id', $submenu_id)
                ->where('access',$access)
                ->first();
        
    if($data){
        return "checked='checked'";
    }
    
}