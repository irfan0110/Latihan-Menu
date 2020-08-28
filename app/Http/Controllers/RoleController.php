<?php

namespace App\Http\Controllers;

use App\AccessMenuUser;
use App\Menu;
use App\MenuUser;
use App\Role;
use App\SubMenu;
use App\User;
use App\UserRole;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('roles','asc')->paginate(5);
        return view('roles.index',['roles' => $roles]);
    }

    public function store(Request $request)
    {
        $this->authorize('create',Role::class);
        $validator = $this->validateRequest();
        if($validator->fails()){
            return response()->json(['errors' => $validator->getMessageBag()->toArray()]);
        }

        $roles = new Role;
        $roles->roles= $request->get('roles');
        if($request->status == 'on'){
            $roles->isActive = 1;
        }else{
            $roles->isActive = 0;
        }
        $roles->save();
        return response()->json(['success' => 'Data Berhasil Disimpan']);
    }

    public function update(Request $request)
    {
        $this->authorize('update',Role::class);
        $validator = $this->validateRequest();

        if($validator->fails()){
            return response()->json(['errors' => $validator->getMessageBag()->toArray()]);
        }

        $role = Role::findOrFail($request->id);

        $role->roles = $request->get('roles');
        if($request->status == 'on'){
            $role->isActive = 1;
        }else {
            $role->isActive = 0;
        }

        $role->save();
        return response()->json(['success' => 'Data Behasil di Update']);
    }

    public function validateRequest()
    {
        return Validator::make(request()->all(),[
            'roles' => 'required'
        ]);
    }

    public function addUserRole($id)
    {
        $this->authorize('update',Role::class);
        $role = Role::findOrfail($id);
        $members = UserRole::join('users','users.id','=','user_roles.user_id')
                            ->where('role_id', $role->id)
                            ->orderBy('users.name')
                            ->get();
        $user_id = [];
        foreach($members as $member){
            array_push($user_id,$member->user_id);
        }

        if($members){
            $notmembers = User::whereNotIn('id',$user_id)->get();
        }else {
            $notmembers = User::with('roles')->get();
        }
        
        return view('roles.addUser', ['role' => $role, 'members' => $members, 'notmembers' => $notmembers]);
    }

    public function roleStore(Request $request)
    {
        $this->authorize('update',Role::class);
        DB::beginTransaction();
        try{
            $role_id = $request->get('role_id');
            $delete = UserRole::where('role_id', $role_id)->delete();
            $user = $request->get('member');

            for($i=0; $i<count($user); $i++){
                $data = [
                    'role_id' => $role_id,
                    'user_id' => $user[$i],
                    "created_at" =>  date('Y-m-d H:i:s'),
                    "updated_at" => date('Y-m-d H:i:s')
                ];
            UserRole::insert($data);
            }
        }catch(ValidationException $e){
            DB::rollback();
            return redirect()
            ->back()
            ->withErrors($e->getMessage())
            ->withInput();
        }catch(Exception $e){
            DB::rollback();
            return redirect()
            ->back()
            ->withErrors($e->getMessage())
            ->withInput();
        }
        DB::commit();
        return redirect()->route('roles.addUserRole',['id' => $role_id])->with('status','Data Behasil Diupdate');
    }

    public function accessMenu($id)
    {
        $this->authorize('update',Role::class);
        $menus = Menu::orderBy('menu')->get();
        $submenus = SubMenu::orderBy('menu_id')
                            ->orderBy('order')
                            ->get();
        $roles = Role::findOrFail($id);
        $menusActive = MenuUser::where('role_id', $id)->pluck('menu_id')->toArray();
        $submenusActive = AccessMenuUser::where('role_id',$id)->pluck('submenu_id')->toArray();
        
        return view('roles.addMenus',['roles' => $roles, 'menus' => $menus, 'submenus' => $submenus, 'menuactive' => $menusActive, 'submenuactive' => $submenusActive]);
    }

    public function addMenu(Request $request)
    {
        $this->authorize('update',Role::class);
        DB::beginTransaction();
        try{
            $role_id = $request->get('role_id');
            MenuUser::where('role_id', $role_id)->delete();
            AccessMenuUser::where('role_id', $role_id)->delete();
            $menus = $request->get('menu');
            $submenus = $request->get('submenu');
            
            
            for($i=0; $i<count($menus);$i++){
                $datamenu = [
                    'role_id' => $role_id,
                    'menu_id' => $menus[$i],
                    "created_at" =>  date('Y-m-d H:i:s'),
                    "updated_at" => date('Y-m-d H:i:s')
                ];
                MenuUser::insert($datamenu);
            }

            if($submenus){
                for($i=0; $i<count($submenus); $i++){
                    $dataaccess = [
                        'submenu_id' => $submenus[$i],
                        'role_id' => $role_id,
                        'access' => $request->get('rdsubmenu_'.$submenus[$i]),
                        "created_at" =>  date('Y-m-d H:i:s'),
                        "updated_at" => date('Y-m-d H:i:s')
                    ];
                    AccessMenuUser::insert($dataaccess);
                }
            }
        }catch(Exception $e){
            DB::rollback();
            return redirect()
            ->back()
            ->withErrors($e->getMessage())
            ->withInput();
        }
        DB::commit();
        return redirect()->route('roles.index')->with('status','Data Behasil Diupdate');
    }

    public function delete($id)
    {
        $this->authorize('delete',Role::class);
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('roles.index')->with('status','Data Behasil Dihapus');
    }
}
