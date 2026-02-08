@extends('layout.app')
@section('title', 'Khut::Iron')

@section('content')

    <div class="page-header">
        <h3 class="page-title">Iron</h3>

        
    </div>

    <div class="row">
        <div class="col-md-12 mb-4">
            <button type="button" class="btn btn-info btn-fw"  data-toggle="modal" data-target="#addIronrModal">+ Add Iron Name</button>
        </div>
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>SL</th>
                                    <th>Iron Name</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                              <tbody>
                                    @foreach($iron as $index => $irons)
                                        <tr>
                                            <td>{{ ($iron->currentPage() - 1) * $iron->perPage() + $loop->iteration }}</td>
                                            <td>{{ $irons->iron_name }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary editIronBtn" 
                                                        data-id="{{ $irons->id }}" 
                                                        data-name="{{ $irons->iron_name }}">
                                                    Edit
                                                </button>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-danger deleteIronBtn" 
                                                        data-id="{{ $irons->id }}">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </tbody>
                        </table>
                       
                           <div class="d-flex justify-content-center mt-4">
                                {{ $iron->links() }}
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--add color modal--->
    <div class="modal fade" id="addIronrModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Iron Name</h5>
                    <button type="button" class="btn-danger create-new-button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" id="ironNameInput" class="form-control" placeholder="Enter Iron Name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="addIronBtn" class="btn btn-success">Add</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


     <!--Edit Iron modal--->
    <div class="modal fade" id="editIronModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Iron</h5>
                <button type="button" class="btn-danger" data-dismiss="modal" aria-label="Close">
                <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editIronId">
                <div class="form-group">
                <label for="editIronName">Iron Name</label>
                <input type="text" id="editIronName" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success updateIronBtn">Update</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
@endsection      


@section('script')

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

      $('#addIronBtn').click(function () {
    let ironName = $('#ironNameInput').val().trim();

    if (ironName === '') {
        toastr.warning('Iron Name is required.');
        return;
    }

    $.post("{{ route('iron.store') }}", { iron_name: ironName }, function (res) {
        toastr.success(res.message);
        $('#addIronrModal').modal('hide');
        $('#ironNameInput').val('');
        
        // Reload page to refresh table
        location.reload();
    }).fail(function (xhr) {
        toastr.error('Failed to add iron.');
    });
});

// Edit Iron - Show Modal
$(document).on('click', '.editIronBtn', function () {
    let id = $(this).data('id');
    let name = $(this).data('name');

    $('#editIronId').val(id);
    $('#editIronName').val(name);
    $('#editIronModal').modal('show');
});

// Update Iron
$(document).on('click', '.updateIronBtn', function () {
    let id = $('#editIronId').val();
    let name = $('#editIronName').val();

    $.ajax({
        url: '/iron/update/' + id,
        type: 'PUT',
        data: {
            iron_name: name,
            _token: '{{ csrf_token() }}'
        },
        success: function (res) {
            $('#editIronModal').modal('hide');
            toastr.success(res.message);

            // Reload page to refresh table
            location.reload();
        },
        error: function () {
            toastr.error('Something went wrong!');
        }
    });
});

// Delete Iron
$(document).on('click', '.deleteIronBtn', function () {
    let id = $(this).data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/iron/delete/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (res) {
                    toastr.success(res.message);

                    // Reload page to refresh table
                    location.reload();
                },
                error: function () {
                    toastr.error('Failed to delete iron.');
                }
            });
        }
    });
});
    </script>
@endsection

