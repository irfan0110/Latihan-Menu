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

function checkSubMenu($role_id,$menu_id,$menu){
    $data = DB::table('access_menu_users')
            ->select('menu_id','url','icon','title')
            ->distinct()
            ->join('sub_menus','access_menu_users.submenu_id','=','sub_menus.id')
            ->whereIn('access_menu_users.role_id', $role_id)
            ->where('sub_menus.menu_id', $menu_id)
            ->get();
    if(count($data) > 0){
        return "id=dropdown{$menu} data-toggle=dropdown aria-haspopup=true aria-expanded=false";
    }
}

function isDropDown($role_id,$menu_id){
    $data = DB::table('access_menu_users')
    ->select('menu_id','url','icon','title')
    ->distinct()
    ->join('sub_menus','access_menu_users.submenu_id','=','sub_menus.id')
    ->whereIn('access_menu_users.role_id', $role_id)
    ->where('sub_menus.menu_id', $menu_id)
    ->get();
    
    if(count($data) > 0){
        return "dropdown";
    }
}

function isDropDownToggle($role_id,$menu_id){
    $data = DB::table('access_menu_users')
    ->select('menu_id','url','icon','title')
    ->distinct()
    ->join('sub_menus','access_menu_users.submenu_id','=','sub_menus.id')
    ->whereIn('access_menu_users.role_id', $role_id)
    ->where('sub_menus.menu_id', $menu_id)
    ->get();
    
    if(count($data) > 0){
        return "dropdown-toggle";
    }
}