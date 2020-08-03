<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $guarded=[];

   public function roles()
   {
       return $this->belongsToMany(Role::class);
   }

   public function users()
   {
       return $this->belongsToMany(User::class,'user_roles', 'id');
   }
}
