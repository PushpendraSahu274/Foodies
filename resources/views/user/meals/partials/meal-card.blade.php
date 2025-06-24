
    <div class="card product-card col-12 col-md-6 col-lg-3 p-2" data-id="{{ $meal->id }}">
        <img class="card-img-top" src="{{ $meal->picture_path }}" alt="{{ $meal->title ?? 'Meal image' }}">

        <div class="card-body pb-0">
            <h5 class="product-title">{{ $meal->title ?? 'Untitled Meal' }}</h5>
            <p class="product-desc p-0 m-0">{{ $meal->description ?? 'No description available.' }}</p>

            <p class="product-cat p-0 m-0">
                <i class="fa-solid fa-seedling me-1 text-success"></i> Veg
                <i class="fa-solid fa-tags text-primary-color ms-2"></i> Bestseller
            </p>

            <p class="product-cat text-dark fw-bold p-0 m-0">
                <i class="fa-solid fa-warehouse me-1 text-primary-color"></i>
                {{ $meal->is_available == 1 ? 'In Stock' : 'Upcoming Soon' }}
            </p>

            <p class="product-price-details mt-2">
                <span><i class="fa-solid fa-indian-rupee-sign text-warning"></i> Price:</span>
                <span class="ms-1">₹{{ $meal->mrp ?? '0' }}/-</span>
                @if (!empty($meal->discounted_price))
                    <span class="text-decoration-line-through opacity-75 ms-2">₹{{ $meal->discounted_price }}</span>
                @endif
                @if (!empty($meal->discount))
                    <span class="text-success ms-1">{{ $meal->discount }}% off</span>
                @endif
            </p>
        </div>

        <button class="add2cartbtn w-100 mt-2">
            <i class="fa-solid fa-cart-plus mx-2"></i>Add to Cart
        </button>
    </div>

