@extends('user.layouts.master')


@section('page-title')
    Order details
@endsection


@section('user-page-content')
    <div class="container mt-4 text-dark mt-5">
        <a href="{{ route('customer.order.index') }}" class="text-decoration-none text-dark">
                <i class="fas fa-arrow-left"></i>
        </a>
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold">Order #{{ $order->id }}</h5>
            <span class="badge @if($order->status =='cancelled') bg-danger @elseif($order->status =='pending') bg-warning  @elseif($order->status ==='confirmed') bg-info  @else  bg-success @endif  px-3 py-2">{{ ucfirst($order->status) }}</span>
        </div>

        <!-- Shipment and Items -->
        <div class="card p-3 shadow-sm mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div><strong>{{ $order->items_count }} items in Shipment 1</strong></div>
                <span class="text-muted small">Arrived in <span class="text-purple">15 MINS</span></span>
            </div>

            <div class="d-flex flex-wrap gap-3 mt-3">
                @foreach ($order->items as $item)
                    <div class="d-flex align-items-center">
                        <img src="{{ $item->picture_path }}" alt="{{ $item->meal_name }}" class="rounded"
                            style="width: 60px; height: 60px; object-fit: cover;">
                        <div class="ms-2">
                            <div class="fw-semibold">{{ $item->meal_name }}</div>
                            <div class="small text-muted">{{ $item->quantity }} unit</div>
                            <div class="fw-bold">₹{{ $item->price }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Bill Summary -->
        <div class="card p-3 shadow-sm mb-4">
            <h6 class="fw-bold mb-3">Bill Summary</h6>
            <div class="d-flex justify-content-between">
                <span>Item Total</span>
                <span>₹{{ $order->total_amount }}</span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Delivery Fee</span>
                <span>₹0</span>
            </div>
            <div class="border-top mt-2 pt-2 d-flex justify-content-between fw-bold">
                <span>Total</span>
                <span>₹{{ $order->total_amount }}</span>
            </div>
        </div>

        <!-- Receiver and Address -->
        <div class="card p-3 shadow-sm mb-4">
            <h6 class="fw-bold mb-3">Receiver Details</h6>
            <div class="mb-2">
                <strong>{{ $order->receiver_details['name'] }}</strong><br>
                <span class="text-muted">{{ $order->receiver_details['email'] }}</span>
            </div>
            <div class="small">
                <div>{{ $order->address->primary_landmark }}, {{ $order->address->secondry_landmark }}</div>
                <div>{{ $order->address->address }}</div>
                <div>{{ $order->address->city }}, {{ $order->address->state }} - {{ $order->address->pincode }}</div>
                <div>Phone: {{ $order->address->phone }}</div>
                @if ($order->address->remark)
                    <div>Remark: {{ $order->address->remark }}</div>
                @endif
            </div>
        </div>

        <!-- Timestamps -->
        <div class="card p-3 shadow-sm mb-4">
            <h6 class="fw-bold mb-3">Order Timeline</h6>
            <div class="small">
                <div><strong>Placed:</strong> {{ $order->placed_at }}</div>
                @if ($order->confirmed_at)
                    <div><strong>Confirmed:</strong> {{ $order->confirmed_at }}</div>
                @endif
                @if ($order->delivered_at)
                    <div><strong>Delivered:</strong> {{ $order->delivered_at }}</div>
                @endif
                @if ($order->cancelled_at)
                    <div><strong>Cancelled:</strong> {{ $order->cancelled_at }}</div>
                @endif
            </div>
        </div>

        <!-- Download invoice -->
        {{-- <div class="text-end">
            <a href="#" class="btn btn-light border text-purple">Download Invoice</a>
        </div> --}}
    </div>
@endsection


@section('user-page-script')

@endsection
