@extends('layout.app')
@section('title', 'Khut::Category Banner')
@section('content')
<div class="container-fluid">
   <div class="page-header"><h3 class="page-title">Set Category Banner</h3></div>
   <div class="row ">
      <div class="col-md-12">
         <button type="button" class="btn btn-info btn-fw" data-toggle="modal" data-target="#addBannerModal">
            + Add New
         </button>
      </div>
   </div>
   <div class="container-fluid text-center">
      <div class="row">
         <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
               <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Sl</th>
                                    <th>Category Name</th>
                                    <th>Title</th> <!-- এখানে title দেখাবে -->
                                    <th>Images</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categoryBanners as $index => $banner)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $banner->mainMenu->name }}</td>
                                    <td>{{ $banner->title }}</td> <!-- title আলাদাভাবে দেখাচ্ছে -->
                                    <td>
                                        <img src="{{ asset($banner->banner_image) }}" style="width:100px; height:auto; border-radius:8px;">
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-sm editCategoryBannerBtn" 
                                                data-id="{{ $banner->id }}" 
                                                data-menu="{{ $banner->main_menu_id }}" 
                                                data-image="{{ asset($banner->banner_image) }}">
                                            Edit
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger btn-sm deleteCategoryBannerBtn" data-id="{{ $banner->id }}">Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>   


<!-- Add Slider Modal -->
<div class="modal fade" id="addBannerModal" tabindex="-1" role="dialog">
   <div class="modal-dialog" role="document">
      <form id="addCategoryBannerForm" enctype="multipart/form-data">
        @csrf
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Create New Category Banner</h5>
            <button type="button" class="btn btn-danger" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="main_menu_id">Select Main Menu</label>
                <select name="main_menu_id" id="main_menu_id" class="form-control" required>
                    <option value="">-- Select Main Menu --</option>
                    @foreach($mainMenus as $menu)
                    <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Banner Image</label>
                <input type="file" name="banner_image" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Title (Optional)</label>
                <input type="text" name="title" class="form-control">
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" id="addCategoryBannerBtn" class="btn btn-success">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </form>
   </div>
</div>


<!-- Edit Category Banner Modal -->
<div class="modal fade" id="editCategoryBannerModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form id="editCategoryBannerForm" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="id" id="edit_id">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Category Banner</h5>
          <button type="button" class="btn btn-danger" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Main Menu</label>
            <select name="main_menu_id" id="edit_main_menu_id" class="form-control" required>
              @foreach($mainMenus as $menu)
                <option value="{{ $menu->id }}">{{ $menu->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" id="edit_title" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Banner Image</label>
            <input type="file" name="banner_image" class="form-control">
            <div class="mt-2">
              <img id="edit_preview" src="" width="120">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Update</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>






@endsection  
@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
 const basePath = '/bd-admin/public';
$('#addCategoryBannerForm').submit(function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    $.ajax({
        url: "{{ route('category-banner.store') }}",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (res) {
            if (res.status === 'success') {
                toastr.success(res.message);
                $('#addBannerModal').modal('hide');
                $('#addCategoryBannerForm')[0].reset();
                setTimeout(function () {
                    location.reload();
                }, 400); 
            }
        },
        error: function (xhr) {
            console.log(xhr.responseText);
            toastr.error('Something went wrong!');
        }
    });
});


//edtid-update
$(document).ready(function(){
    // Open modal and fill data
    $(document).on('click', '.editCategoryBannerBtn', function(){
        let id = $(this).data('id');
        $('#edit_id').val(id);

        $.get(basePath + '/category-banner/' + id + '/edit', function(res){
            $('#edit_title').val(res.title);
            $('#edit_main_menu_id').val(res.main_menu_id);
            $('#edit_preview').attr('src', res.banner_image);
            $('#editCategoryBannerModal').modal('show');
        });
    });

    // Submit edit form
    $('#editCategoryBannerForm').submit(function(e){
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('category-banner.update') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(res){
                if(res.status == 'success'){
                    toastr.success(res.message);
                    $('#editCategoryBannerModal').modal('hide');
                    location.reload();
                } else {
                    toastr.error('Update failed!');
                }
            },
            error: function(err){
                toastr.error('Something went wrong!');
            }
        });
    });

});


$(document).on('click', '.deleteCategoryBannerBtn', function (e) {
    e.preventDefault();
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
                url: '/admin/category-banner/' + id, // ✅ slash fixed
                type: 'POST', // ✅ Laravel friendly
                data: {
                    _method: 'DELETE',
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                    if (res.status === 'success') {
                        Swal.fire('Deleted!', res.message, 'success')
                            .then(() => location.reload());
                    } else {
                        Swal.fire('Error!', 'Something went wrong!', 'error');
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    Swal.fire('Error!', 'Delete failed!', 'error');
                }
            });

        }
    });
});




</script>
@endsection