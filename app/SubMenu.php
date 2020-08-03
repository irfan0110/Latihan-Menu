<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    public function menus()
    {
        return $this->hasOne(Menu::class, 'id');
    }
}
