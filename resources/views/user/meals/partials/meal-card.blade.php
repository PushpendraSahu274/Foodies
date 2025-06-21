<div class="card product-card col-12 col-md-5 col-lg-3 p-0" data-id="{{$meal->id}}">
    <img class="card-img-top" src="{{ asset('images/userDashboard/burger1.jpg') }}" alt="Meal image" />

    <div class="card-body pb-0">
        <h5 class="Product-title">{{ $meal->title }}</h5>
        <p class="product-desc p-0 m-0">{{ $meal->description }}</p>
        <p class="product-cat p-0 m-0">
            <i class="fa-solid fa-seedling me-1 text-success"></i> Veg
            <i class="fa-solid fa-tags text-primary-color ms-2"></i> Bestseller
        </p>
        <p class="product-cat text-dark fw-bold p-0 m-0">
            <i class="fa-solid fa-warehouse me-1 text-primary-color"></i>
            {{ $meal->is_available == 1 ? 'In Stock' : 'Upcoming Soon' }}
        </p>
        <p class="product-price-details">
            <span><i class="fa-solid fa-indian-rupee-sign text-warning"></i> Price:</span>
            <span class=""> ₹{{$meal->mrp}}/- </span>
            <span class="text-decoration-line-through opacity-75 ms-2">
                ₹{{ $meal->discounted_price }}
            </span>
            <span class="text-success"> {{ $meal->discount }}% off</span>
        </p>
    </div>
    <button class="add2cartbtn">
        <i class="fa-solid fa-cart-plus mx-2"></i>Add to Cart
    </button>
</div>
