@extends('layout.app')
@section('title', 'Khut::BodySize')

@section('content')

    <div class="page-header">
        <h3 class="page-title"> Body Size </h3>

        
    </div>

    <div class="row">
        <div class="col-md-12 mb-4">
            <button type="button" class="btn btn-info btn-fw"  data-toggle="modal" data-target="#addBodySizeModal">+ Add BodySize</button>
        </div>
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>SL</th>
                                    <th>BodySize Name</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach($bodySizes as $index => $bodySize)
        <tr>
            <td>{{ ($bodySizes->currentPage() - 1) * $bodySizes->perPage() + $loop->iteration }}</td>
            <td>{{ $bodySize->body_size }}</td>
            <td>
                <button class="btn btn-sm btn-primary editBodySizeBtn"
                        data-id="{{ $bodySize->id }}"
                        data-name="{{ $bodySize->body_size }}">
                    Edit
                </button>
            </td>
            <td>
                <button class="btn btn-sm btn-danger deleteBodySizeBtn"
                        data-id="{{ $bodySize->id }}">
                    Delete
                </button>
            </td>
        </tr>
    @endforeach
                            </tbody>
                        </table>
                       
                         <div class="d-flex justify-content-center">
    {!! $bodySizes->links('pagination::bootstrap-4') !!}
</div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--add BodySize modal--->
    <div class="modal fade" id="addBodySizeModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Body Size</h5>
                    <button type="button" class="btn-danger create-new-button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" id="bodysizeInput" class="form-control" placeholder="Enter BodySize name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="addBodySizeBtn" class="btn btn-success">Add</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


     <!--edit BodySize modal--->
    <div class="modal fade" id="editBodySizeModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit BodySize</h5>
                <button type="button" class="btn-danger" data-dismiss="modal" aria-label="Close">
                <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editBodySizeId">
                <div class="form-group">
                <label for="editBodySizeName">BodySize Name</label>
                <input type="text" id="editBodySizeName" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success updateBodySizeBtn">Update</button>
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

        // Add BodySize
        $('#addBodySizeBtn').click(function () {
            let bodySizeName = $('#bodysizeInput').val().trim();
            if(bodySizeName === '') {
                toastr.warning('Body size name is required.');
                return;
            }
            $.post('/body-size/store', {body_size: bodySizeName}, function(res) {
                toastr.success(res.message);
                $('#addBodySizeModal').modal('hide');
                $('#bodysizeInput').val('');
                location.reload();  // Reload page to show new entry and pagination
            }).fail(function() {
                toastr.error('Failed to add body size.');
            });
        });

        // Show Edit Modal with data
        $(document).on('click', '.editBodySizeBtn', function () {
            let id = $(this).data('id');
            let name = $(this).data('name');
            $('#editBodySizeId').val(id);
            $('#editBodySizeName').val(name);
            $('#editBodySizeModal').modal('show');
        });

        // Update BodySize
        $(document).on('click', '.updateBodySizeBtn', function () {
            let id = $('#editBodySizeId').val();
            let name = $('#editBodySizeName').val().trim();
            if(name === '') {
                toastr.warning('Body size name is required.');
                return;
            }
            $.ajax({
                url: '/body-size/update',
                type: 'POST',
                data: { id: id, body_size: name },
                success: function(res) {
                    toastr.success(res.message);
                    $('#editBodySizeModal').modal('hide');
                    location.reload(); // Reload page to reflect changes
                },
                error: function() {
                    toastr.error('Failed to update body size.');
                }
            });
        });

        // Delete BodySize
        $(document).on('click', '.deleteBodySizeBtn', function () {
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
                        url: '/body-size/delete/' + id,
                        type: 'DELETE',
                        data: {_token: '{{ csrf_token() }}'},
                        success: function(res) {
                            toastr.success(res.message);
                            row.remove();
                        },
                        error: function() {
                            toastr.error('Failed to delete body size.');
                        }
                    });
                }
            });
        });
    </script>
@endsection

