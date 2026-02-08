@extends('layout.app')
@section('title', 'Khut::Site Pages List')
@section('content')
<div class="container">
   <div class="page-header">
      <h3 class="page-title">Site Pages List</h3>
   </div>

   <table class="table table-bordered table-striped">
       <thead>
           <tr>
               <th>#</th>
               <th>Page Title</th>
               <th>Site Menu Name</th>
               <th>Actions</th>
           </tr>
       </thead>
       <tbody>
           @foreach($pages as $index => $page)
               <tr>
                   <td>{{ $index + 1 }}</td>
                   <td>{{ $page->page_title }}</td>
                   <td>{{ $page->siteMenu->name ?? '-' }}</td>
                   <td>
                        <button class="btn btn-sm btn-primary" data-page='@json($page)'onclick="openEditModal(this.dataset.page)">Edit</button>
                       
                       <form id="delete-form-{{ $page->id }}" action="{{ route('site-pages.destroy', $page->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete({{ $page->id }})" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                   </td>
               </tr>
           @endforeach
       </tbody>
   </table>
</div>



<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="editForm" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <input type="hidden" id="edit_page_id" name="id" />
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Site Page</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="edit_page_id" name="page_id" />

          <div class="form-group">
              <label for="edit_site_menu_id">Select Site Menu</label>
              <select class="form-control" id="edit_site_menu_id" name="site_menu_id" required>
                  <option value="">Select a menu</option>
                  @foreach($siteMenus as $menu)
                      <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                  @endforeach
              </select>
          </div>
          <div class="form-group">
              <label for="edit_page_title">Page Title</label>
              <input type="text" class="form-control" id="edit_page_title" name="page_title" required>
          </div>
          <div class="form-group">
              <label for="edit_detailsEditor">Details</label>
              <textarea class="form-control" id="edit_detailsEditor" name="details" rows="5" style="hight:400px"></textarea>
          </div>
         <div class="form-group">
            <label for="edit_image">Image (Upload to change)</label>
            <input type="file" id="edit_image" name="image" accept="image/*" class="form-control">
            <br>
           
            <img  id="edit_image_preview" src="{{ asset($page->image) }}"  alt="Current Image" style="max-width: 100%; max-height: 150px; margin-top:10px;">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Update Page</button>
        </div>
      </div>
    </form>
  </div>
</div>


@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('js/tinymce/tinymce.min.js')}}"></script>


<script>
let editTinyMCE;
const basePath = '/bd-admin/public';
function openEditModal(pageJson) {
    let page = JSON.parse(pageJson);

    $('#edit_page_id').val(page.id);
    $('#edit_site_menu_id').val(page.site_menu_id);
    $('#edit_page_title').val(page.page_title);
    $('#edit_image_preview').attr('src', page.image || '');

    // আগের TinyMCE remove
    if (tinymce.get('edit_detailsEditor')) {
        tinymce.get('edit_detailsEditor').remove();
    }

    // TinyMCE init
     tinymce.init({
        selector: '#edit_detailsEditor',
        license_key: 'gpl',
        height: 500,
        plugins: 'advlist autolink lists link image imagetools charmap preview anchor code fullscreen table textcolor',
        toolbar: 'undo redo | styleselect | bold italic underline strikethrough | fontselect fontsizeselect | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code fullscreen table',
         extended_valid_elements: 'iframe[src|frameborder|style|scrolling|class|width|height|name|align|allowfullscreen]',
        menubar: false,
        fontsize_formats: '8pt 10pt 12pt 14pt 16pt 18pt 24pt 36pt',
        font_formats: 'Arial=arial,helvetica,sans-serif; Courier New=courier new,courier,monospace; Georgia=georgia,palatino; Tahoma=tahoma,arial,helvetica,sans-serif; Times New Roman=times new roman,times; Verdana=verdana,geneva;',
        automatic_uploads: true,
        images_upload_url: "{{ route('tinymce.upload') }}",
        relative_urls: false,
        remove_script_host: false,
        document_base_url: "{{ url('/') }}/",
        file_picker_types: 'image',
        file_picker_callback: function(callback, value, meta) {
            if (meta.filetype === 'image') {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                input.onchange = function() {
                    var file = this.files[0];
                    var formData = new FormData();
                    formData.append('file', file);

                    fetch("{{ route('tinymce.upload') }}", {
                        method: "POST",
                        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                        body: formData
                    })
                    .then(r => r.json())
                    .then(data => callback(data.location))
                    .catch(() => alert('Image upload failed'));
                };
                input.click();
            }
        },

        // Setup function
        setup: function(editor) {
            editTinyMCE = editor;
            editor.on('init', function() {
                editor.setContent(page.details || '');
            });
        },

        // Enable image resize/edit toolbar
        imagetools_toolbar: 'rotateleft rotateright | flipv fliph | editimage imageoptions'
    });

    window.currentEditPageId = page.id;
    $('#editModal').modal('show');
}

// Image Preview
$(document).on('change', '#edit_image', function(event) {
    let file = event.target.files[0];
    if (file) {
        let reader = new FileReader();
        reader.onload = e => $('#edit_image_preview').attr('src', e.target.result);
        reader.readAsDataURL(file);
    }
});

// Form Submit
$('#editForm').on('submit', function(e) {
  e.preventDefault();

  let detailsData = editTinyMCE.getContent().trim();
  if (detailsData === '') {
    Swal.fire({ icon: 'error', title: 'Oops...', text: 'Details cannot be empty!' });
    return;
  }

  let pageId = window.currentEditPageId;
  let formData = new FormData(this);
  formData.set('details', detailsData);
  formData.append('_method', 'PUT');

  $.ajax({
    url: basePath + '/admin/site-pages/update/' + pageId,
    method: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
    success: function(res) {
      $('#editModal').modal('hide');
      Swal.fire({
        toast: true,
        icon: 'success',
        title: 'Page updated successfully',
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });
      setTimeout(() => location.reload(), 1500);
    },
    error: function(xhr) {
      Swal.fire({ icon: 'error', title: 'Oops...', text: xhr.responseJSON?.message || 'Something went wrong!' });
    }
  });
});





function confirmDelete(id) {
  Swal.fire({
    title: 'Are you sure?',
    text: "You want to delete this page!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Yes, delete it!',
    cancelButtonText: 'Cancel'
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('delete-form-' + id).submit();
    }
  })
}


@if(session('success'))
Swal.fire({
  toast: true,
  icon: 'success',
  title: {!! json_encode(session('success')) !!},
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});
@endif

</script>
@endsection

