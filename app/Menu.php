<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $guraded =[];

    public function submenus()
    {
        return $this->hasMany(SubMenu::class,'menu_id','id');
    }
}
