@extends('layout.app')
@section('title', 'Khut::Dry Wash')

@section('content')

    <div class="page-header">
        <h3 class="page-title"> Dry Wash </h3>

        
    </div>

    <div class="row">
        <div class="col-md-12 mb-4">
            <button type="button" class="btn btn-info btn-fw"  data-toggle="modal" data-target="#addDryWashrModal">+ Add Dry Wash</button>
        </div>
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>SL</th>
                                    <th>Dry Wash Name</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach($dry_washes as $index => $dry_wash)
                                    <tr>
                                        <td>{{ ($dry_washes->currentPage() - 1) * $dry_washes->perPage() + $loop->iteration }}</td>
                                        <td>{{ $dry_wash->drywash_name }}</td>
                                        <td><button class="btn btn-sm btn-primary editDryWashBtn" data-id="{{ $dry_wash->id }}" data-name="{{ $dry_wash->drywash_name }}">Edit</button></td>
                                        <td><button class="btn btn-sm btn-danger deleteDryWashBtn" data-id="{{ $dry_wash->id }}">Delete</button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                       
                           <div class="d-flex justify-content-center mt-4">
                                {{ $dry_washes->links() }}
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--add color modal--->
    <div class="modal fade" id="addDryWashrModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Dry Wash Name</h5>
                    <button type="button" class="btn-danger create-new-button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" id="dywashNameInput" class="form-control" placeholder="Enter Dry Wash Name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="addDrywashBtn" class="btn btn-success">Add</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


     <!--edit color modal--->
    <div class="modal fade" id="editDryWashrModa" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Color</h5>
                <button type="button" class="btn-danger" data-dismiss="modal" aria-label="Close">
                <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editColorId">
                <div class="form-group">
                <label for="editDryWashName">Dry Wash Name</label>
                <input type="text" id="editDryWashName" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success updateDryWashBtn">Update</button>
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

       // Add Dry Wash
            $('#addDrywashBtn').click(function () {
                let drywashName = $('#dywashNameInput').val().trim();

                if (drywashName === '') {
                    toastr.warning('Dry Wash Name is required.');
                    return;
                }

                $.post("{{ route('drywash.store') }}", { drywash_name: drywashName }, function (res) {
                    toastr.success(res.message);
                    $('#addDryWashrModal').modal('hide');
                    $('#dywashNameInput').val('');
                    
                    // Page reload to refresh table
                    location.reload();
                }).fail(function (xhr) {
                    toastr.error('Failed to add dry wash.');
                });
            });

            // Edit Dry Wash
            $(document).on('click', '.editDryWashBtn', function () {
                let id = $(this).data('id');
                let name = $(this).data('name');

                $('#editColorId').val(id);
                $('#editDryWashName').val(name);
                $('#editDryWashrModa').modal('show');
            });

            $(document).on('click', '.updateDryWashBtn', function () {
                let id = $('#editColorId').val();
                let name = $('#editDryWashName').val();

                $.ajax({
                    url: '/dry-wash-page/update/' + id,
                    type: 'PUT',
                    data: {
                        drywash_name: name,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (res) {
                        $('#editDryWashrModal').modal('hide');
                        toastr.success(res.message);

                        // Reload page to refresh table
                        location.reload();
                    },
                    error: function () {
                        toastr.error('Something went wrong!');
                    }
                });
            });

            // Delete Dry Wash
            $(document).on('click', '.deleteDryWashBtn', function () {
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
                            url: '/dry-wash-page/delete/' + id,
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
                                toastr.error('Failed to delete dry wash.');
                            }
                        });
                    }
                });
            });

    </script>
@endsection

