@extends('layouts.app')

@section('title','Sub Menu')

@section('content')
    <div class="container">
        <div class="alert alert-success" style="display:none"></div>
        <div class="col-md-12 bg-white shadow-sm p-3">
            <h4>Sub Menu Management</h4>
            <br><br>
            <button class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#addSubmenu"><i class="fa fa-pencil"></i> Tambah</button>
            <br><br>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Menu</th>
                            <th>Title</th>
                            <th>Url</th>
                            <th>Icon</th>
                            <th>Status</th>
                            <th>Order</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($submenus as $submenu)
                            <tr>
                                <td>{{ $loop->iteration}}</td>
                                <td>{{ $submenu->menus->menu}}</td>
                                <td>{{ $submenu->title }}</td>
                                <td>{{ $submenu->url }}</td>
                                <td>{{ $submenu->icon }}</td>
                                <td>
                                    @if($submenu->is_active == 1)
                                        <badge class="badge badge-success">Active</badge>
                                    @else
                                        <badge class="badge badge-danger">InActive</badge>
                                    @endif
                                </td>
                                <td>{{ $submenu->order }}</td>
                                <td>
                                    <button class="btn btn-sm btn-success" 
                                        data-id="{{ $submenu->id}}" 
                                        data-menu="{{ $submenu->menus->id }}" 
                                        data-title="{{ $submenu->title }}" 
                                        data-url="{{ $submenu->url }}" 
                                        data-icon="{{ $submenu->icon }}" 
                                        data-order ="{{ $submenu->order }}"
                                        data-status="{{ $submenu->is_active }}"
                                        data-toggle="modal" 
                                        data-target="#editSubmenu"><i class="fa fa-edit"></i>Edit</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- modal add -->
      <div class="modal fade" id="addSubmenu" tabindex="-1" role="dialog" aria-labelledby="addSubmenu" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title ml-3" id="modalTitle">Tambah Sub Menu</h5>
                <button type="button" class="close mr-1" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('submenu.store') }}" method="post">
                <meta name="csrf-token" content="{{ csrf_token() }}" />
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="menu" class="col-sm-4 col-form-label">Menu <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <select class="custom-select" name="menu" id="menu">
                                <option value="">Pilih Menu</option>
                                @foreach($menus as $menu)
                                    <option value="{{ $menu->id}}"> {{ $menu->menu }}</option>
                                @endforeach
                            </select>
                            <span class="menu-invalid-feedback text-danger"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="title" class="col-sm-4 col-form-label">Title Sub Menu <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="title" name="title">
                            <span class="title-invalid-feedback text-danger"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="url" class="col-sm-4 col-form-label">Url <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="url" name="url">
                            <span class="url-invalid-feedback text-danger"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="icon" class="col-sm-4 col-form-label">Icon <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="icon" name="icon">
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
     <div class="modal fade" id="editSubmenu" tabindex="-1" role="dialog" aria-labelledby="editSubmenu" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title ml-3" id="modalTitle">Edit Sub Menu</h5>
                <button type="button" class="close mr-1" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('submenu.update') }}" method="post">
                <meta name="csrf-token" content="{{ csrf_token() }}" />
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="menu" class="col-sm-4 col-form-label">Menu <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <select class="custom-select" name="menu" id="menu">
                                <option value="">Pilih Menu</option>
                                @foreach($menus as $menu)
                                    <option value="{{ $menu->id}}"> {{ $menu->menu }}</option>
                                @endforeach
                            </select>
                            <span class="menu-invalid-feedback text-danger"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="title" class="col-sm-4 col-form-label">Title Sub Menu <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="title" name="title">
                            <span class="title-invalid-feedback text-danger"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="url" class="col-sm-4 col-form-label">Url <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="url" name="url">
                            <span class="url-invalid-feedback text-danger"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="icon" class="col-sm-4 col-form-label">Icon <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="icon" name="icon">
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
@endsection
@section('script')
    <script>
        $('#addSubmenu #simpan').on('click', function(e){
            e.preventDefault();
            $.ajaxSetup({
                headers : {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('submenu.store') }}",
                method: "post",
                data: {
                    menu: $('#addSubmenu .modal-body #menu').val(),
                    title: $('#addSubmenu .modal-body #title').val(),
                    url: $('#addSubmenu .modal-body #url').val(),
                    icon: $('#addSubmenu .modal-body #icon').val(),
                    order: $('#addSubmenu .modal-body #order').val(),
                    status: $('#addSubmenu .modal-body #status').val(),
                },
                success: function(result){
                    if(result.errors){
                        if(result.errors.menu){
                            $('#addSubmenu .modal-body #menu').addClass('is-invalid');
                            $('#addSubmenu .modal-body .menu-invalid-feedback').append(result.errors.menu);
                        }
                        if(result.errors.title){
                            $('#addSubmenu .modal-body #title').addClass('is-invalid');
                            $('#addSubmenu .modal-body .title-invalid-feedback').append(result.errors.title);
                        }
                        if(result.errors.url){
                            $('#addSubmenu .modal-body #url').addClass('is-invalid');
                            $('#addSubmenu .modal-body .url-invalid-feedback').append(result.errors.url);
                        }
                        if(result.errors.icon){
                            $('#addSubmenu .modal-body #icon').addClass('is-invalid');
                            $('#addSubmenu .modal-body .icon-invalid-feedback').append(result.errors.icon);
                        }
                        if(result.errors.order){
                            $('#addSubmenu .modal-body #order').addClass('is-invalid');
                            $('#addSubmenu .modal-body .order-invalid-feedback').append(result.errors.order);
                        }
                    }else {
                        $('#addSubmenu').modal('hide');
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

        $('#editSubmenu').on('show.bs.modal', function(e){
            const button = $(e.relatedTarget);
            const id = button.data('id');
            const menu = button.data('menu');
            const title = button.data('title');
            const url = button.data('url');
            const icon = button.data('icon');
            const order = button.data('order');
            const status = button.data('status');

            const modal = $(this);
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #menu').val(menu);
            modal.find('.modal-body #title').val(title);
            modal.find('.modal-body #url').val(url);
            modal.find('.modal-body #icon').val(icon);
            modal.find('.modal-body #order').val(order);

            if(status == 1){
                modal.find('.modal-body #status').prop('checked', true);
            }
        });

        $('#editSubmenu #simpan').on('click', function(e){
            e.preventDefault();
            $.ajaxSetup({
                headers : {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('submenu.update') }}",
                method: "post",
                data: {
                    id: $('#editSubmenu .modal-body #id').val(),
                    menu: $('#editSubmenu .modal-body #menu').val(),
                    title: $('#editSubmenu .modal-body #title').val(),
                    url: $('#editSubmenu .modal-body #url').val(),
                    icon: $('#editSubmenu .modal-body #icon').val(),
                    order: $('#editSubmenu .modal-body #order').val(),
                    status: $('#editSubmenu .modal-body #status').val(),
                },
                success: function(result){
                    if(result.errors){
                        if(result.errors.menu){
                            $('#editSubmenu .modal-body #menu').addClass('is-invalid');
                            $('#editSubmenu .modal-body .menu-invalid-feedback').append(result.errors.menu);
                        }
                        if(result.errors.title){
                            $('#editSubmenu .modal-body #title').addClass('is-invalid');
                            $('#editSubmenu .modal-body .title-invalid-feedback').append(result.errors.title);
                        }
                        if(result.errors.url){
                            $('#editSubmenu .modal-body #url').addClass('is-invalid');
                            $('#editSubmenu .modal-body .url-invalid-feedback').append(result.errors.url);
                        }
                        if(result.errors.icon){
                            $('#editSubmenu .modal-body #icon').addClass('is-invalid');
                            $('#editSubmenu .modal-body .icon-invalid-feedback').append(result.errors.icon);
                        }
                        if(result.errors.order){
                            $('#editSubmenu .modal-body #order').addClass('is-invalid');
                            $('#editSubmenu .modal-body .order-invalid-feedback').append(result.errors.order);
                        }
                    }else {
                        $('#editSubmenu').modal('hide');
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
    </script>
@endsection