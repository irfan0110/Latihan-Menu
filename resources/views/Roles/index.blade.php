@extends('layouts.app')

@section('title','Role')

@section('content')
    <div class="container">
        <div class="col-md-12 bg-white shadow-sm p-3">
            <h5>Role Management</h5>
            <div class="alert alert-success" style="display: none;"></div>
            <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#addModalRole"><i class="fa-fa-pencil"></i> Tambah</button><br><br>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no =1; ?>
                        @foreach($roles as $role)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>
                                    <a href="{{ route('roles.addUserRole',['id' => $role->id]) }}" class="badge badge-info">{{ $role->roles}}</a>
                                </td>
                                <td>
                                    @if($role->isActive == 1)
                                        <badge class="success">Active</badge>
                                    @else
                                        <badge class="success">InActive</badge>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn-success btn-sm" data-id="{{ $role->id }}" data-roles="{{ $role->roles}}" data-status="{{ $role->isActive}}" data-toggle="modal" data-target="#editModalRole"><i class="fa fa-edit"></i> Edit</button>
                                    <a href="{{ route('roles.menu',['id' => $role->id])}}" class="btn btn-warning btn-sm"><i class="fa fa-check-square"></i> Access Menu</a>
                                </td>
                            </tr>
                        <?php $no++ ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- modal add -->
     <div class="modal fade" id="addModalRole" tabindex="-1" role="dialog" aria-labelledby="addModalRole" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title ml-3" id="modalTitle">Tambah Role</h5>
                    <button type="button" class="close mr-1" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('roles.store') }}" method="post">
                    <meta name="csrf-token" content="{{ csrf_token() }}" />
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="roles" class="col-sm-4 col-form-label">Roles <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="roles" name="roles">
                                <span class="roles-invalid-feedback text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="status" class="col-sm-4 col-form-label">Status</label>
                            <div class="col-sm-3">
                                <input type="checkbox" name="status" id="status"> Active
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm" id="simpan">Simpan</button>
                    </div>
                </form>
                </div>
            </div>
            </div>
    <!-- end modal add -->

    <!-- modal edit -->
        <div class="modal fade" id="editModalRole" tabindex="-1" role="dialog" aria-labelledby="editModalRole" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title ml-3" id="modalTitle">Edit Role</h5>
                    <button type="button" class="close mr-1" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('roles.update') }}" method="post">
                    <meta name="csrf-token" content="{{ csrf_token() }}" />
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="roles" class="col-sm-4 col-form-label">Roles <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="roles" name="roles">
                                <span class="roles-invalid-feedback text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="status" class="col-sm-4 col-form-label">Status</label>
                            <div class="col-sm-3">
                                <input type="checkbox" name="status" id="status"> Active
                            </div>
                        </div>
                        <input type="hidden" name="id" id="id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm" id="simpan">Simpan</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    <!-- end modal edit -->
@endsection

@section('script')
<script>
    $('#editModalRole').on('show.bs.modal', function(e){
        var button = $(e.relatedTarget);
        var id =button.data('id');
        var roles = button.data('roles');
        var status = button.data('status');

        var modal = $(this);

        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #roles').val(roles);
        if(status == 1){
            modal.find('.modal-body #status').prop('checked', true);
        }
    });


    jQuery(document).ready(function(){
        jQuery('#addModalRole #simpan').click(function(e){
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "{{ url('/role/store') }}",
                method: "post",
                data : {
                    roles : jQuery('#addModalRole .modal-body #roles').val(),
                    status : jQuery('#addModalRole .modal-body #status').val()
                },
                success: function(result){
                    if(result.errors){
                        if(result.errors.roles){
                            jQuery('#addModalRole .modal-body #roles').addClass('is-invalid');
                            jQuery('#addModalRole .modal-body .roles-invalid-feedback').append(result.errors.roles);
                        }
                    }else {
                        $('#addModalRole').modal('hide');
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        jQuery('.alert-success').show();
                        jQuery('.alert-success').append(result.success);
                        setTimeout(function(){
                            location.reload();
                        }, 1000); 
                    }
                }
            });
        });
    })

    jQuery(document).ready(function(){
        jQuery('#editModalRole #simpan').click(function(e){
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "{{ url('/role/update') }}",
                method: "post",
                data : {
                    id : jQuery('#editModalRole .modal-body #id').val(),
                    roles : jQuery('#editModalRole .modal-body #roles').val(),
                    status : jQuery('#editModalRole .modal-body #status').val()
                },
                success: function(result){
                    if(result.errors){
                        if(result.errors.roles){
                            jQuery('#editModalRole .modal-body #roles').addClass('is-invalid');
                            jQuery('#editModalRole .modal-body .roles-invalid-feedback').append(result.errors.roles);
                        }
                    }else {
                        $('#editModalRole').modal('hide');
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        jQuery('.alert-success').show();
                        jQuery('.alert-success').append(result.success);
                        setTimeout(function(){
                            location.reload();
                        }, 1000); 
                    }
                }
            });
        });
    })
</script>
@endsection