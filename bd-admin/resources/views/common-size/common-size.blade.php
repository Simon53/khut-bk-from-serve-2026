@extends('layout.app')
@section('title', 'Khut::common size')

@section('content')

    <div class="page-header">
        <h3 class="page-title"> common Size </h3>
    </div>

    <div class="row">
        <div class="col-md-12 mb-4">
            <button type="button" class="btn btn-info btn-fw"  data-toggle="modal" data-target="#addcommonSizeModal">+ Add commonSize</button>
        </div>
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-common">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>SL</th>
                                    <th>commonSize Name</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach($commonSizes as $index => $commonSize)
                                    <tr>
                                        <td>{{ ($commonSizes->currentPage() - 1) * $commonSizes->perPage() + $loop->iteration }}</td>
                                        <td>{{ $commonSize->common_size }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary editcommonSizeBtn"
                                                    data-id="{{ $commonSize->id }}"
                                                    data-name="{{ $commonSize->common_size }}">
                                                Edit
                                            </button>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-danger deletecommonSizeBtn"
                                                    data-id="{{ $commonSize->id }}">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                       
                         <div class="d-flex justify-content-center">
                            {!! $commonSizes->links('pagination::bootstrap-4') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--add commonSize modal--->
    <div class="modal fade" id="addcommonSizeModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New common Size</h5>
                    <button type="button" class="btn-danger create-new-button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-common">
                    <div class="form-group">
                        <input type="text" id="commonsizeInput" class="form-control" placeholder="Enter commonSize name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="addcommonSizeBtn" class="btn btn-success">Add</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


     <!--edit commonSize modal--->
    <div class="modal fade" id="editcommonSizeModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit commonSize</h5>
                <button type="button" class="btn-danger" data-dismiss="modal" aria-label="Close">
                <span>&times;</span>
                </button>
            </div>
            <div class="modal-common">
                <input type="hidden" id="editcommonSizeId">
                <div class="form-group">
                <label for="editcommonSizeName">commonSize Name</label>
                <input type="text" id="editcommonSizeName" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success updatecommonSizeBtn">Update</button>
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

        // Add commonSize
        $('#addcommonSizeBtn').click(function () {
            let commonSizeName = $('#commonsizeInput').val().trim();
            if(commonSizeName === '') {
                toastr.warning('common size name is required.');
                return;
            }
            $.post('/common-size/store', {common_size: commonSizeName}, function(res) {
                toastr.success(res.message);
                $('#addcommonSizeModal').modal('hide');
                $('#commonsizeInput').val('');
                location.reload();  // Reload page to show new entry and pagination
            }).fail(function() {
                toastr.error('Failed to add common size.');
            });
        });

        // Show Edit Modal with data
        $(document).on('click', '.editcommonSizeBtn', function () {
            let id = $(this).data('id');
            let name = $(this).data('name');
            $('#editcommonSizeId').val(id);
            $('#editcommonSizeName').val(name);
            $('#editcommonSizeModal').modal('show');
        });

        // Update commonSize
        $(document).on('click', '.updatecommonSizeBtn', function () {
            let id = $('#editcommonSizeId').val();
            let name = $('#editcommonSizeName').val().trim();
            if(name === '') {
                toastr.warning('common size name is required.');
                return;
            }
            $.ajax({
                url: '/common-size/update',
                type: 'POST',
                data: { id: id, common_size: name },
                success: function(res) {
                    toastr.success(res.message);
                    $('#editcommonSizeModal').modal('hide');
                    location.reload(); // Reload page to reflect changes
                },
                error: function() {
                    toastr.error('Failed to update common size.');
                }
            });
        });

        // Delete commonSize
        $(document).on('click', '.deletecommonSizeBtn', function () {
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
                        url: '/common-size/delete/' + id,
                        type: 'DELETE',
                        data: {_token: '{{ csrf_token() }}'},
                        success: function(res) {
                            toastr.success(res.message);
                            row.remove();
                        },
                        error: function() {
                            toastr.error('Failed to delete common size.');
                        }
                    });
                }
            });
        });
    </script>
@endsection

