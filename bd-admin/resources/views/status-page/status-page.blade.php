@extends('layout.app')
@section('title', 'Khut::status ')

@section('content')

    <div class="page-header">
        <h3 class="page-title"> status  </h3>
    </div>

    <div class="row">
        <div class="col-md-12 mb-4">
            <button type="button" class="btn btn-info btn-fw"  data-toggle="modal" data-target="#addstatusModal">+ Add status</button>
        </div>
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-status">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>SL</th>
                                    <th>status Name</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach($status as $index => $item)
                                <tr>
                                    <td>{{ ($status->currentPage() - 1) * $status->perPage() + $loop->iteration }}</td>
                                    <td>{{ $item->status }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary editstatusBtn"
                                                data-id="{{ $item->id }}"
                                                data-name="{{ $item->status }}">
                                            Edit
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-danger deletestatusBtn"
                                                data-id="{{ $item->id }}">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                       
                         <div class="d-flex justify-content-center">
							{!! $status->links('pagination::bootstrap-4') !!}
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--add status modal--->
    <div class="modal fade" id="addstatusModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Status</h5>
                    <button type="button" class="btn-danger create-new-button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-status">
                    <div class="form-group">
                        <input type="text" id="Statusnput" class="form-control" placeholder="Enter status name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="addstatusBtn" class="btn btn-success">Add</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


     <!--edit status modal--->
    <div class="modal fade" id="editstatusModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit status</h5>
                <button type="button" class="btn-danger" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-status">
                <input type="hidden" id="editStatusd">
                <div class="form-group">
                    <input type="text" id="editStatusInput" class="form-control" placeholder="Edit status">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success updatestatusBtn">Update</button>
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

        // Add status
        $('#addstatusBtn').click(function () {
            let statusName = $('#Statusnput').val().trim();
            if(statusName === '') {
                toastr.warning('Status name is required.');
                return;
            }
            $.post('/status-page/store', {status: statusName}, function(res) {
                toastr.success(res.message);
                $('#addstatusModal').modal('hide');
                $('#Statusnput').val('');
                location.reload();  // Reload page to show new entry and pagination
            }).fail(function() {
                toastr.error('Failed to add Status.');
            });
        });

        // Show Edit Modal with data
       $(document).on('click', '.editstatusBtn', function () {
            let id = $(this).data('id');
            let name = $(this).data('name');
            $('#editStatusd').val(id);       // <-- আইডি সেট করলাম
            $('#editStatusInput').val(name);
            $('#editstatusModal').modal('show');
        });

        // Update status
        $(document).on('click', '.updatestatusBtn', function () {
            let id = $('#editStatusd').val();  // এখানে আইডি নিয়ে আসবে
            let name = $('#editStatusInput').val().trim();
            if(name === '') {
                toastr.warning('Status name is required.');
                return;
            }
            $.ajax({
                url: '/status-page/update',
                type: 'POST',
                data: { id: id, status: name },
                success: function(res) {
                    toastr.success(res.message);
                    $('#editstatusModal').modal('hide');
                    location.reload();
                },
                error: function() {
                    toastr.error('Failed to update Status.');
                }
            });
        });



        // Delete status
        $(document).on('click', '.deletestatusBtn', function () {
            let id = $(this).data('id');
            let row = $(this).closest('tr');

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
                        url: '/status-page/delete/' + id,
                        type: 'DELETE',
                        data: {_token: '{{ csrf_token() }}'},
                        success: function(res) {
                            toastr.success(res.message);
                            row.remove();
                        },
                        error: function() {
                            toastr.error('Failed to delete Status.');
                        }
                    });
                }
            });
        });
    </script>
@endsection

