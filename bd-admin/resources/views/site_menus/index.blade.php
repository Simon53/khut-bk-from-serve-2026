@extends('layout.app')
@section('title', 'Khut::Site Menu')
@section('content')

<div class="container-fluid">
    <h2>Site Menus</h2>
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addMenuModal">Add New Menu</button>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Menu Name</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($menus as $key => $menu)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $menu->name }}</td>
                        <td>{{ $menu->slug }}</td>
                        <td>{{ $menu->status ? 'Active' : 'Inactive' }}</td>
                        <td>
                        <button class="btn btn-sm btn-primary editMenuBtn" 
            data-id="{{ $menu->id }}" 
            data-name="{{ $menu->name }}">
        Edit
    </button>
                        <button class="btn btn-sm btn-danger deleteMenuBtn" data-id="{{ $menu->id }}">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addMenuModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="addMenuForm">
      @csrf
      <div class="modal-content">
        <div class="modal-header"><h5 class="modal-title">Add Menu</h5></div>
        <div class="modal-body">
          <input type="text" name="name" class="form-control" placeholder="Menu Name" required>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editMenuModal" tabindex="-1">
  <div class="modal-dialog">
     <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">
            <form id="editMenuForm">
                @csrf
                <input type="hidden" name="menu_id">
                <div class="form-group">
                    <label>Menu Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
  </div>
</div>

@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

const basePath = '/bd-admin/public';

$('.editMenuBtn').on('click', function () {
        let id = $(this).data('id');
        let name = $(this).data('name');

        $('#editMenuForm [name="menu_id"]').val(id);
        $('#editMenuForm [name="name"]').val(name);
        $('#editMenuModal').modal('show');
    });

   // Insert Menu
$('#addMenuForm').on('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);

    $.ajax({
        //url: '/admin/site-menus/store', // ✅ create route
        url: basePath + '/admin/site-menus/store',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(data) {
            toastr.success(data.success);
            $('#addMenuForm')[0].reset();
            setTimeout(() => location.reload(), 800);
        },
        error: function(xhr) {
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                $.each(xhr.responseJSON.errors, function(key, value) {
                    toastr.error(value);
                });
            } else {
                toastr.error('Something went wrong!');
            }
        }
    });
});



// Submit Edit Form via AJAX
$(document).ready(function () {

    // Show Edit Modal
    $(document).on('click', '.editMenuBtn', function () {
        let id = $(this).data('id');
        let name = $(this).data('name');

        $('#editMenuForm [name="menu_id"]').val(id);
        $('#editMenuForm [name="name"]').val(name);
        $('#editMenuModal').modal('show');
    });

    // Submit Edit Form
    $('#editMenuForm').on('submit', function (e) {
        e.preventDefault();
        let id = $('#editMenuForm [name="menu_id"]').val();
        let formData = new FormData(this);

        $.ajax({
            //url: '/admin/site-menus/update/' + id,
            url: basePath + '/admin/site-menus/store',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                toastr.success(data.success);
                $('#editMenuModal').modal('hide');
                setTimeout(() => location.reload(), 800);
            },
            error: function (xhr) {
                if (xhr.responseJSON?.errors) {
                    $.each(xhr.responseJSON.errors, function (key, value) {
                        toastr.error(value);
                    });
                } else {
                    toastr.error('Update failed!');
                }
            }
        });
    });

});

// Delete Menu
$('.deleteMenuBtn').on('click', function () {
    let id = $(this).data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'https://khut.shop/bd-admin/public/admin/site-menus/delete/' + id,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    Swal.fire(
                        'Deleted!',
                        data.success,
                        'success'
                    );
                    setTimeout(() => location.reload(), 1000);
                },
                error: function () {
                    Swal.fire(
                        'Failed!',
                        'Something went wrong.',
                        'error'
                    );
                }
            });
        }
    });
});



</script>
@endsection
