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
                                <input type="text" class="form-control" id="productName" name="name"
                                    placeholder="Enter the product name" required />
                            </div>

                            <div class="col-sm-12 mb-3">
                                <label for="productDescription" class="form-label">Product Description</label>
                                <input type="text" class="form-control" id="productDescription" name="description"
                                    placeholder="Enter the product description" required />
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label for="pPrice" class="form-label">Product Price</label>
                                <input type="number" class="form-control" id="pPrice" name="price"
                                    placeholder="Enter price in ₹" required />
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label for="pdiscount" class="form-label">Discount</label>
                                <input type="number" class="form-control" id="pdiscount" name="discount"
                                    placeholder="Enter discount in ₹" required />
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
                                <select class="form-select" id="category" name="category">
                                    <option value="veg">Veg</option>
                                    <option value="non-veg">Non-Veg</option>
                                </select>
                            </div>

                            <div class="col-sm-12 mb-3">
                                <label for="pieces" class="form-label">Available Pieces</label>
                                <input type="number" class="form-control" id="pieces" name="pieces"
                                    placeholder="Enter available quantity" required />
                            </div>

                            <div class="col-sm-12 mb-3">
                                <label for="product-image" class="form-label">Product Image</label>
                                <input type="file" class="form-control" id="product-image" name="image" required />
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
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-white opacity-100 fw-bold p-2 rounded rounded-1 mb-3 bg-primary-color">
                <i class="fa-solid fa-utensils bg-white text-primary-color rounded p-1"></i>
                Uploaded Products
                <button type="button" class="bg-white p-2 rounded mx-2 text-primary-color border-0" data-bs-toggle="modal"
                    data-bs-target="#addProductModal">
                    <i class="fa-solid fa-plus bg-level-2 text-white p-1 rounded"></i> Product
                </button>
            </div>
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
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>

        $('#productTable').DataTable({
            "processing": true,
            "serverSide": true,
            "scrollX": true,
            "autoWidth": false,
            "lengthMenu": [10, 50, 100, 500, 1000],
            "pageLength": 10,
            "ajax": {
                "url": '{{ route('meals.ajax') }}',
                "type": "GET",
                "data": function(d) {
                    return $.extend({}, d);
                },
                "error": function(xhr, status, error) {
                    console.log("AJAX Error:", error);
                }
            },
            "initComplete": function() {
                $('#productTable').DataTable().columns.adjust().responsive.recalc();
            },
            "dom": '<"top"lBf>rt<"bottom"ip><"clear">',
            "buttons": [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    </script>
@endsection
