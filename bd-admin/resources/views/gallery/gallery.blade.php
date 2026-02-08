@extends('layout.app')
@section('title', 'Khut::Gallery')

@section('content')
    <div class="container">
        <div class="page-header">
            <h3 class="page-title">Gallery</h3>
            
        </div>

        <div class="row ">
            <div class="col-md-12 mb-4">
                <button type="button" class="btn btn-info btn-fw"  data-toggle="modal" data-target="#addImageModal">+ Add Image</button>
            </div>
        </div>
    </div>

    <div class="container text-center">
        <div class="row galleryRow mb-4">
            
        
        
        </div>
        <button id="loadMoreBtn" type="button" class="btn btn-info " >+ Load More</button>
        
    </div>





    <!-- Upload Modal -->
    <div class="modal fade" id="addImageModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload New Image</h5>
                    <button type="button" class="btn-danger create-new-button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="file" id="imgInput" name="image" class="form-control btn-primary">
                        <img id="imgPreview" src="{{ asset('images/samples/defaultimag.jpg') }}" class="mt-3 imgPreverSize" style="max-width: 100%; margin-top: 10px;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="saveImage" type="button" class="btn btn-success">Upload</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection  


@section('script')

<script type="text/javascript">
  const basePath = '/bd-admin/public';  
// ================================
// ১. Image Preview
// ================================
$('#imgInput').change(function () {
    var reader = new FileReader();
    reader.readAsDataURL(this.files[0]);
    reader.onload = function (event) {
        $('#imgPreview').attr('src', event.target.result);
    };
});




// ================================
// ২. Image Upload
// ================================
$('#saveImage').on('click', function () {
    const button = $(this);
    button.html("<div class='spinner-border text-primary' role='status'></div>");

    let imageFile = $('#imgInput').prop('files')[0];
    if (!imageFile) {
        toastr.error("Please select an image.");
        button.text('Upload');
        return;
    }

    let formData = new FormData();
    formData.append('image', imageFile);

    // CSRF token from meta
    const token = $('meta[name="csrf-token"]').attr('content');

    axios.post(basePath +'/uploadGallery', formData, {
    headers: {
        'Content-Type': 'multipart/form-data',
        'X-CSRF-TOKEN': token
    },
        withCredentials: true // important for session in CPanel
    })
    .then(function (response) {
        button.text('Upload');
        if (response.status === 200 && response.data.status === 'success') {
            toastr.success('Image Uploaded Successfully!');
            $('#addImageModal').modal('hide');
            $('#imgInput').val('');
            $('#imgPreview').attr('src', "/khut-bd-admin/public/images/samples/defaultimag.jpg");

            const item = response.data;
            $('.galleryRow').prepend(`
                <div class='col-md-2 p-2'>
                    <img data-id='${item.id}' class='imgGarrelryView' src='${item.url}'>
                    <button class='btn btn-sm btn-danger deleteImg' data-id='${item.id}' data-path='${item.url}'>
                        Delete <i class='mdi mdi-delete-forever'></i>
                    </button>
                </div>
            `);
        } else {
            toastr.error('Image Upload Failed!');
        }
    })
    .catch(function (error) {
        console.log(error.response); // debug
        toastr.error('Upload failed!');
        button.text('Upload');
    });
});



// ================================
// ৩. Load Gallery Images
// ================================
function loadGallery() {
    axios.get(basePath + '/galleryLoadJson')
    .then(function(response){
        $('.galleryRow').empty();
        $.each(response.data, function(i, item){
            $("<div class='col-md-2 p-2'>").html(
                `<img data-id='${item.id}' class='imgGarrelryView' src='${item.url}'>` +
                `<button data-id='${item.id}' data-path='${item.url}' class='btn btn-danger deleteImg'>Delete <i class='mdi mdi-delete-forever'></i></button>`
            ).appendTo('.galleryRow');
        });
    })
    .catch(function(error){
        console.error("Failed to load gallery:", error);
    });
}
loadGallery();

// ================================
// ৪. Load More Images by ID
// ================================
$('#loadMoreBtn').on('click', function() {
    let firstImgId = $('.galleryRow img').last().data('id') || 0;
    $('#loadMoreBtn').html("<div class='spinner-border text-primary' role='status'></div>");
    axios.get(basePath + '/galleryLoadJsonById?id=' + firstImgId)
    .then(function(response) {
        $.each(response.data, function(i, item) {
            $("<div class='col-md-2 p-2'>").html(
                `<img data-id='${item.id}' class='imgGarrelryView' src='${item.url}'>` +
                `<button data-id='${item.id}' data-path='${item.url}' class='btn btn-danger deleteImg'>Delete <i class='mdi mdi-delete-forever'></i></button>`
            ).appendTo('.galleryRow');
        });
        $('#loadMoreBtn').html("+ Load More");
    })
    .catch(function(error) {
        console.error("Failed to load more images:", error);
        $('#loadMoreBtn').html("+ Load More");
    });
});

// ================================
// ৫. Delete Gallery Image
// ================================
$(document).on('click', '.deleteImg', function(e) {
    e.preventDefault();
    const button = $(this);
    const id = button.data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this image!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            let formData = new FormData();
            formData.append('id', id);

            axios.post(basePath +'/galleryImageDelete', formData)
            .then(function(response) {
                if (response.status === 200 && response.data.status === 'success') {
                    toastr.success("Image deleted successfully!");
                    button.closest('.col-md-2').remove();
                } else {
                    toastr.error("Failed to delete image.");
                }
            })
            .catch(function(error) {
                toastr.error("Server Error. Try again.");
            });
        }
    });
});

// ================================
// ৬. Toastr Settings
// ================================
$(document).ready(function () {
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "3000"
    };
});

</script>

@endsection