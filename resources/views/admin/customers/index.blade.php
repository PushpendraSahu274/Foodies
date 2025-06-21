@extends('admin.layouts.master')
@section('page-title')
    customer
@endsection

@section('admin-page-content')
    <div class="container-fluid px-0">

        <!-- sidebar ends -->
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-white opacity-100 fw-bold p-1 px-2 p-lg-2 rounded mb-3 bg-primary-color">
                    <i class="fa-solid fa-users bg-white text-primary-color rounded p-1"></i>
                    Customers
                </div>
                <div class="col-sm-12 table-responsive">
                    <table class="table" id="customerTable">
                        <thead>
                            <tr>
                                <th scope="col">Customer Id</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Customer Email</th>
                                <th scope="col">Customer Mobile</th>
                                <th scope="col">Customer Joined</th>

                                <th scope="col">Profile Picture</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- <-- customer profile Modal start --> --}}
    <!-- Customer Profile Modal -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="customerProfileOffcanvas"
        aria-labelledby="customerProfileLabel">
        <div class="offcanvas-header bg-danger text-white">
            <h5 class="offcanvas-title" id="customerProfileLabel">
                <i class="fa fa-user-circle me-2"></i>Customer Profile
            </h5>
            <button type="button" class="btn-close text-reset bg-light" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body" id="customerProfileBody">
            <!-- Profile details will be loaded here via AJAX -->
            <div class="text-center p-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
    {{-- <-- customer profile Modal start --> --}}
@endsection

@section('admin-script-content')
    <script src="/js/datatable.js"></script>
    <script>
        datatable('#customerTable', "{{ route('customers.listing') }}");
    </script>

    <script>
        $('#customerTable').on('click', '.view-profile-btn', function() {
            const customerId = $(this).data('id');

            $('#customerProfileBody').html(
                '<div class="text-center p-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>'
            );

            $.ajax({
                url: `/customers/${customerId}/profile`,
                type: 'GET',
                success: function(html) {
                    $('#customerProfileBody').html(html);
                    $('#customerProfileModal').modal('show');
                },
                error: function() {
                    $('#customerProfileBody').html(
                        '<div class="text-danger p-3 text-center">Failed to load customer profile.</div>'
                    );
                }
            });
        });
    </script>
@endsection
