@extends('layout.app')
@section('title', 'Khut::User')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Create User </h3>
</div>

<div class="row">
    <div class="col-md-12 mb-4">
        <button type="button" class="btn btn-info btn-fw" data-toggle="modal" data-target="#addUserModal">+ Add User</button>
    </div>
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody id="userTable">
                            @foreach($users as $key => $user)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td><button class="btn btn-warning btn-sm editBtn" data-id="{{ $user->id }}">Edit</button></td>
                                    <td><button class="btn btn-danger btn-sm deleteBtn" data-id="{{ $user->id }}">Delete</button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Add User Modal --}}
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New User</h5>
                <button type="button" class="btn-danger" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                    @csrf
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" class="form-control" required>
                            <option value="Administrator">Administrator</option>
                            <option value="Moderator">Moderator</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New User</h5>
                <button type="button" class="btn-danger" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                    @csrf
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control">
                        <small class="form-text text-muted">Leave blank to keep current password</small>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" class="form-control" required>
                            <option value="Administrator">Administrator</option>
                            <option value="Moderator">Moderator</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$('#addUserForm').on('submit', function(e){
    e.preventDefault();
    $.ajax({
        url: "{{ route('user.store') }}",
        method: "POST",
        data: $(this).serialize(),
        success: function(res){
            if(res.success){
                $('#addUserModal').modal('hide');  
                toastr.success(res.message);      
                $('#addUserForm')[0].reset();      
                setTimeout(function(){
                    location.reload();            
                }, 500);
            }
        },
        error: function(xhr){
            if(xhr.status === 422){
                let errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value){
                    toastr.error(value[0]);
                });
            } else {
                toastr.error('Something went wrong!');
            }
        }
    });
});


$(document).ready(function(){

    // Edit Button Click
    $('.editBtn').click(function(){
        var id = $(this).data('id');

        $.get("{{ url('/user/edit') }}/"+id, function(user){
            $('#addUserModal .modal-title').text('Edit User');
            $('#addUserForm').attr('data-id', id); // Save id for update
            $('#addUserForm input[name="name"]').val(user.name);
            $('#addUserForm input[name="username"]').val(user.username);
            $('#addUserForm input[name="email"]').val(user.email);
            $('#addUserForm input[name="password"]').val(''); // Empty password
            $('#addUserForm select[name="role"]').val(user.role);
            $('#addUserModal').modal('show');
        });
    });

    // Submit Add/Edit Form
    $('#addUserForm').on('submit', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        var url = id ? "{{ url('/user/update') }}/"+id : "{{ route('user.store') }}";
        var method = id ? 'POST' : 'POST';

        $.ajax({
            url: url,
            method: method,
            data: $(this).serialize(),
            success: function(res){
                if(res.success){
                    $('#addUserModal').modal('hide');
                    toastr.success(res.message);
                    $('#addUserForm')[0].reset();
                    $('#addUserForm').removeAttr('data-id');
                    setTimeout(function(){ location.reload(); }, 1000);
                }
            },
            error: function(xhr){
                if(xhr.status === 422){
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value){
                        toastr.error(value[0]);
                    });
                } else {
                    toastr.error('Something went wrong!');
                }
            }
        });
    });

    // Reset modal when closed
    $('#addUserModal').on('hidden.bs.modal', function () {
        $('#addUserForm')[0].reset();
        $('#addUserForm').removeAttr('data-id');
        $('#addUserModal .modal-title').text('Add New User');
    });

});


$(document).on('click', '.deleteBtn', function(){
    var id = $(this).data('id');
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if(result.isConfirmed){
            $.ajax({
                url: "/user/delete/" + id,
                type: "DELETE",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(res){
                    if(res.success){
                        toastr.success(res.message);
                        $('#userTable').find('button[data-id="'+id+'"]').closest('tr').remove();
                    } else {
                        toastr.error(res.message);
                    }
                },
                error: function(){
                    toastr.error('Something went wrong!');
                }
            });
        }
    });
});
</script>

@endsection
