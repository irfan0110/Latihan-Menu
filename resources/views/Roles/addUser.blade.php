@extends('layouts.app')

@section('title','Tambah User Role')

@section('content')
    <div class="container">
        <div class="col-md-12 shadow-sm p-3">
            @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <h5>Tambah User Role</h5>
            <br>
            <h6>Role Name : <i class="badge badge-info">{{ $role->roles}}</i></h6>
            <br>
            <form action="{{ route('roles.roleStore') }}" method="post">
                @csrf
                <div class="row">
                    <div class="form-group col-md-5">
                        <h6 class="badge badge-danger">Not Member of Role</h6>
                        <label for="notmember"></label>
                        <select class="custom-select" name="notmember" id="notmember" multiple size="10" width="500px" >
                            @foreach($notmembers as $notmember)
                                <option value="{{ $notmember->id}}">{{ $notmember->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 d-flex justify-content-center flex-column"> 
                        <button type="button" class="btn btn-success btn-sm" onclick="moveRight()">>></button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="moveLeft()"><<</button>
                    </div>
                    <div class="form-group col-md-5">
                        <h6 class="badge badge-success">Member of Role</h6>
                        <label for="member"></label>
                        <select class="custom-select" name="member[]" id="member" multiple size="10" width="500px" >
                            @foreach($members as $member)
                                <option value="{{ $member->user_id}}">{{$member->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <input type="hidden" name="role_id" value="{{ $role->id }}">
                <input type="submit" name="simpan" value="simpan" onclick="validate()" class="btn btn-primary btn-sm">
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function moveRight(){
            $('#notmember option:selected').appendTo('#member');
        }

        function moveLeft(){
            $('#member option:selected').appendTo('#notmember');
        }

        function validate(){
            $("select#member").find("option").prop("selected", true);
        }
        
    </script>
@endsection