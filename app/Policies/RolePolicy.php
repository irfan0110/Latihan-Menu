<?php

namespace App\Policies;

use App\AccessMenuUser;
use App\Role;
use App\User;
use App\UserRole;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function create(User $user)
    {
        $roles = UserRole::where('user_id', $user->id)->pluck('role_id');
        $access = AccessMenuUser::whereIn('role_id', $roles)
                 ->where('access','>','0')
                 ->where('submenu_id','2')->get();
        return count($access) ? true : false;
    }

    public function update(User $user)
    {
        $roles = UserRole::where('user_id', $user->id)->pluck('role_id');
        $access = AccessMenuUser::whereIn('role_id', $roles)
                 ->where('access','>','1')
                 ->where('submenu_id','2')->get();
        return count($access) ? true : false;
    }

    public function delete(User $user)
    {
        $roles = UserRole::where('user_id', $user->id)->pluck('role_id');
        $access = AccessMenuUser::whereIn('role_id', $roles)
        ->where('access','>','2')
        ->where('submenu_id','2')->get();
        return count($access) ? true : false;
    }
}
