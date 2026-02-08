@extends('layout.app')
@section('title', 'Khut::color')

@section('content')

    <div class="page-header">
        <h3 class="page-title"> Color </h3>
    </div>

    <div class="row">
        <div class="col-md-12 mb-4">
            <button type="button" class="btn btn-info btn-fw"  data-toggle="modal" data-target="#addColorModal">+ Add Color</button>
        </div>
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>SL</th>
                                    <th>Color Name</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach($colors as $index => $color)
                                    <tr>
                                        <td>{{ ($colors->currentPage() - 1) * $colors->perPage() + $loop->iteration }}</td>
                                        <td>{{ $color->color_name }}</td>
                                        <td><button class="btn btn-sm btn-primary editColorBtn" data-id="{{ $color->id }}" data-name="{{ $color->color_name }}">Edit</button></td>
                                        <td><button class="btn btn-sm btn-danger deleteColorBtn" data-id="{{ $color->id }}">Delete</button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                       
                           <div class="d-flex justify-content-center mt-4">
                                {{ $colors->links() }}
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--add color modal--->
    <div class="modal fade" id="addColorModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Color Name</h5>
                    <button type="button" class="btn-danger create-new-button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" id="colorNameInput" class="form-control" placeholder="Enter color name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="addColorBtn" class="btn btn-success">Add</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


     <!--edit color modal--->
    <div class="modal fade" id="editColorModal" tabindex="-1" role="dialog">
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
                <label for="editColorName">Color Name</label>
                <input type="text" id="editColorName" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success updateColorBtn">Update</button>
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

        /// Add color
$('#addColorBtn').click(function () {
    let colorName = $('#colorNameInput').val().trim();

    if (colorName === '') {
        toastr.warning('Color name is required.');
        return;
    }

    $.post("{{ route('color.store') }}", { color_name: colorName }, function (res) {
        toastr.success(res.message);
        $('#addColorModal').modal('hide');
        $('#colorNameInput').val('');
        
        setTimeout(function () {
            location.reload(); // 🔄 Auto reload
        }, 1000);

    }).fail(function (xhr) {
        toastr.error('Failed to add color.');
    });
});

// Edit script
$(document).on('click', '.editColorBtn', function () {
    let id = $(this).data('id');
    let name = $(this).data('name');

    $('#editColorId').val(id);
    $('#editColorName').val(name);
    $('#editColorModal').modal('show');
});

$(document).on('click', '.updateColorBtn', function () {
    let id = $('#editColorId').val();
    let name = $('#editColorName').val();

    $.ajax({
        url: '/colors/update/' + id,
        type: 'PUT',
        data: {
            color_name: name,
            _token: '{{ csrf_token() }}'
        },
        success: function (res) {
            $('#editColorModal').modal('hide');
            toastr.success(res.message);

            setTimeout(function () {
                location.reload(); // 🔄 Auto reload
            }, 1000);
        },
        error: function () {
            toastr.error('Something went wrong!');
        }
    });
});



        //delete script
        $(document).on('click', '.deleteColorBtn', function () {
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
                        url: '/colors/delete/' + id,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (res) {
                            toastr.success(res.message);
                            row.remove(); // Remove from table without reload
                        },
                        error: function () {
                            toastr.error('Failed to delete color.');
                        }
                    });
                }
            });
        });
    </script>
@endsection

