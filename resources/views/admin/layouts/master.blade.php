<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>@yield('page-title')</title>
    <!-- fontawesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- bootsrap cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />

    <!-- our own css -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/fuild.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin.css') }}" />
    <link rel="stylesheet" href="{{ asset('adminFluid.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/user.css') }}" />
</head>

<body>
    <div class="container-fluid px-0">
        {{-- @dd($profile->profile) --}}
        <!-- modals -->
        <!-- update modal starts-->
        <!-- Modal -->
        <div class="modal fade" id="admin-profile-update-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Update Admin Details
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="admin-profile-update-form" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput4"
                                            class="form-label text-primary-color">Name</label>
                                        <input type="text" class="form-control" id="exampleFormControlInput4"
                                            name ="name" value="{{ $profile->name }}" placeholder="Enter Your Name"
                                            required />
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label for="email" class="form-label text-primary-color">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ $profile->email }}" placeholder="Enter email address" />
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label for="pwd" class="form-label text-primary-color">Password</label>
                                        <input type="text" class="form-control" id="pwd" name="password"
                                            placeholder="Enter new password" />
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label for="about" class="form-label text-primary-color">About</label>
                                        <input type="text" class="form-control" id="about" name="description"
                                            value="{{ $profile->description }}" placeholder="Enter Your about " />
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label for="Landmark" class="form-label text-primary-color">Profile
                                            Picture</label>
                                        <input type="file" class="form-control" id="dp" accept="image/*"
                                            name="photo" />

                                        {{-- Preview Image -- --}}
                                        <img src="{{ $profile->profile_path }}" alt="User image" height="70px"
                                            width="70px" id='previewImage'>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" id="submit" class="btn btn-success">
                                update Details
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- update modal ends  -->
        <!-- all modals ends -->
        <!-- header section starts -->
        @include('admin.layouts.sidebar')

        <div class="row mt-5 pt-5">
            <div class="col-12 mt-5">
                <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1"
                    id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasScrollingLabel">
                            Admin Details
                        </h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <!-- user profile summary starts-->
                        <div class="row">
                            <div class="col-sm-12 my-2">
                                <div class="userProfile bg-level-2 p-1 rounded shadow-lg">
                                    <div class="card p-3 bg-level-2" style="width: 100%">
                                        <img src="{{ $profile->profile }}"
                                            class="card-img-top w-25 h-25 img-fluid rounded-circle mx-auto"
                                            alt="..." 
                                            id="profileImage"/>
                                        <div class="card-body">
                                            <h5 class="card-title text-center text-white" id="profileName">
                                                {{ $profile ? $profile->name : 'admin-name' }}
                                            </h5>
                                            <h5 class="card-title text-center fs-5 fw-normal opacity-75 text-white" id="profileEmail">
                                                {{ $profile ? $profile->email : 'admin-email' }}
                                            </h5>
                                            <p class="text-center">
                                                <a href="#"
                                                    class="btn p-0 fs-5 px-2 py-1 text-dark bg-white btn-lg shadow-lg"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#admin-profile-update-modal">update profile</a>
                                            </p>
                                        </div>

                                        <div class="row address">
                                            <div class="col-sm-12 mt-3">
                                                <p class="lh-lg-lg">
                                                    <span class="fw-bold bg-brown p-2 rounded">Contact Number</span>
                                                    <br />
                                                    <br />
                                                    <span
                                                        class="text-light" id="profilePhone">{{ $profile ? $profile->phone : 'admin-contact' }}</span>
                                                </p>
                                                <p class="lh-lg-lg">
                                                    <span class="fw-bold bg-brown p-2 rounded">About</span>
                                                    <br />
                                                    <br />
                                                    <span class="text-light" id="profileDescription">
                                                        {{ $profile ? $profile->description : 'description about admin' }}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- user profile summary ends-->
                    </div>
                </div>
            </div>
        </div>
        @yield('admin-page-content')
        @include('admin.layouts.footer')
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <!-- my oun javaScript file -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script> 
    function updateProfile(data){
            $('#profileImage').attr('src', data.profile);
            $('#profileName').text(data.name);
            $('#profileEmail').text(data.email);
            $('#profilePhone').text(data.phone);
            $('#profileDescription').text(data.description);
    }
    </script>

    <script>
        $(document).ready(function() {
            $('#admin-profile-update-form').on('submit', function(e) {
                e.preventDefault(); // prevent default form submission        
                var formData = new FormData(this);

                $.ajax({
                    url: '{{ route('admin.profile.update') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#admin-profile-update-modal').modal('hide');
                        $('#admin-profile-update-form')[0].reset();
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                        updateProfile(response.data);
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
    <script>
        $(document).ready(function() {
            $('#dp').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#previewImage').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>

    @yield('admin-script-content')

</body>

</html>
