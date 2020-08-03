<?php

namespace App\Http\Controllers;

use App\Menu;
use App\SubMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubMenuController extends Controller
{
    public function index()
    {
        $submenus = SubMenu::with('menus')->orderBy('title')->paginate(5);
        $menus = Menu::orderBy('menu')->get();
        return view('Submenus.index', ['submenus' => $submenus, 'menus' => $menus]);
    }

    public function store(Request $request)
    {
        $validtor = $this->validateRequest();

        if($validtor->fails()){
            return response()->json(['errors' => $validtor->getMessageBag()->toArray()]);
        }

        $submenu = new SubMenu;
        $submenu->menu_id = $request->get('menu');
        $submenu->title = $request->get('title');
        $submenu->url = $request->get('url');
        $submenu->icon = $request->get('icon');
        $submenu->order = $request->get('order');

        if($request->status == 'on'){
            $submenu->is_active = 1;
        }else {
            $submenu->is_active = 0;
        }

        $submenu->save();
        return response()->json(['success' => 'Data Berhasil Disimpan']);
    }

    public function update(Request $request)
    {
        $validtor = $this->validateRequest();

        if($validtor->fails()){
            return response()->json(['errors' => $validtor->getMessageBag()->toArray()]);
        }

        $submenus = SubMenu::findOrFail($request->id);
        $submenus->menu_id = $request->get('menu');
        $submenus->title = $request->get('title');
        $submenus->url = $request->get('url');
        $submenus->icon = $request->get('icon');
        $submenus->order = $request->get('order');

        if($request->status == 'on'){
            $submenus->is_active = 1;
        }else {
            $submenus->is_active = 0;
        }
        $submenus->save();
        return response()->json(['success' =>'Data Berhasil Diupdate']);

    }

    public function validateRequest()
    {
        return Validator::make(request()->all(),[
            'menu' => 'required',
            'title' => 'required',
            'url' => 'required',
            'icon' => 'required',
            'order' => 'required'
        ]);
    }
}

