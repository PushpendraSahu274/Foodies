@extends('user.layouts.master')

@section('page-title')
    My profile
@endsection

@section('user-page-content')
    <div class="container mt-6">
        <div class="row">
            <!-- Profile Card -->
            <div class="col-sm-11 col-md-5 my-5">
                <div class="userProfile bg-level-2 p-2 rounded shadow-lg">
                    <div class="card p-3 bg-level-2" style="width: 100%">

                        <img src="@if($profile->avatar){{ $profile->avatar }}@elseif($profile->profile){{$profile->profile}}@else{{asset('images/review/review-1.jpg')}} @endif"
                            class="card-img-top w-25 h-25 img-fluid rounded-circle mx-auto" alt="Profile Picture"
                            id="profileImage" />
                        <div class="card-body">
                            <h5 class="card-title text-center text-white">{{ $profile->name }}</h5>
                            <h5 class="card-title text-center fs-5 fw-normal opacity-75 text-white">
                                {{ $profile->email }}
                            </h5>
                            <p class="text-center">
                                <a href="#" class="btn p-0 fs-5 px-2 py-1 text-dark bg-white btn-lg shadow-lg">
                                    {{ ucfirst($profile->role) }}
                                </a>
                            </p>
                        </div>
                        <!-- Address Display -->
                        <div class="row address">
                            @foreach ($addresses as $index => $address)
                                <div class="col-sm-12 mt-3">
                                    <div class="bg-brown p-3 rounded text-light">
                                        <!-- Address Header: Title + Default Check -->
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center gap-2">
                                                <strong>Delivery Address-{{ $index + 1 }}:</strong>
                                                @if ($address->is_default)
                                                    <i
                                                        class="fa-solid fa-check bg-success rounded-circle p-1 text-light"></i>
                                                @endif
                                            </div>

                                            <!-- Edit & Delete Icons -->
                                            <div class="d-flex align-items-center gap-2">
                                                <a href="#" class="text-white" data-bs-toggle="modal"
                                                    data-bs-target="#address-modal-{{ $index + 1 }}" title="Edit">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <form action="{{ route('customer.address.destroy') }}" method="POST"
                                                    class="m-0 p-0">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $address->id }}">
                                                    <button type="submit" class="btn btn-sm text-white p-0 border-0"
                                                        title="Delete"
                                                        onclick="return confirm('Are you sure you want to delete this address?')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Address Text -->
                                        <div class="mt-2">
                                            {{ $address->primary_landmark }},
                                            {{ $address->secondary_landmark }},
                                            {{ $address->address }},
                                            {{ $address->city }},
                                            {{ $address->state }},
                                            {{ $address->pincode }},
                                            India
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="text-center mt-4">
                                <button class="btn btn-outline-none bg-white" data-bs-toggle="modal"
                                    data-bs-target="#add-address-modal">
                                    + Add Delivery Address
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update Profile Form -->
            <div class="col-sm-12 col-md-6 my-md-4 smallFont">
                <div class="updateProfile shadow-lg mx-md-1 p-3 rounded">
                    <div class="content">
                        <h5 class="text-center w-full mt-4">Update <span class="text-danger">Profile</span></h5>
                        <form id="customer-profile-update-form" enctype="multipart/form-data">
                            @csrf
                            <div class="body mt-4">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput4" class="form-label text-primary-color">Name</label>
                                    <input type="text" class="form-control" id="profileName" name ="name"
                                        value="{{ $profile->name }}" placeholder="Enter Your Name" required />
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label text-primary-color">Email</label>
                                    <input type="email" class="form-control" id="profileEmail" name="email"
                                        value="{{ $profile->email }}" placeholder="Enter email address" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-primary-color">Mobile number</label>
                                    <input type="number" name="profilePhone" class="form-control smallplace"
                                        value="{{ old('phone', $profile->phone) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="pwd" class="form-label text-primary-color">Password</label>
                                    <input type="text" class="form-control" id="pwd" name="password"
                                        placeholder="Enter new password" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-primary-color">Password</label>
                                    <input type="password" name="password_confirmation" class="form-control smallplace"
                                        placeholder="Confirm New password">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-primary-color">Profile Picture</label>
                                    <input type="file" id="dp" name="photo" class="form-control smallplace">

                                    {{-- Preview Image -- --}}
                                    <img src="{{ $profile->profile ?? null }}" alt="User image" height="70px"
                                        class="d-none" width="70px" id='previewImage'>
                                </div>
                            </div>
                            <div class="m-footer">
                                <button type="reset" class="btn btn-danger">Reset</button>
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <!-- Address Update Modals -->
        @foreach ($addresses as $index => $address)
            <div class="modal fade" id="address-modal-{{ $index + 1 }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('customer.address.update', $address->id) }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Update Address {{ $index + 1 }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-primary-color">Primary Landmark</label>
                                    <input type="text" name="primary_landmark"
                                        value="{{ old('primary_landmark', $address->primary_landmark) }}"
                                        class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-primary-color">Secondary Landmark</label>
                                    <input type="text" name="secondary_landmark"
                                        value="{{ old('secondary_landmark', $address->secondary_landmark) }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-primary-color">City</label>
                                    <input type="text" name="city" value="{{ old('city', $address->city) }}"
                                        class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-primary-color">State</label>
                                    <input type="text" name="state" value="{{ old('state', $address->state) }}"
                                        class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-primary-color">Pincode</label>
                                    <input type="text" name="pincode" value="{{ old('pincode', $address->pincode) }}"
                                        class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-primary-color">Address</label>
                                    <input type="text" name="address" value="{{ old('address', $address->address) }}"
                                        class="form-control" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label text-primary-color">Remark</label>
                                    <input type="text" name="remark" value="{{ old('remark', $address->remark) }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label text-primary-color">Set as Default</label>
                                    <input type="checkbox" name="is_default" value="1"
                                        {{ $address->is_default ? 'checked' : '' }} class="ms-2">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Update Address</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach

        <!-- Add New Address Modal -->
        <div class="modal fade" id="add-address-modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('customer.address.store') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add New Address</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-primary-color">Primary Landmark</label>
                                <input type="text" name="primary_landmark" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-primary-color">Secondary Landmark</label>
                                <input type="text" name="secondary_landmark" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-primary-color">City</label>
                                <input type="text" name="city" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-primary-color">State</label>
                                <input type="text" name="state" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-primary-color">Pincode</label>
                                <input type="text" name="pincode" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-primary-color">Address</label>
                                <input type="text" name="address" class="form-control">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label text-primary-color">Remark</label>
                                <input type="text" name="remark" class="form-control">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label text-primary-color">Phone</label>
                                <input type="phone" name="phone" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label text-primary-color">Set as Default</label>
                                <input type="checkbox" name="is_default" value="1" class="ms-2">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Add Address</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

@section('user-page-script')
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>



    <script>
        function updateProfile(data) {
            $('#profileImage').attr('src', data.profile);
            $('#profileName').text(data.name);
            $('#profileEmail').text(data.email);
            $('#profilePhone').text(data.phone);
            $('#profileDescription').text(data.description);
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#customer-profile-update-form').on('submit', function(e) {
                e.preventDefault(); // prevent default form submission        
                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('customer.profile.update') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                        updateProfile(response.data);
                        $('#previewImage').addClass('d-none');
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Something went wrong.',
                            icon: 'error',
                            confirmButtonText: 'Try Again'
                        });

                    }
                });
            });
        });
    </script>

    <script src="/js/previewImage.js"></script>
    <script>
        previewImage('previewImage', 'dp')
    </script>

    @if (session('message'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: @json(session('message')),
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        </script>
    @endif

    @if ($errors->has('error'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: @json($errors->first('error')),
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        </script>
    @endif
@endsection
