<div class="container py-3">
    <div class="row text-center mb-4">
        <div class="col-12">
            <img src="{{ $customer->profile_path }}" alt="Profile Picture" class="rounded-circle shadow-sm mb-2"
                width="100px" height="100px">
            <h5 class="fw-bold text-danger mb-0">{{ $customer->name }}</h5>
            <small class="text-muted d-block">Customer ID: {{ $customer->id }}</small>
        </div>
    </div>

    <div class="row g-3 px-3">
        <div class="col-md-6">
            <label class="fw-semibold text-primary-color">Email</label>
            <p class="text-dark mb-1 text-break">{{ $customer->email }}</p>
        </div>
        <div class="col-md-6">
            <label class="fw-semibold text-primary-color">Phone</label>
            <p class="text-dark mb-1 text-break">{{ $customer->phone }}</p>
        </div>


        <div class="col-md-6">
            <label class="fw-semibold text-primary-color">Alternate Phone</label>
            <p class="text-dark mb-1">{{ $customer->alternate_phone ?? 'N/A' }}</p>
        </div>
        <div class="col-md-6">
            <label class="fw-semibold text-primary-color">Marital Status</label>
            <p class="text-dark mb-1 text-capitalize">{{ $customer->marital_status ?? 'N/A' }}</p>
        </div>

        <div class="col-md-6">
            <label class="fw-semibold text-primary-color">Date of Birth</label>
            <p class="text-dark mb-1">
                {{ $customer->dob ? \Carbon\Carbon::parse($customer->dob)->format('d M Y') : 'N/A' }}</p>
        </div>
        <div class="col-md-6">
            <label class="fw-semibold text-primary-color">Gender</label>
            <p class="text-dark mb-1">
                @if ($customer->gender === 1)
                    Male
                @elseif($customer->gender === 0)
                    Female
                @else
                    N/A
                @endif
            </p>
        </div>

        <div class="col-md-12">
            <label class="fw-semibold text-primary-color">Description</label>
            <p class="text-dark mb-1">{{ $customer->description ?? 'N/A' }}</p>
        </div>

        <div class="col-md-6">
            <label class="fw-semibold text-primary-color">Joined On</label>
            <p class="text-dark mb-1">{{ $customer->created_at->format('d M Y') }}</p>
        </div>
    </div>
</div>
