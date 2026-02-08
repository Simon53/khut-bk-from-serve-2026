@extends('layout.app')
@section('title', 'Khut::Site Category Menu')

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <h3 class="page-title">Category Menus</h3>
        </div>

        <div class="row ">
            <div class="col-md-12 mb-4">
                <button type="button" class="btn btn-info btn-fw"  data-toggle="modal" data-target="#addMenuModal">+ Createc New</button>
            </div>
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
                                    <th>Main Category </th>
                                    <th>Create Sub Category</th>
                                    <th>Show Sub Category</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                 @foreach($mainMenus as $menu)
                                <tr>
                                    <td>{{ $menu->name }}</td>
                                    <td><button class="btn btn-info btn-sm toggle-submenu" data-id="{{ $menu->id }}"  data-name="{{ $menu->name }}">Show Sub Category</button></td>
                                    <td><button class="btn btn-info btn-sm addSubmenuBtn" data-id="{{ $menu->id }}"data-name="{{ $menu->name }}" >Add Sub Category </button></td>
                                    <td><button class="btn btn-primary btn-sm editMenuBtn"data-id="{{  $menu->id }}" data-name="{{ $menu->name }}" data-toggle="modal" data-target="#editMenuModal">Edit</button></td>
                                    <td> <button class="btn btn-danger btn-sm deleteMenuBtn" data-id="{{ $menu->id }}" data-type="main">Delete</button></td>
                                </tr>
                                @endforeach
                               
                            </tbody>
                        </table>
                    </div>



                    <!-- Submenu Section (will be updated via JavaScript) -->
                    <div class="table-responsive" id="submenu-section" style="display: none; margin-top: 20px;">
                        <h4 id="submenu-title"></h4>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Sub Category Name</th>
                                    <th>Show Child Category</th>
                                    <th>Add Child Category</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody id="submenu-body">
                                <!-- Submenus will be injected here -->
                            </tbody>
                        </table>
                    </div>


                    <!-- Childmenu Section -->
                    <div  class="table-responsive" id="childmenu-section" style="display: none; margin-top: 20px;">
                        <h4 id="childmenu-title"></h4>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Child Category Name</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody id="childmenu-body">
                                <!-- Child menus will be injected here -->
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>       
</div>





<!-- Add Menu Modal -->
<div class="modal fade" id="addMenuModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="addMenuForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New Category</h5>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Main Menu Name" required>
                    </div>
                </div> <!-- Missing closing tag fixed -->

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>



<!-- Add Submenu Modal -->
<div class="modal fade" id="addSubmenuModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form id="addSubmenuForm">
      <input type="hidden" name="main_menu_id" id="submenu_main_menu_id">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Main Category: <span id="mainMenuNameTitle" class="text-primary"></span></h5>
          <button type="button" class="btn btn-danger" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
          <div class="form-group">
            <label>Sub Category Name</label>
            <input type="text" name="name" class="form-control" placeholder="Submenu Name" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Add</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Add Childmenu Modal -->
<div class="modal fade" id="addChildmenuModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form id="addChildmenuForm">
      <input type="hidden" name="submenu_id" id="childmenu_submenu_id">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Sub Category: <span id="submenuNameTitle" class="text-primary"></span></h5>
          <button type="button" class="btn btn-danger" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
          <div class="form-group">
            <label>Child Category Name</label>
            <input type="text" name="name" class="form-control" placeholder="Child Menu Name" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Add</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>



<!-- Edit Main Menu Modal -->
<div class="modal fade" id="editMenuModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="editMenuForm">
            <input type="hidden" name="edit_id" id="edit_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Category</h5>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" name="edit_name" id="edit_name" class="form-control" placeholder="Menu Name" required>
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

<!-- Edit Submenu Modal -->
<div class="modal fade" id="editSubmenuModal" tabindex="-1" role="dialog" aria-labelledby="editSubmenuModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="editSubmenuForm">
      @csrf
      <input type="hidden" name="id">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Sub Category</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Main Menu Dropdown -->
          <div class="form-group">
            <label for="main-menu-select">Main Category</label>
            <select class="form-control" name="main_menu_id" id="main-menu-select">
              @foreach($mainMenus as $mainMenu)
                <option value="{{ $mainMenu->id }}">{{ $mainMenu->name }}</option>
              @endforeach
            </select>
          </div>

          <!-- Submenu Name Input -->
          <div class="form-group">
            <label for="submenu-name">Sub Category Name</label>
            <input type="text" class="form-control" name="name" id="submenu-name" placeholder="Enter submenu name">
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>




