@extends('layout.app')
@section('title', 'Khut::Protuct List')
@section('content')
<div class="container-fluid">
   <div class="page-header">
      <h3 class="page-title">Product List Page: Menu Category</h3>
   </div>
   <form method="GET" action="{{ route('product.list') }}">
      <div class="form-group row">
         <div class="col-md-3">
            <label>Main Menu</label>
            <select name="main_menu_id" id="main_menu" class="form-control">
               <option value="">Select Main Menu</option>
               @foreach($mainMenus as $main)
               <option value="{{ $main->id }}" {{ request('main_menu_id') == $main->id ? 'selected' : '' }}>{{ $main->name }}</option>
               @endforeach
            </select>
         </div>
         <div class="col-md-3">
            <label>Sub Menu</label>
            <select name="sub_menu_id" id="sub_menu" class="form-control" {{ !request('main_menu_id') ? 'disabled' : '' }}>
            <option value="">Select Sub Menu</option>
            {{-- JavaScript will populate dynamically --}}
            </select>
         </div>
         <div class="col-md-3">
            <label>Child Menu</label>
            <select name="child_menu_id" id="child_menu" class="form-control" {{ !request('sub_menu_id') ? 'disabled' : '' }}>
            <option value="">Select Child Menu</option>
            {{-- JavaScript will populate dynamically --}}
            </select>
         </div>
         <div class="col-md-3">
            <label>Search By Title</label>
            <input type="text" name="title" class="form-control" value="{{ request('title') }}" placeholder="Search By Title">
         </div>
         <div class="col-md-12 text-right mt-2">
            <button class="btn btn-primary">Search</button>
            
         </div>
      </div>
   </form>
   
   <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
         <div class="card">
            <div class="card-body">
               <div class="table-responsive" style="max-height: 480px; overflow-y: auto;">
                  <table class="table table-bordered table-striped">
                     <thead class="thead-dark" style="position: sticky; top: 0; z-index: 1;">
                        <tr>
                           <th>Sl</th>
                           <th>Slug</th>
                           <th>Title(Eng)</th>
                           <th>Main Image</th>
                           <th>Barcode</th>
                           <th>Category</th>
                           <th>Price</th>
                           <th>Link Status</th>
                           <th>Show Home</th>
                           <th>New Arrivals</th>
                           <th>Patchwork</th>
                           <th>Published</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @forelse($products as $key => $product)
                        <tr>
                           <td>{{ $products->firstItem() + $key }}</td>
                           <td>{{ $product->slug }}</td>
                           <td>{{ $product->name_en }}</td>
                           <td><img src="{{ asset('storage/' . $product->main_image) }}" style="width:100px; height: auto; border-radius:0"></td>
                           <td>{{ $product->product_barcode}}</td>
                           <td>
                              {{ $product->mainMenu->name ?? '-' }}  </br>  >
                              {{ $product->subMenu->name ?? '-' }} </br> >>
                              {{ $product->childMenu->name ?? '-' }}
                           </td>
                           <td>{{ $product->price }}</td>
                           <td>{{ $product->link_status }}</td>
                           <td>{{ $product->site_view_status == 'Y' ? 'Yes' : 'No' }}</td>
                           <td>{{ $product->new_arrivals == 'Y' ? 'Yes' : 'No' }}</td>
                           <td>{{ $product->patchwork == 'Y' ? 'Yes' : 'No' }}</td>
                           <td>{{ $product->published_site == 'Y' ? 'Yes' : 'No' }}</td>
                           <td>
                              <a href="{{ route('product.edit', $product->id) }}" class="btn btn-primary btn-sm">Details/Edit</a>

                              <button class="btn btn-danger btn-sm deleteProductBtn" data-id="{{ $product->id }}">Delete</button>
                           </td>
                        </tr>
                        @empty
                        <tr>
                           <td colspan="12">No products found.</td>
                        </tr>
                        @endforelse
                     </tbody>
                  </table>
                  {{ $products->withQueryString()->links() }}
               </div>
            </div>
         </div>
      </div>
   </div>
   
</div>
@endsection  
@section('script')
<script type="text/javascript">
$(document).ready(function() {

    // -----------------------------
    // Prefill dropdowns on page load
    // -----------------------------
    let mainId = $('#main_menu').val();
    let subId = '{{ request("sub_menu_id") }}';
    let childId = '{{ request("child_menu_id") }}';
    const basePath = '/bd-admin/public';

    if (mainId) {
        $('#sub_menu').prop('disabled', true).html('<option>Loading...</option>');

        $.get('{{ url("product/sub-menus") }}/' + mainId, function(data) {
            let options = '<option value="">Select Sub Menu</option>';
            data.forEach(item => {
                options += `<option value="${item.id}" ${item.id == subId ? 'selected' : ''}>${item.name}</option>`;
            });
            $('#sub_menu').html(options).prop('disabled', false);

            // If a sub menu is already selected, load child menus
            if (subId) {
                $('#child_menu').prop('disabled', true).html('<option>Loading...</option>');
                $.get('{{ url("product/child-menus") }}/' + subId, function(data2) {
                    let childOptions = '<option value="">Select Child Menu</option>';
                    data2.forEach(item => {
                        childOptions += `<option value="${item.id}" ${item.id == childId ? 'selected' : ''}>${item.name}</option>`;
                    });
                    $('#child_menu').html(childOptions).prop('disabled', false);
                });
            }
        });
    }

    // -----------------------------
    // Main menu change
    // -----------------------------
    $('#main_menu').on('change', function () {
        var mainId = $(this).val();
        $('#sub_menu').prop('disabled', true).html('<option>Loading...</option>');
        $('#child_menu').prop('disabled', true).html('<option>Select Child Menu</option>');

        if (mainId) {
            $.get('{{ url("product/sub-menus") }}/' + mainId, function (data) {
                let options = '<option value="">Select Sub Menu</option>';
                data.forEach(item => {
                    options += `<option value="${item.id}">${item.name}</option>`;
                });
                $('#sub_menu').html(options).prop('disabled', false);
            });
        } else {
            $('#sub_menu').html('<option value="">Select Sub Menu</option>').prop('disabled', true);
        }
    });

    // -----------------------------
    // Sub menu change
    // -----------------------------
    $('#sub_menu').on('change', function () {
        var subId = $(this).val();
        $('#child_menu').prop('disabled', true).html('<option>Loading...</option>');

        if (subId) {
            $.get('{{ url("product/child-menus") }}/' + subId, function (data) {
                let options = '<option value="">Select Child Menu</option>';
                data.forEach(item => {
                    options += `<option value="${item.id}">${item.name}</option>`;
                });
                $('#child_menu').html(options).prop('disabled', false);
            });
        } else {
            $('#child_menu').html('<option value="">Select Child Menu</option>').prop('disabled', true);
        }
    });

    // -----------------------------
    // Delete Product
    // -----------------------------
    
    $(document).on('click', '.deleteProductBtn', function () {
        let productId = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url:basePath + "/product/delete/" + productId,
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        toastr.success("Product deleted successfully!");
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    },
                    error: function (xhr) {
                        toastr.error("Something went wrong!");
                    }
                });
            }
        });
    });

});
</script>

@endsection