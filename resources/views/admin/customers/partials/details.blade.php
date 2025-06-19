<div class="container">
    <div class="row text-center mb-4">
        <div class="col-12">
            <img src="{{ $customer->profile_path ? asset('storage/' . $customer->profile_path) : asset('images/default-profile.png') }}"
                 alt="Profile Picture" class="rounded-circle shadow" width="120" height="120">
            <h5 class="mt-3 text-danger fw-bold">{{ $customer->name }}</h5>
            <small class="text-muted">Customer ID: {{ $customer->id }}</small>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <label class="fw-bold text-primary-color">Email</label>
            <p class="text-dark">{{ $customer->email }}</p>
        </div>
        <div class="col-md-6">
            <label class="fw-bold text-primary-color">Phone</label>
            <p class="text-dark">{{ $customer->phone }}</p>
        </div>
        <div class="col-md-6">
            <label class="fw-bold text-primary-color">Alternate Phone</label>
            <p class="text-dark">{{ $customer->alternate_phone ?? 'N/A' }}</p>
        </div>
        <div class="col-md-6">
            <label class="fw-bold text-primary-color">Marital Status</label>
            <p class="text-dark text-capitalize">{{ $customer->marital_status ?? 'N/A' }}</p>
        </div>
        <div class="col-md-6">
            <label class="fw-bold text-primary-color">Date of Birth</label>
            <p class="text-dark">{{ $customer->dob ? \Carbon\Carbon::parse($customer->dob)->format('d M Y') : 'N/A' }}</p>
        </div>
        <div class="col-md-6">
            <label class="fw-bold text-primary-color">Gender</label>
            <p class="text-dark">
                @if($customer->gender === 1)
                    Male
                @elseif($customer->gender === 0)
                    Female
                @else
                    N/A
                @endif
            </p>
        </div>
        <div class="col-md-12">
            <label class="fw-bold text-primary-color">Description</label>
            <p class="text-dark">{{ $customer->description ?? 'N/A' }}</p>
        </div>
        <div class="col-md-6">
            <label class="fw-bold text-primary-color">Joined On</label>
            <p class="text-dark">{{ $customer->created_at->format('d M Y') }}</p>
        </div>
    </div>
</div>
