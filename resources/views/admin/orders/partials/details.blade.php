<div class="container">
    <!-- Customer Info -->
    <h6 class="text-danger fw-bold mb-3">Customer Information</h6>
    <div class="text-center mb-3">
        <img src="{{$order->customer->profile_path}}"
            alt="Customer Image" class="rounded-circle" width="80" height="80">
    </div>
    <p><strong>Customer ID:</strong> {{ optional($order->customer)->id }}</p>
    <p><strong>Name:</strong> {{ optional($order->customer)->name }}</p>
    <p><strong>Email:</strong> {{ optional($order->customer)->email }}</p>
    <p><strong>Phone:</strong> {{ optional($order->customer)->phone }}</p>
    <p><strong>Order Date:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</p>
    <p><strong>Delivery Address:</strong> {{ $order->address->address ?? 'N/A' }}</p>

    <hr>

    <!-- Order Info -->
    <h6 class="text-danger fw-bold mb-3">Order Information</h6>
    @foreach ($order->items as $item)
        <div class="d-flex align-items-center mb-3 border-bottom pb-2">
            <img src="{{ $item->picture_path }}" alt="Product Image" class="me-3 rounded"
                width="70" height="70">
            <div>
                <p class="mb-1"><strong>Product Name:</strong> {{ $item->meal_name }}</p>
                <p class="mb-1"><strong>Quantity:</strong> {{ $item->quantity }}</p>
                <p class="mb-1"><strong>Price:</strong> ₹{{ $order->total_amount }}</p>
            </div>
        </div>
    @endforeach

    <hr>

    <!-- Order Status Update -->
    <h6 class="text-danger fw-bold mb-2">Update Order Status</h6>
    <form id="updateOrderStatusForm">
        <div class="mb-3">
            <label for="orderStatus" class="form-label">Status</label>
            <select id="orderStatus" class="form-select" name="status"
                @if(in_array($order->status, ['delivered', 'cancelled'])) disabled @endif>
                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <input type="hidden" name="id" value="{{ $order->id }}">
        @if(!in_array($order->status,['delivered','cancelled']))
        <button type="submit" class="btn btn-success w-100">Update Status</button>
        @endif 
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-K+ctZQ+YdBVN2zY2vF+4Utj+R0ElFks45IQRC4b8lFA=" crossorigin="anonymous">
</script>
<script>
    $('#updateOrderStatusForm').on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        $.ajax({
            url: 'order/update/status',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function(response) {
                Swal.fire({
                    title:'Success',
                    text:response.message,
                    icon:'success',
                });

                //hide the modal
            },
            error: function(xhr,status,error) {
                Swal.fire({
                    title:'Error',
                    text:error,
                    icon:'error',
                }); 
            }
        });
    });
</script>
