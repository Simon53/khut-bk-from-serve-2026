
@extends('layout.app')
@section('title', 'Khut::Create General Page')
@section('content')
<div class="container">
   <div class="page-header">
      <h3 class="page-title">Add New Page</h3>
   </div>
</div>
<div class="container">
    <form action="{{ route('site-pages.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="form-group col-md-6">
                <label for="site_menu_id">Select Site Menu</label>
                <select class="form-control" id="site_menu_id" name="site_menu_id">
                    <option value="">Select a menu</option>
                    @foreach($siteMenus as $menu)
                        <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-12">
                <label for="page_title">Page Title</label>
                <input type="text" class="form-control" id="page_title" name="page_title" placeholder="Page Title">
            </div>

            <div class="form-group col-md-12">
                <label>Details</label>
                <textarea class="form-control" id="detailsEditor"  name="details" rows="5" placeholder="Enter details..."></textarea>
            </div>

            <div class="form-group col-md-12">
                <label>Image</label>
                <input type="file" class="form-control" name="choose_image">
            </div>

            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </div>
    </form>
</div>

<style>
   .ck-editor__editable_inline {
   background-color: #2a3038 !important;
   color: #ffffff !important;
   min-height: 200px;
   }
  
   /* For WebKit browsers (Chrome, Safari, Edge) */
   ::-webkit-scrollbar {
   width: 6px; /* Vertical scrollbar width */
   height: 6px; /* Horizontal scrollbar height */
   }
   ::-webkit-scrollbar-track {
   background: #f0f0f0; /* Scrollbar background */
   border-radius: 10px;
   }
   ::-webkit-scrollbar-thumb {
   background: #888; /* Scrollbar thumb color */
   border-radius: 10px;
   }
   ::-webkit-scrollbar-thumb:hover {
   background: #555; /* On hover */
   }
     /* CKEditor editable area */
    .ck-editor__editable {
        background-color: #ffffff !important; 
        color: #000000 !important; 
        min-height: 300px; 
    }
    .image-overlay {
    position: relative;
    display: inline-block;
}

.image-overlay figcaption {
    position: absolute;
    top: 10px;
    left: 10px;
    cursor: move;
}

.ck-content table img {
    max-width: 100%;      /* টেবিলের সেল অনুযায়ী সাইজ */
    height: auto;
    border-radius: 8px;   /* রাউন্ড কোণ */
}

/* Text overlay inside figure */
figure.image-overlay {
    position: relative;
    display: inline-block;
}

figure.image-overlay figcaption {
    position: absolute;
    top: 0;
    left: 0;
    color: #000;
    font-size: 16px;
    pointer-events: auto;
    user-select: none;
}
.ck-editor__editable { min-height: 300px; background:#fff; color:#000; }
.image-overlay { position:relative; display:inline-block; }
.image-overlay figcaption { cursor:move; user-select:none; position:absolute; }

figure.image {
  display: inline-block;
  border: 1px solid gray;
  margin: 0 2px 0 1px;
  background: #f5f2f0;
}

figure.align-left {
  float: left;
}

figure.align-right {
  float: right;
}

figure.image img {
  margin: 8px 8px 0 8px;
}

figure.image figcaption {
  margin: 6px 8px 6px 8px;
  text-align: center;
}

/*
 Alignment using classes rather than inline styles
 check out the "formats" option
*/

img.align-left {
  float: left;
}

img.align-right {
  float: right;
}

/* Basic styles for Table of Contents plugin (tableofcontents) */
.mce-toc {
  border: 1px solid gray;
}

.mce-toc h2 {
  margin: 4px;
}

.mce-toc li {
  list-style-type: none;
}
</style>




@endsection  
@section('script')

<script src="{{asset('js/tinymce/tinymce.min.js')}}"></script>

<script>
tinymce.init({
  selector: '#detailsEditor',
  license_key: 'gpl',
  height: 500,
  plugins: 'advlist autolink lists link image charmap preview anchor code fullscreen table textcolor',
  toolbar: 'undo redo | styleselect | bold italic underline strikethrough | fontselect fontsizeselect | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | insertMapBtn | code fullscreen table',
  menubar: false,

  // Iframe allow
  extended_valid_elements: 'iframe[src|frameborder|style|scrolling|class|width|height|name|align|allowfullscreen]',

  // Fonts
  fontsize_formats: '8pt 10pt 12pt 14pt 16pt 18pt 24pt 36pt',
  font_formats: 'Arial=arial,helvetica,sans-serif; Courier New=courier new,courier,monospace; Georgia=georgia,palatino; Tahoma=tahoma,arial,helvetica,sans-serif; Times New Roman=times new roman,times; Verdana=verdana,geneva;',

  // Image Upload
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
          headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
          body: formData
        })
        .then(response => response.json())
        .then(data => callback(data.location))
        .catch(() => alert('Image upload failed'));
      };
      input.click();
    }
  },

  // Custom Button for Google Map
  setup: function(editor) {
    editor.ui.registry.addButton('insertMapBtn', {
      tooltip: 'Insert Google Map',
      icon: 'location',
      onAction: function() {
        let mapUrl = prompt("Paste Google Map Embed iframe URL here:");
        if (mapUrl) {
          editor.insertContent(
            `<iframe src="${mapUrl}" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>`
          );
        }
      }
    });
  }
});

</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({
    toast: true,
    icon: 'success',
    title: '{{ session('success') }}',
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
@endif

@if ($errors->any())
@foreach ($errors->all() as $error)
Swal.fire({
    toast: true,
    icon: 'error',
    title: '{{ $error }}',
    position: 'top-end',
    showConfirmButton: false,
    timer: 4000
});
@endforeach
@endif
</script>
@endsection