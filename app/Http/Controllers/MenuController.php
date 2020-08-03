<?php

namespace App\Http\Controllers;

use App\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::orderBy('order')->paginate(1);
        return view('menus.index', ['menus' => $menus]);
    }

    public function store(Request $request)
    {
        $validator = $this->validateRequest();
        if($validator->fails()){
            return response()->json(['errors' =>$validator->getMessageBag()->toArray()]);
        }

        $menus = new Menu;

        $menus->menu = $request->get('menu');
        $menus->icon = $request->get('icon');
        $menus->order = $request->get('order');
        if($request->get('status') == 'on'){
            $menus->isActive = 1;
        }else {
            $menus->isActive = 0;
        }
        $menus->save();
        return response()->json(['success' => 'Data Berhasil Di Simpan']);
    }

    public function update(Request $request)
    {
        
        $validator = $this->validateRequest();
        if($validator->fails()){
            return response()->json(['errors' =>$validator->getMessageBag()->toArray()]);
        }
        
        $menu = Menu::findOrFail($request->id);

        $menu->menu= $request->get('menu');
        $menu->icon= $request->get('icon');
        $menu->order= $request->get('order');
        if($request->get('status') == 'on'){
            $menu->isActive = 1;
        }else {
            $menu->isActive = 0;
        }
        $menu->save();
        return response()->json(['success' => 'Data Berhasil Di Update']);
    }

    public function validateRequest()
    {
        return Validator::make(request()->all(),[
            'menu' => 'required|string',
            'icon' => 'required',
            'order' => 'required|numeric'
        ]);
    }
}
