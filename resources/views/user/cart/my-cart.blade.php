@extends('user.layouts.master')

@section('page-title')
    My Cart
@endsection

@section('user-page-content')
    <div class="row my-card-container gap-1 py-3 mt-6">
        <!-- single product starts -->
        @foreach ($carts as $cart)
            {{-- @dd($cart) --}}
            <div class="card cart-product-card col-sm-12 col-md-5 col-lg-3 p-0" data-cart-id="{{ $cart->id }}"
                data-cart-quantity = "{{ $cart->quantity }}">
                <img class="card-img-top" src="{{ $cart->item->picture_path }}" alt="Card image cap" />

                <div class="card-body pb-0">
                    <h5 class="Product-title">{{ $cart->item->title }}</h5>
                    <p class="product-desc p-0 m-0">
                        {{ $cart?->item?->description }}
                    </p>
                    <p class="product-cat p-0 m-0">
                        <i class="fa-solid fa-seedling me-1 text-success"></i>{{ $cart?->item->category->category_name }}
                        <i class="fa-solid fa-tags text-primary-color ms-2"></i>
                        Bestseller
                    </p>
                    <p class="product-cat text-dark fw-bold p-0 m-0">
                        <i
                            class="fa-solid fa-warehouse me-1 text-primary-color"></i>{{ $cart?->item?->is_available ? 'Instock' : 'Outofstock' }}
                    </p>
                    <div class="btn-group py-2" role="group" aria-label="Quantity control">
                        <!-- Plus button -->
                        <button type="button" class="btn btn-outline-danger fs-sm py-0 rounded-start QuantityPlusBtn">
                            +
                        </button>

                        <!-- Quantity display -->
                        <button type="button" class="btn btn-outline-secondary py-0 rounded-0 QuantityDisplayBtn" disabled>
                            {{ $cart->quantity }}
                        </button>

                        <!-- Minus button -->
                        <button type="button" class="btn btn-outline-danger py-0 rounded-end QuantityMinusBtn">
                            -
                        </button>
                    </div>
                    <p class="product-price-details">
                        <span> Single Item's Price : </span>
                        <span class=""> &#8377; {{ $cart->item_price }}/- </span>
                        <span class="text-decoration-line-through opacity-75 ms-2">
                            &#8377; {{ $cart?->item->mrp }}
                        </span>
                        <span class="text-success"> {{ $cart->item->discount_percentage }}% off</span>
                    </p>
                    <p class="product-price-details">
                        <span> Total Price : </span>
                        <span class="total-amount"> &#8377; {{ $cart->total_amount }} </span>
                        <span class="opacity-75 ms-2"> You saved &#8377; </span>
                        <span class="text-success total-discount">{{ $cart->item_total_discount }}</span>
                    </p>
                </div>
                <button class="orderNowButton add2cartbtn">
                    <i class="fa-solid fa-cart-plus mx-2"></i>Order Now
                </button>
            </div>
        @endforeach

        <!-- single product ends -->
    </div>
@endsection

@section('user-page-script')
    <script>
        $(document).on('click', '.QuantityPlusBtn, .QuantityMinusBtn', function() {
            const $button = $(this);
            const $cart = $button.closest('.cart-product-card');
            const cartId = $cart.data('cart-id');
            let quantity = parseInt($cart.data('cart-quantity'));
            const isPlus = $button.hasClass('QuantityPlusBtn');
            const newQuantity = isPlus ? quantity + 1 : quantity - 1;

            if (newQuantity === 0) {
                // Remove from cart
                $.ajax({
                    url: "{{ route('customer.cart.remove') }}",
                    type: "POST",
                    data: {
                        cart_id: cartId
                    },
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            text: response.message || 'Item removed from cart'
                        });

                        $cart.remove(); // Remove item card from UI
                    },
                    error: function(xhr) {
                        let message = 'Unexpected error occurred!';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            text: message,
                        });
                    }
                });
            } else {
                // Update cart quantity
                console.log(cartId);
                $.ajax({
                    url: "{{ route('customer.cart.update') }}",
                    type: "POST",
                    data: {
                        cart_id: cartId,
                        quantity: newQuantity
                    },
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update quantity in HTML
                            $cart.data('cart-quantity', newQuantity);
                            $cart.find('.QuantityDisplayBtn').text(newQuantity);

                            // Update price details if returned
                            if (response.data) {
                                const item = response.data;
                                $cart.find('.item-price').text('₹ ' + item.item_price);
                                $cart.find('.total-amount').text('₹ ' + item.total_amount);
                                $cart.find('.total-discount').text(item.item_total_discount);
                            }

                            Swal.fire({
                                icon: 'success',
                                text: response.message || 'Cart updated successfully',
                            });
                        }
                    },
                    error: function(xhr) {
                        let message = 'Unexpected error occurred!';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            text: message,
                        });
                    }
                });
            }
        });

        // });
    </script>

    <script>
        $(document).on('click', '.orderNowButton', function() {
            const $button = $(this);
            const $cart = $button.closest('.cart-product-card');
            const cartId = $cart.data('cart-id');

            $.ajax({
                url: "{{ route('customer.order.store') }}",
                type: "POST",
                data: {
                    cart_id: cartId
                },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        text: response.message || 'Order placed successfully!'
                    }).then(() => {
                        $cart.remove();
                        if (response.redirect) {
                            window.location.href = response.redirect;
                        }
                    });
                },
                error: function(xhr) {
                    let message = 'Unexpected error occurred!';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        text: message,
                    });
                }
            });

        });

        // });
    </script>
@endsection
