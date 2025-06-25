<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Meal Available!</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 30px; margin: 0;">


    <div style="
        max-width: 600px;
        margin: auto;
        background-color: #ffffff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    ">
        <!-- Meal Image -->
        <div style="text-align: center; background-color: #fafafa; padding: 20px;">
            <img src="{{ asset('storage/' . $meal->picture_path) }}" alt="Meal image" width="200" style="border-radius: 6px;">
        </div>
        {{-- @dd(asset('storage/'.$meal->picture_path)); --}}
        <!-- Meal Details -->
        <div style="padding: 20px;">
            <h2 style="color: #333333; margin-bottom: 10px;">🍽️ {{ $meal->title }}</h2>
            <p style="color: #666666; font-size: 15px; margin-top: 0;">{{ $meal->description ?? 'this is mango default description' }}</p>

            <p style="font-size: 16px; color: #555555; margin-top: 20px;">
                <strong>Price:</strong> {{ $meal->mrp ?? '29' }} ₹ <br>
                <strong>Discount:</strong> {{ $meal->discount_percentage }}%
            </p>

            <!-- CTA Buttons -->
            <div style="margin-top: 30px;">
                <a href="{{ url('/customer/order/index') }}" style="
                    display: inline-block;
                    padding: 10px 20px;
                    margin-right: 10px;
                    background-color: #ff4c61;
                    color: white;
                    text-decoration: none;
                    border-radius: 5px;
                    font-weight: bold;
                ">
                    Order Now
                </a>

                <a href="{{ url('/customer/cart/index') }}" style="
                    display: inline-block;
                    padding: 10px 20px;
                    background-color: #6c5ce7;
                    color: white;
                    text-decoration: none;
                    border-radius: 5px;
                    font-weight: bold;
                ">
                    + Add to Cart
                </a>
            </div>
        </div>
    </div>
</body>
</html>
