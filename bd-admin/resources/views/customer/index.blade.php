@extends('layout.app')
@section('title', 'Khut::Customers')

@section('content')
<div class="page-header">
    <h3 class="page-title">Customers</h3>
</div>

<div class="row">
    <div class="col-md-12 mb-4">
        <button type="button" class="btn btn-info btn-fw" disabled>+ Add Customer</button>
    </div>

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>SL</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Display Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customers as $key => $customer)
                                <tr>
                                    <td>{{ $customers->firstItem() + $key }}</td>
                                    <td>{{ $customer->first_name ?? '-' }}</td>
                                    <td>{{ $customer->last_name ?? '-' }}</td>
                                    <td>{{ $customer->display_name ?? '-' }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm deleteCustomerBtn" data-id="{{ $customer->id }}">
                                            <i class="mdi mdi-delete"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No customers found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $customers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <p>Are you sure you want to delete this customer?</p>
                <input type="hidden" id="deleteCustomerId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="confirmDeleteBtn" class="btn btn-danger">Yes, Delete</button>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
<script src="{{ asset('/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>

<script>
$(document).ready(function(){

    // Modal open & ID store
    $('.deleteCustomerBtn').click(function(){
        const id = $(this).data('id');
        $('#deleteCustomerId').val(id);
        $('#deleteConfirmModal').modal('show');
    });

    // Confirm delete button
    $('#confirmDeleteBtn').click(function(){
        const id = $('#deleteCustomerId').val();

        $.ajax({
            url: "{{ url('customer') }}/" + id,
            type: 'POST',
            data: {
                _method: 'DELETE',
                _token: '{{ csrf_token() }}'
            },
            success: function(res){
                if(res.success){
                    $('#deleteConfirmModal').modal('hide');

                    // remove deleted row without reload
                    $('button[data-id="'+id+'"]').closest('tr').fadeOut(400, function(){
                        $(this).remove();
                    });
                }
            }
        });
    });

});
</script>

@endsection
