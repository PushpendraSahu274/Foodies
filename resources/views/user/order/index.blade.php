@extends('user.layouts.master')

@section('page-title')
    My Order
@endsection


@section('user-page-content')
<div class="container py-4">
    <h4 class="mb-4 fw-bold">Orders</h4>

    @foreach($orders as $order)
    <div class="bg-white rounded shadow-sm p-3 mb-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mt-5">
        <div class="d-flex align-items-center flex-wrap gap-2 mb-3 mb-md-0">
            {{-- Thumbnails --}}
            @foreach($order['order_items']->take(5) as $item)
                <img src="{{ $item['picture_path'] ?? asset('images/default.jpg') }}" alt="Meal Image" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
            @endforeach
            @if(count($order['order_items']) > 5)
                <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    +{{ count($order['order_items']) - 5 }}
                </div>
            @endif
        </div>

        {{-- Order Info --}}
        <div class="flex-grow-1 ps-md-3">
            <div class="fw-bold mb-1">
                Order {{ ucfirst($order['status']) }}
                @if($order['status'] === 'delivered')
                    <i class="fa-solid fa-circle-check text-success ms-1"></i>
                @elseif($order['status'] === 'pending')
                    <i class="fa-solid fa-clock text-warning ms-1"></i>
                @endif
            </div>
            <div class="text-muted small">Placed at {{ $order['placed_at'] ?? 'N/A' }}</div>

            @if($order['status'] === 'delivered')
            <div class="mt-2">
                <span class="text-muted small">Your delivery experience rating:</span>
                <span class="text-warning">
                    @for ($i = 0; $i < 5; $i++)
                        <i class="fa-solid fa-star"></i>
                    @endfor
                </span>
            </div>
            @endif
        </div>

        {{-- Price --}}
        <div class="fw-bold text-end ms-md-auto mt-2 mt-md-0">
            ₹{{ number_format($order['total_amount'], 2) }} <i class="fa-solid fa-chevron-right ms-2"></i>
        </div>
    </div>
    @endforeach
</div>
@endsection



@section('user-page-script')
@endsection
