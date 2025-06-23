@extends('admin.layouts.master')

@section('page-title')
    meals
@endsection

@section('admin-page-content')
    <!-- add Product Modal start -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content smallfont">
                <div class="modal-header">
                    <h5 class="modal-title text-primary-color fw-bold" id="addProductModalLabel">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addProductForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 mb-3">
                                <label for="productName" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="productName" name="title"
                                    placeholder="Enter the product name" />
                            </div>

                            <div class="col-sm-12 mb-3">
                                <label for="productDescription" class="form-label">Product Description</label>
                                <input type="text" class="form-control" id="productDescription" name="description"
                                    placeholder="Enter the product description" />
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label for="pPrice" class="form-label">Product Price</label>
                                <input type="number" class="form-control" id="pPrice" name="price"
                                    placeholder="Enter price in ₹" />
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label for="pdiscount" class="form-label">Discount</label>
                                <input type="number" class="form-control" id="pdiscount" name="discount"
                                    placeholder="Enter discount in ₹" />
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label for="tags" class="form-label">Select Tag</label>
                                <select class="form-select" id="tags" name="tag">
                                    <option value="BestSeller">Bestseller</option>
                                    <option value="extra-discount">Extra Discount</option>
                                </select>
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-select" id="category" name="meal_category_id">
                                    <option value="">---Select---</option>
                                    @foreach ($meal_categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }} </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-12 mb-3">
                                <label for="pieces" class="form-label">Available Pieces</label>
                                <input type="number" class="form-control" id="pieces" name="quantity"
                                    placeholder="Enter available quantity" />
                            </div>

                            <div class="col-sm-12 mb-3">
                                <label for="product-image" class="form-label">Product Image</label>
                                <input type="file" class="form-control" id="addProductImage" name="photo"
                                    accept="image/*" />

                                {{-- Preview Add Product Image --}}
                                <img src="" alt="none" class="d-none" id="previewAddProductImage" height="70px"
                                    width="70px" />
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fa-solid fa-arrow-up-from-bracket me-1"></i>Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- add Product Modal end -->

    <!-- Update Product Modal Start -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content smallfont">
                <div class="modal-header">
                    <h5 class="modal-title text-primary-color fw-bold" id="editProductModalLabel">Edit Product Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="productEditForm" enctype="multipart/form-data">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="productName" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="productName"
                                    placeholder="Enter the product name" name="title" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="productDesc" class="form-label">Product Description</label>
                                <input type="text" class="form-control" id="productDesc"
                                    placeholder="Enter the product description" name="description" />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="pPrice" class="form-label">Product Price</label>
                                <input type="number" class="form-control" id="pPrice"
                                    placeholder="Enter product price in rupees" name="price" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="pdiscount" class="form-label">Discount</label>
                                <input type="number" class="form-control" id="pdiscount"
                                    placeholder="Enter product discount in rupees" name="discount" />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="pieces" class="form-label">Available Pieces</label>
                                <input type="number" class="form-control" id="pieces"
                                    placeholder="Enter product available pieces" name="quantity" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="tags" class="form-label">Select Tags</label>
                                <select class="form-select" id="tags">
                                    <option value="BestSeller">Bestseller</option>
                                    <option value="extra-discount">Extra Discount</option>
                                </select>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-select" id="category" name="meal_category_id">
                                    <option value="" selected> ---Select---</option>
                                    @foreach ($meal_categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="product-image" class="form-label">Product Image</label>
                                <input type="file" class="form-control" id="productImage" name="photo" />

                                <img src="" alt="" id="previewProductImage" height="70px"
                                    width="70px" class="d-none" />
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('admins.dashboard') }}"
                                class="text-primary-color btn bg-white shadow-lg mx-2">
                                <i class="fa-solid fa-angles-left"></i>
                            </a>
                            <button class="bg-success text-white btn px-3 py-1" type="reset">
                                <i class="fa-solid fa-arrow-rotate-left"></i>
                            </button>
                            <button class="btn btn-outline-danger px-3 py-1" type="submit">
                                <i class="fa-solid fa-arrow-up-from-bracket mx-1"></i>upload
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Update Product Modal Start -->

    <div class="container">
        <div class="row">
            <div
                class="col-sm-12 text-white opacity-100 fw-bold p-2 rounded rounded-1 mb-3 bg-primary-color d-flex justify-content-between align-items-center">
                <div>
                    <i class="fa-solid fa-utensils bg-white text-primary-color rounded p-1"></i>
                    Uploaded Products
                </div>

                <div class="d-flex gap-2">
                    <form action="{{ route('meals.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label class="btn bg-white text-primary-color p-2 rounded m-0" style="cursor: pointer;">
                            <i class="fa-solid fa-file-csv bg-level-2 text-white p-1 rounded"></i> Upload CSV
                            <input type="file" name="csv_file" accept=".csv" onchange="this.form.submit()" hidden>
                        </label>
                    </form>

                    <button type="button" class="bg-white p-2 rounded text-primary-color border-0"
                        data-bs-toggle="modal" data-bs-target="#addProductModal">
                        <i class="fa-solid fa-plus bg-level-2 text-white p-1 rounded"></i> Product
                    </button>
                </div>
            </div>

            {{-- Toaster to show the message --}}
            @if (session('message'))
                <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
                    <div id="liveToast" class="toast align-items-center text-white bg-success border-0 show"
                        role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                {{ session('message') }}
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                                aria-label="Close"></button>
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const toastElement = document.getElementById('liveToast');
                        const toast = new bootstrap.Toast(toastElement);
                        toast.show();
                    });
                </script>
            @endif

            <div class="col-sm-12 table-responsive">
                <table id="productTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Product Id</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Category</th>
                            <th scope="col">Discount</th>
                            <th scope="col">Availability</th>
                            <th scope="col">Image</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('admin-script-content')
    <script src="{{ asset('js/datatable.js') }}"></script>
    <script>
        datatable('#productTable', "{{ route('meals.ajax') }}");
    </script>
    <script>
        previewImage('previewProductImage', 'productImage');
        previewImage('previewAddProductImage', 'addProductImage')
    </script>

    <script>
        $('#productTable').on('click', '.delete-btn', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/meal/delete/' + id,
                        type: 'GET',
                        success: function(response) {
                            datatable('#productTable', "{{ route('meals.ajax') }}");
                            Swal.fire({
                                title: 'success',
                                text: response.message,
                                icon: 'Success',
                                confirmButtonText: 'OK',
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                title: 'Error',
                                text: xhr.responseJSON?.message ||
                                    'Something went wrong while deleting the meal.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    })
                }
            });


        });
    </script>
    <script>
        $('#addProductForm').on('submit', function(e) {
            e.preventDefault(); // Prevent normal form submission

            const formData = new FormData(this);

            $.ajax({
                url: "{{ route('meals.store') }}", // Laravel route
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF protection
                },
                data: formData,
                processData: false, // Required for FormData
                contentType: false, // Required for FormData
                success: function(response) {
                    Swal.fire({
                        title: 'Success',
                        text: response.message || 'Meal added successfully!',
                        icon: 'success',
                    });
                    datatable('#productTable', "{{ route('meals.ajax') }}");
                    $('#addProductModal').modal('hide');
                    $('#addProductModal')[0].reset(); // Optional: reset form
                    //reload the datatable
                },
                error: function(xhr, status, error) {
                    let message = "Something went wrong!";
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        title: 'Error',
                        text: message,
                        icon: 'error',
                    });
                }
            });
        });
    </script>

    <script>
        $('#productTable').on('click', '.edit-btn', function() {
            const id = $(this).data('id');

            $('#productEditForm').data('id', id); //setting the id in the form

            $('#editProductModal').modal('show');
        });
    </script>
    <script>
        $('#productEditForm').on('submit', function(e) {
            e.preventDefault(); // Prevent normal form submission

            const id = $(this).data('id') // Correct optional chaining

            const formData = new FormData(this);
            formData.append('id', id);
            $.ajax({
                url: "{{ route('meals.update') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        title: 'Success',
                        text: response.message || 'Meal Updated successfully!',
                        icon: 'success',
                    });
                    if ($.fn.DataTable.isDataTable('#productTable')) {
                        $('#productTable').DataTable().destroy();
                    }

                    datatable('#productTable', "{{ route('meals.ajax') }}");
                    $('#editProductModal').modal('hide');
                    $('#editProductModal')[0].reset(); // Optional: reset form
                },
                error: function(xhr, status, error) {
                    let message = "Something went wrong!";
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        title: 'Error',
                        text: message,
                        icon: 'error',
                    });
                }
            });
        });
    </script>
@endsection
