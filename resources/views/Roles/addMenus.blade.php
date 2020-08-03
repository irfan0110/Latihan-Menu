@extends('layouts.app')

@section('title' ,'Add Menus')

@section('content')
    <div class="container">
        <div class="col-md-12 bg-white shadow-sm p-3">
        <h5>Adding Menus</h5>
        <br>
        <h6>Role Name : <i class="badge badge-info">{{ $roles->roles}}</i></h6>
            <div class="row">
                    <div class="col-md-6">
                        <form action="{{ route('roles.addMenu') }}" method="post">
                            @csrf
                            @foreach($menus as $menu)
                                <div class="form-check">
                                    <input class="form-check-input" name="menu[]" type="checkbox" value="{{ $menu->id }}" id="menu_{{ $menu->menu }}" onclick="changeEnable('{{$menu->menu}}')">
                                    <label class="form-check-label" for="menu_{{ $menu->menu }}">
                                        {{ $menu->menu }}
                                    </label>
                                </div>
                                @foreach($submenus as $submenu)
                                    @if($menu->id == $submenu->menu_id)
                                    <div class="form-check">
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <input class="form-check-input" name="submenu[]" type="checkbox" value="{{ $submenu->id }}" id="submenu_{{$menu->menu}}" disabled="disabled">
                                        <label class="form-check-label" for="submenu_{{$submenu->title}}">
                                            {{ $submenu->title }}
                                        </label>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <input class="form-check-input" type="radio" name="rdsubmenu_{{$submenu->id}}" id="submenu_{{$menu->menu}}" value="0" disabled="disabled">
                                        <label class="form-check-label" for="submenu_{{$menu->menu}}">
                                            Read
                                        </label>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <input class="form-check-input" type="radio" name="rdsubmenu_{{$submenu->id}}" id="submenu_{{$menu->menu}}" value="1" disabled="disabled">
                                        <label class="form-check-label" for="submenu_{{$menu->menu}}">
                                            Add
                                        </label>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <input class="form-check-input" type="radio" name="rdsubmenu_{{$submenu->id}}" id="submenu_{{$menu->menu}}" value="2" disabled="disabled">
                                        <label class="form-check-label" for="submenu_{{$menu->menu}}">
                                            Edit
                                        </label>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <input class="form-check-input" type="radio" name="rdsubmenu_{{$submenu->id}}" id="submenu_{{$menu->menu}}" value="3" disabled="disabled">
                                        <label class="form-check-label" for="submenu_{{$menu->menu}}">
                                            Delete
                                        </label>
                                    
                                    </div>
                                    @endif
                                @endforeach
                            @endforeach
                            <input type="hidden" name="role_id" value="{{ $roles->id}}">    
                            <input type="submit" value="Simpan" class="btn btn-primary btn-sm">
                            <a href="{{ route('roles.index')}}" class="btn btn-sm btn-danger">Batal</a>
                        </form>
                    </div>
            </div>
        </div>
    </div>
@endsection('content')
@section('script')
    <script>
        function changeEnable(id)
        {
            var menu = document.querySelectorAll('#submenu_'+id);
            for(i=0; i< menu.length; i++){
                if(menu[i].disabled == true){
                    menu[i].removeAttribute('disabled');
                }else {
                    menu[i].checked = false;
                    menu[i].disabled = true;
                }
                
            }

        }
    </script>
@endsection