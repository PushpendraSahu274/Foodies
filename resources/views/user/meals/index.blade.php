@extends('user.layouts.master')
@section('page-title')
    All products
@endsection

@section('user-page-content')
    <section id="allProducts">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="fs-5 pt-1">All Products</h1>

                    <!-- Filter Form Start -->
                    <form id="filterForm" method="POST">
                        <div class="navbar navbar-expand-lg navbar-white bg-white">
                            <div class="p-0 container-fluid">
                                <h4 class="opacity-75 fw-normal filter-heading">Filters</h4>
                                <button class="p-0 navbar-toggler" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                    aria-expanded="false" aria-label="Toggle navigation">
                                    <i class="fa-solid fa-sliders fs-5 me-2 text-primary-color"></i>
                                </button>

                                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                    <div class="navbar-nav w-full ms-auto mb-2 mb-lg-0 d-flex justify-content-between">
                                        <div class="nav-item col-12 col-md-3 filters mx-0 mx-lg-1 my-1 my-md-0">
                                            <select class="form-select form-select-sm" name="price_filter">
                                                <option selected value="">Filter by price</option>
                                                <option value="100">upto ₹100</option>
                                                <option value="150">upto ₹150</option>
                                                <option value="200">upto ₹200</option>
                                                <option value="250">upto ₹250</option>
                                                <option value="300">upto ₹300</option>
                                                <option value="350">upto ₹350</option>
                                                <option value="400">upto ₹400</option>
                                                <option value="450">upto ₹450</option>
                                            </select>
                                        </div>

                                        <div class="nav-item col-12 col-md-3 filters mx-0 mx-lg-1 my-1 my-md-0">
                                            <select class="form-select form-select-sm" name="category_filter">
                                                <option selected value="">Filter by Category</option>
                                                @foreach ($meal_categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->category_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="nav-item col-12 col-md-3 filters mx-0 mx-lg-1 my-1 my-md-0">
                                            <select class="form-select form-select-sm" name="stock_filter">
                                                <option selected value="">Filter by Stock</option>
                                                <option value="1">In Stock</option>
                                                <option value="0">Upcoming</option>
                                            </select>
                                        </div>

                                        <div
                                            class="nav-item col-12 col-md-3 d-flex align-items-center mx-0 mx-lg-1 my-1 my-md-0">
                                            <button type="submit"
                                                class="btn fiter-submit-btn bg-primary-color fw-bold p-1 px-2">
                                                Apply
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- Filter Form End -->

                    <!-- Product Cards Start -->
                    <div class="p-0 row product-card-container d-flex justify-content-around gap-1 py-2" id="meal-listing">
                        @foreach ($meals as $meal)
                            @include('user.meals.partials.meal-card', ['meal' => $meal])
                        @endforeach
                    </div>
                    <!-- Product Cards End -->

                </div>
            </div>
        </div>
    </section>
@endsection

@section('user-page-script')
    <script>
        $('#filterForm').on('submit', function(event) {
            event.preventDefault(); //prevent page from submit.
            const formData = new FormData(this); //form data
            $.ajax({
                url: "{{ route('customer.meal.ajax') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                },
                success: function(response) {
                    console.log(response.message);
                    $('#meal-listing').html(response.data.html);
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'error',
                        text: error,
                        icon: 'error'
                    });
                },
            })
        });
    </script>
    
    <script>
    // add to cart button
    $('#meal-listing').on('click','.product-card', function(){
        const productId = $(this).data('id');
        let baseUrl = "{{route('customer.cart.add',['id' => ':id'])}}";
        
        baseUrl = baseUrl.replace(':id',productId);

        $.ajax({
            url:baseUrl,
            type:'GET',
            success:function(response){
                Swal.fire(response.message);
            },
            error:function(xhr, status, error){
                Swal.fire({
                    title:'error',
                    text:status,
                    icon:'error',
                })
            }
        })
    });
    </script>
@endsection
