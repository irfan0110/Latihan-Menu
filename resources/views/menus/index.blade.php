@extends('layouts.app')

@section('title', 'Menu Management')

@section('content')

    <div class="container">
        @if(session('status') == 'Berhasil')
            <div class="alert alert-success">
               Data {{ session('status') }} Disimpan
            </div>
        @elseif(session('status') == 'Gagal')
            <div class="alert alert-danger">
               Data {{ session('status') }} Disimpan
            </div>
        @endif
        <div class="alert alert-success" style="display:none"></div>
        <div class="col-md-12 bg-white shadow-sm p-3">
            <h4>Menu Management</h4>
            <button class="btn-primary btn-sm float-right" data-toggle="modal" data-target="#addModal"><i class="fa fa-pencil"></i> Tambah</button>
            <br><br>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Menu</th>
                            <th>Icon</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        @foreach($menus as $menu)
                            <tr>
                                <td>{{ $no }}</td>
                                <td> {{ $menu->menu }} </td>
                                <td>{{ $menu->icon }}</td>
                                <td> 
                                    @if($menu->isActive == 1)
                                        <badge class="success">Active</badge>
                                    @else
                                        <badge class="danger">InActive</badge>
                                    @endif 
                                </td>
                                <td>
                                    <button class="btn-success btn-sm" data-id="{{ $menu->id }}" data-menu="{{ $menu->menu }}" data-icon="{{ $menu->icon}}" data-order="{{ $menu->order}}" data-status="{{ $menu->isActive }}" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit"></i> Edit</button>
                                </td>
                            </tr>
                        <?php $no++ ?>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="10">
                                {{$menus->appends(Request::all())->links()}}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- modal add -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title ml-3" id="modalTitle">Tambah Menu</h5>
                    <button type="button" class="close mr-1" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('menus.store') }}" method="post">
                    <meta name="csrf-token" content="{{ csrf_token() }}" />
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="menu" class="col-sm-4 col-form-label">Nama Menu <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control {{ $errors->first('menu') ? 'is-invalid' : '' }}" id="menu" name="menu">
                                <span class="menu-invalid-feedback text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="icon" class="col-sm-4 col-form-label">Icon <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control {{ $errors->first('icon') ? 'is-invalid' : '' }}" id="icon" name="icon">
                                <span class="icon-invalid-feedback text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="order" class="col-sm-4 col-form-label">Order <span class="text-danger">*</span></label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control {{ $errors->first('order') ? 'is-invalid' : '' }}" id="order" name="order">
                                <span class="order-invalid-feedback text-danger"></span>
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
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title ml-3" id="modalTitle">Edit Menu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('menus.update') }}" method="post">
                    <meta name="csrf-token" content="{{ csrf_token() }}" />
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="menu" class="col-sm-4 col-form-label">Nama Menu <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control {{ $errors->first('menu') ? 'is-invalid' : '' }}" id="menu" name="menu">
                                <span class="menu-invalid-feedback text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="icon" class="col-sm-4 col-form-label">Icon <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control {{ $errors->first('icon') ? 'is-invalid' : '' }}" id="icon" name="icon">
                                <span class="icon-invalid-feedback text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="order" class="col-sm-4 col-form-label">Order <span class="text-danger">*</span></label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control {{ $errors->first('order') ? 'is-invalid' : '' }}" id="order" name="order">
                                <span class="order-invalid-feedback text-danger"></span>
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
        
    </div>

@endsection

@section('script')
<script>
    $('#editModal').on('show.bs.modal', function (e) {
        var button = $(e.relatedTarget);
        var id= button.data('id');
        var menu= button.data('menu');
        var icon = button.data('icon');
        var order = button.data('order');    
        var status = button.data('status');
        
        var modal = $(this);

        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #menu').val(menu);
        modal.find('.modal-body #icon').val(icon);
        modal.find('.modal-body #order').val(order);

        if(status == 1){
            modal.find('.modal-body #status').prop('checked', true);
        }
    });

    jQuery(document).ready(function() {
        jQuery('#addModal #simpan').click(function(e){
            e.preventDefault();
            $.ajaxSetup({
                headers : {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "{{ url('/menu/store') }}",
                method: 'post',
                data : {
                    menu: jQuery('#addModal .modal-body #menu').val(),
                    icon: jQuery('#addModal .modal-body #icon').val(),
                    order: jQuery('#addModal .modal-body #order').val(),
                    status: jQuery('#addModal .modal-body #status').val()
                },
                success: function(result){
                    if(result.errors){
                        if(result.errors.menu){
                            jQuery('#addModal .modal-body #menu').addClass('is-invalid');
                            jQuery('#addModal .modal-body .menu-invalid-feedback').append(result.errors.menu);
                        }
                        if(result.errors.icon){
                            jQuery('#addModal .modal-body #icon').addClass('is-invalid');
                            jQuery('#addModal .modal-body .icon-invalid-feedback').append(result.errors.icon);
                        }
                        if(result.errors.order){
                            jQuery('#addModal .modal-body #order').addClass('is-invalid');
                            jQuery('#addModal .modal-body .order-invalid-feedback').append(result.errors.order);
                        }
                    }
                    else 
                    {
                        $('#addModal').modal('hide');
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
    });

    jQuery(document).ready(function() {
        jQuery('#editModal #simpan').click(function(e){
            e.preventDefault();
            $.ajaxSetup({
                headers : {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "{{ url('/menu/update') }}",
                method: 'post',
                data : {
                    id: jQuery('#editModal .modal-body #id').val(), 
                    menu: jQuery('#editModal .modal-body #menu').val(),
                    icon: jQuery('#editModal .modal-body #icon').val(),
                    order: jQuery('#editModal .modal-body #order').val(),
                    status: jQuery('#editModal .modal-body #status').val()
                },
                success: function(result){
                    if(result.errors){
                        if(result.errors.menu){
                            jQuery('#editModal .modal-body #menu').addClass('is-invalid');
                            jQuery('#editModal .modal-body .menu-invalid-feedback').append(result.errors.menu);
                        }
                        if(result.errors.icon){
                            jQuery('#editModal .modal-body #icon').addClass('is-invalid');
                            jQuery('#editModal .modal-body .icon-invalid-feedback').append(result.errors.icon);
                        }
                        if(result.errors.order){
                            jQuery('#editModal .modal-body #order').addClass('is-invalid');
                            jQuery('#editModal .modal-body .order-invalid-feedback').append(result.errors.order);
                        }
                    }
                    else 
                    {
                        $('#editModal').modal('hide');
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
    });


</script>
@endsection