<!-- Edit Edit child menu Modal -->
<div class="modal fade" id="editChildmenuModal" tabindex="-1" role="dialog">   
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editChildmenuForm">
        <div class="modal-header">
          <h5 class="modal-title">Edit Child Category</h5>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id">
          <div class="form-group">
            <label>Main Category</label>
            <select id="mainMenuSelect" class="form-control" name="main_menu_id"></select>
          </div>
          <div class="form-group">
            <label>Sub Category</label>
            <select id="submenuSelect" class="form-control" name="sub_menu_id"></select>
          </div>
          <div class="form-group">
            <label>Child Category Name</label>
            <input type="text" name="name" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>


@endsection  


@section('script')


<script type="text/javascript">
   
   const basePath = '/bd-admin/public';
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  
   
    $(document).ready(function () {
    // toastr options
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "3000"
    };

    // Add Menu Submit
    $('#addMenuForm').on('submit', function (e) {
        e.preventDefault();
        let formData = new FormData(this);

        axios.post(basePath + '/menu/store', formData)
            .then(res => {
                if (res.data.success) {
                    toastr.success('Menu created successfully');
                    $('#addMenuModal').modal('hide');
                    location.reload();
                } else {
                    toastr.error('Insert failed');
                }
            })
            .catch(err => {
                toastr.error('Something went wrong');
            });
    });

    // Show Edit Modal
    $(document).on('click', '.editMenuBtn', function () {
        const id = $(this).data('id');
        const name = $(this).data('name');

        $('#edit_id').val(id);
        $('#edit_name').val(name);
        $('#editMenuModal').modal('show');
    });

    // Edit Menu Submit
    $('#editMenuForm').on('submit', function (e) {
            e.preventDefault();
            const id = $('#edit_id').val();
            const name = $('#edit_name').val();

            axios.post(basePath + '/menu/update/' + id, { name: name })
                .then(res => {
                    if (res.data === 1 || res.data.success) {
                        toastr.success('Menu updated successfully');
                        $('#editMenuModal').modal('hide');
                        location.reload();
                    } else {
                        toastr.error('Update failed');
                    }
                })
                .catch(err => {
                    toastr.error('Something went wrong');
                });
        });
    });


  

    // Add submenu modal trigger
    $(document).ready(function () {
        // Add Submenu button click → modal open
        $(document).on('click', '.addSubmenuBtn', function () {
            const mainMenuId = $(this).data('id');
            const mainMenuName = $(this).data('name');

            $('#submenu_main_menu_id').val(mainMenuId);
            $('#mainMenuNameTitle').text(mainMenuName);
            $('#addSubmenuModal').modal('show');
        });

        // Submit Submenu Form
        $('#addSubmenuForm').on('submit', function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            axios.post('basePath + /submenu/store', formData)
                .then(res => {
                    if (res.data.success) {
                        toastr.success('Submenu added successfully');
                        $('#addSubmenuModal').modal('hide');
                        location.reload(); 
                    } else {
                        toastr.error('Submenu creation failed');
                    }
                })
                .catch(err => {
                    toastr.error('Something went wrong');
                    console.error(err);
                });
        });
    });




    // Open Add Childmenu Modal
    $(document).on('click', '.addChildmenuBtn', function () {
        const submenuId = $(this).data('id');
        const submenuName = $(this).data('name');

        $('#childmenu_submenu_id').val(submenuId);
        $('#submenuNameTitle').text(submenuName);
        $('#addChildmenuModal').modal('show');
    });

    // Submit Add Childmenu Form
    $('#addChildmenuForm').on('submit', function (e) {
        e.preventDefault();
        let formData = new FormData(this);

        axios.post(basePath + '/childmenu/store', formData)
            .then(res => {
                if (res.data.success) {
                    toastr.success('Child menu added successfully');
                    $('#addChildmenuModal').modal('hide');
                    location.reload(); // Reload to reflect changes
                } else {
                    toastr.error('Child menu creation failed');
                }
            })
            .catch(err => {
                console.error(err);
                toastr.error('Something went wrong');
            });
    });



    //load submenu
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.toggle-submenu').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const menuId = this.getAttribute('data-id');
                const menuName = this.getAttribute('data-name');
                const section = document.getElementById('submenu-section');
                const tbody = document.getElementById('submenu-body');
                const title = document.getElementById('submenu-title');

                // Clear old data
                tbody.innerHTML = '';
                title.innerText = `Main Category Name: "${menuName}"`;

                // Show section
                section.style.display = 'block';

                // Load submenu via AJAX
                axios.get(basePath + `/submenu/by-main/${menuId}`)
                    .then(function (response) {
                        const submenus = response.data;

                        if (submenus.length === 0) {
                            tbody.innerHTML = `<tr><td colspan="5" class="text-muted">No Submenus found.</td></tr>`;
                        } else {
                            submenus.forEach(function (submenu) {
                                const row = `
                                    <tr>
                                        <td>${submenu.name}</td>
                                        <td><button class="btn btn-sm btn-success showChildMenuBtn" data-id="${submenu.id}" data-name="${submenu.name}" data-main-name="${menuName}">Show Child Menu</button></td>
                                        <td><button class="btn btn-sm btn-success addChildmenuBtn" data-id="${submenu.id}" data-name="${submenu.name}" data-main-name="${menuName}">Add Child Menu</button></td>
                                        <td><button class="btn btn-sm btn-primary editSubmenuBtn" data-id="${submenu.id}" data-name="${submenu.name}" data-main-id="${submenu.main_menu_id}">Edit Sub Menu</button></td>
                                        <td><button class="btn btn-danger btn-sm deleteMenuBtn" data-id="${submenu.id}" data-type="sub">Delete</button></td>
                                    </tr>
                                `;
                                tbody.insertAdjacentHTML('beforeend', row);
                            });
                        }
                    })
                    .catch(function (error) {
                        console.error('Error fetching submenus:', error);
                        tbody.innerHTML = `<tr><td colspan="5" class="text-danger">Failed to load submenus.</td></tr>`;
                    });
            });
        });
    });


    // Show childmenus when clicking Show Child Menu
    $(document).on('click', '.showChildMenuBtn', function () {
        const submenuId = $(this).data('id');
        const submenuName = $(this).data('name');

        const childSection = document.getElementById('childmenu-section');
        const tbody = document.getElementById('childmenu-body');
        const title = document.getElementById('childmenu-title');

        tbody.innerHTML = '';
        childSection.style.display = 'block';

        axios.get(basePath + `/childmenu/by-submenu/${submenuId}`)
            .then(res => {
                const childMenus = res.data;

                if (childMenus.length === 0) {
                    title.innerText = `Sub Category: "${submenuName}"`;
                    tbody.innerHTML = `<tr><td colspan="3">No child menus found.</td></tr>`;
                    return;
                }

                const submenu = childMenus[0].sub_menu;
                const mainMenuName = submenu?.main_menu?.name || 'Unknown Main Menu';

                title.innerText = `Main Category: "${mainMenuName}" → Sub Category: "${submenu.name}"`;

                childMenus.forEach(child => {
                    const row = `
                        <tr>
                            <td>${child.name}</td>
                            <td><button class="btn btn-sm btn-primary editChildmenuBtn" data-id="${child.id}" data-name="${child.name}" data-submenu-id="${child.sub_menu_id}" data-main-id="${child.sub_menu ? child.sub_menu.main_menu_id : ''}">Edit</button></td>
                            <td><button class="btn btn-danger btn-sm deleteMenuBtn" data-id="${child.id}" data-type="child">Delete</button></td>
                        </tr>
                    `;
                    tbody.insertAdjacentHTML('beforeend', row);
                });
            })
            .catch(err => {
                console.error(err);
                tbody.innerHTML = `<tr><td colspan="3" class="text-danger">Error loading child menus.</td></tr>`;
            });
    });



   
   // Show edit submenu modal with data
    $(document).on('click', '.editSubmenuBtn', function () {
        let id = $(this).data('id');

        axios.get(basePath + `/submenu/edit/${id}`)
            .then(res => {
                $('#editSubmenuForm input[name="id"]').val(res.data.id);
                $('#editSubmenuForm input[name="name"]').val(res.data.name);
                $('#editSubmenuForm select[name="main_menu_id"]').val(res.data.main_menu_id);

                $('#editSubmenuModal').modal('show');
            })
            .catch(() => {
                alert("Failed to load submenu data.");
            });
    });




    // Submit updated submenu
    $('#editSubmenuForm').submit(function (e) {
        e.preventDefault();
        let formData = new FormData(this);

        axios.post(basePath + '/submenu/update', formData)
            .then(res => {
                if (res.data.success) {
                    toastr.success(res.data.message);
                    $('#editSubmenuModal').modal('hide');
                    location.reload(); // or refresh table if using AJAX table
                }
            })
            .catch(() => {
                toastr.error("Update failed.");
            });
    });


    // open edit chid menu modal open
  $(document).on('click', '.editChildmenuBtn', function () {
    let id = $(this).data('id');
    let name = $(this).data('name');
    let submenuId = $(this).data('submenu-id');
    let mainMenuId = $(this).data('main-id');

    // Debugging
    console.log({id, name, submenuId, mainMenuId});

    axios.get(basePath + `/childmenu/edit/${id}`)
        .then(response => {
            const child = response.data.child;
            const subMenus = response.data.subMenus;
            const mainMenus = response.data.mainMenus;

            $('#editChildmenuForm input[name="id"]').val(child.id);
            $('#editChildmenuForm input[name="name"]').val(child.name);

            // Populate main menu
            let mainOptions = '';
            mainMenus.forEach(menu => {
                mainOptions += `<option value="${menu.id}" ${menu.id == mainMenuId ? 'selected' : ''}>${menu.name}</option>`;
            });
            $('#mainMenuSelect').html(mainOptions);

            // Populate sub menu
            let subOptions = '';
            subMenus.forEach(sub => {
                subOptions += `<option value="${sub.id}" ${sub.id == submenuId ? 'selected' : ''}>${sub.name}</option>`;
            });
            $('#submenuSelect').html(subOptions);

            // Show the modal
            $('#editChildmenuModal').modal('show');
        })
        .catch(error => {
            console.error(error);
            alert('Something went wrong while fetching child menu.');
        });
    });

    // Change submenu options based on main menu
    $('#mainMenuSelect').on('change', function () {
        let mainId = $(this).val();

        axios.get(basePath + `/submenu/by-main/${mainId}`)
            .then(res => {
                let subSelect = $('#submenuSelect');
                subSelect.html('');
                res.data.forEach(sub => {
                    subSelect.append(`<option value="${sub.id}">${sub.name}</option>`);
                });
            });
    });

    // Submit Update
    $('#editChildmenuForm').submit(function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

        $.ajax({
            url: basePath + '/childmenu/update',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                toastr.success("Child Menu Updated");
                $('#editChildmenuModal').modal('hide');
                loadChildMenus(); // refresh table if implemented
            },
            error: function (err) {
                toastr.error("Something went wrong");
                console.log(err);
            }
        });
    });


    //Main delete script
    $(document).on('click', '.deleteMenuBtn', function () {
        const id = $(this).data('id');
        axios.post(basePath + '/menu/delete/' + id)
            .then(res => {
                if (res.data.success) {
                    toastr.success("Menu deleted successfully");
                    location.reload();
                } else {
                    toastr.error(res.data.message || "Delete failed");
                }
            })
            .catch(err => {
                toastr.error("Something went wrong");
                console.error(err);
            });
       
    });



    // DELETE Main Menu
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    
    $(document).on("click", ".deleteMenuBtn", function () {
        const id = $(this).data("id");
        const type = $(this).data("type");
        const button = $(this);

        Swal.fire({
        title: "Are you sure?",
        text: "This action cannot be undone!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
            url: basePath + `/${type}menu/delete/${id}`,
            type: "DELETE",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (res) {
                toastr.success(res.message);

                // remove the row from table
                button.closest("tr").remove();
            },
            error: function (xhr) {
                toastr.error("Something went wrong!");
            },
            });
        }
        });
    });
</script>
@endsection