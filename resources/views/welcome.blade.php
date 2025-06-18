<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Foodies - Online Delivery App</title>
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />
    <!-- fontawesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- bootsrap cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />

    <!-- our own css -->
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/fuild.css" />
</head>

<body>
    <!-- checking on new laptop -->
    <!-- checking 2nd time on new laptop -->
    <!-- modal for credentails starts-->
    <!-- Modal -->
    <div class="modal fade" id="credentialsModal" tabindex="-1" aria-labelledby="credentialsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header bg-primary-color text-white">
                    <h5 class="modal-title" id="credentialsModalLabel">
                        Credentials for explore website
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Admin Email:</strong> <code>admin@gmail.com</code></p>
                    <p><strong>Admin Password:</strong> <code>123</code></p>

                    <p>
                        <strong>User Email:</strong> <code>erajmishra000@gmail.com</code>
                    </p>
                    <p><strong>User Password:</strong> <code>123</code></p>

                    <p class="text-muted">Both can login using same login Form</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">
                        Let's Go!
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- modal for credentails ends-->
    <div class="container-fluid mx-0 px-0">
        <!-- code of body starts -->
        <!-- <h1>Jai Bajrangbali</h1> -->
        <!-- header section starts -->
        <header class="" id="header">
            <nav class="navbar navbar-expand-lg navbar-light bg-white">
                <div class="container">
                    <a class="navbar-brand" href="#"><img src="images/logo.png" alt="" /></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <!-- here i added ms-auto class to do space between of the items -->
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link fw-bold" aria-current="page" href="#">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-bold" href="#aboutUs">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-bold" href="#ExploreFood">Explore Foodes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-bold" href="#reviews">Reviews</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-bold" href="#FAQS">FAQ</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn phoneBtn fw-bold" href="#" tabindex="-1"><i
                                        class="fa-solid fa-phone me-2 fa-shake"></i>+91
                                    8899776600</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <!-- header section starts -->
        <!-- hero section starts -->
        <section class="hero" id="hero">
            <div class="absheroimg">
                <img src="images/img/heroGif.gif" alt="" />
            </div>
            <div class="container-fluid">
                <div class="container">
                    <div class="row d-flex d-md-block flex-column align-items-center">
                        <div class="col-10 col-md-5 col-lg-6 h-screen left-hero">
                            <div class="row">
                                <div class="col-sm-12">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <h1 class="fw-bolder fs-1 fs-lg-1 p-0">
                                        Good food choices are good investments.
                                    </h1>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 mt-3 opacity-1">
                                    Discover mouth-watering dishes from your favorite
                                    restaurants, and get them delivered fresh, fast, and full of
                                    flavor to your doorstep.
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 d-flex gap-3 mt-2">
                                    <a class="btn phoneBtn heroBtn fw-bold px-5 d-flex align-items-center gap-2"
                                        data-bs-toggle="modal" data-bs-target="#loginUser" href="#"
                                        tabindex="-1">Login Now
                                        <i class="fa-solid fa-right-to-bracket fs-4"></i></a>
                                </div>
                                <div class="col-sm-6 mt-2">
                                    <a class="btn phoneBtn heroBtn fw-bold px-5 d-flex align-items-center gap-1"
                                        href="#" tabindex="-1" data-bs-toggle="modal"
                                        data-bs-target="#registerUser">Register Now
                                        <i class="fa-solid fa-circle-user pl-2 fs-4"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 display-none display-md-block display-lg-block col-md-6 col-lg-6"></div>
                    </div>
                </div>
            </div>
            <div class="container-fluid numbersCountContainer">
                <div class="row numbersCount">
                    <div class="col-12 col-md-6 col-lg-3 text-center text-white py-3">
                        <div>
                            <span class="">1287+</span><br />
                            <span class="numSave">SAVINGS</span>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 py-3 text-center text-white">
                        <div>
                            <span class="">5686+</span><br />
                            <span class="numSave">PHOTOS</span>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 py-3 text-center text-white">
                        <div>
                            <span class="">1440+</span><br />
                            <span class="numSave">ROCKETS</span>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 py-3 text-center text-white">
                        <div>
                            <span class="">7110+</span><br />
                            <span class="numSave">GLOBES</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Button trigger modal -->

        <!-- Modal user login-->
        <div class="modal fade" id="loginUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog .modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <h5 class="modal-title login-heading-modal text-center w-full" id="staticBackdropLabel">
                            User Login
                        </h5>
                        <!-- <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button> -->
                    </div>
                    <form action="{{ route('login') }}" id="modal-user-login-form" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="LoginEmail" class="form-label text-primary-color">Email</label>
                                <input type="email" class="form-control" id="LoginEmail"
                                    placeholder="Enter your email" name="email" required />
                            </div>
                            <div class="mb-3">
                                <label for="LoginPwd" class="form-label text-primary-color">Password</label>
                                <input type="password" class="form-control" id="LoginPwd"
                                    placeholder="Enter your Password" name="password" required />
                            </div>
                            <div class="mb-3 me-auto text-end">
                                <span>forget password?
                                    <a href="#" data-bs-toggle="modal"
                                        data-bs-target="#ForgetPwdUser">reset</a></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-danger" id="modal-login-button">
                                Login
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal user forget password -->
        <div class="modal fade" id="ForgetPwdUser" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog .modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <h5 class="modal-title login-heading-modal text-center w-full" id="staticBackdropLabel">
                            Forget Password
                        </h5>
                        <!-- <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button> -->
                    </div>
                    <form action="" id="modal-user-login-form">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="LoginEmail" class="form-label text-primary-color">Email</label>
                                <input type="email" class="form-control" id="LoginEmail"
                                    placeholder="Enter your email" required />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-danger" id="modal-login-button">
                                Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal user Register-->
        <div class="modal fade" id="registerUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog .modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <h5 class="modal-title login-heading-modal text-center w-full" id="staticBackdropLabel">
                            User Registration
                        </h5>
                        <!-- <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button> -->
                    </div>
                    <form action="{{ route('register') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="exampleFormControlInput0" class="form-label text-primary-color">Full
                                    Name</label>
                                <input type="text" class="form-control" id="exampleFormControlInput0"
                                    placeholder="Enter your full name" name="name" required />
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput5"
                                    class="form-label text-primary-color">Email</label>
                                <input type="email" class="form-control" id="exampleFormControlInput5"
                                    placeholder="Enter your email" name="email" required />
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput6" class="form-label text-primary-color">Mobile
                                    number</label>
                                <input type="number" class="form-control" id="exampleFormControlInput6"
                                    placeholder="Enter your email" name="phone" required />
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput3"
                                    class="form-label text-primary-color">Password</label>
                                <input type="password" class="form-control" id="exampleFormControlInput3"
                                    placeholder="Enter your Password" name="password" required />
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput4" class="form-label text-primary-color">Confirm
                                    Password</label>
                                <input type="password" class="form-control" id="exampleFormControlInput4"
                                    placeholder="Re-enter your Password" name="confirmation_password" required />
                            </div>
                            <div class="mb-3">
                                <label for="profile-picture" class="form-label text-primary-color">Profile
                                    Picture</label>
                                <input type="file" class="form-control" id="profile-picture" name="profile_path"
                                   />
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label text-primary-color">Address</label>
                                <input type="text" class="form-control" id="address"
                                    placeholder="Enter address" name="address"/>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-danger">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- hero section ends -->
        <!--about us starts  -->
        <section id="aboutUs">
            <div class="container py-4">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6 p-2">
                        <img src="images/img/img-1.png" alt="" width="100%" class="w-fit rounded" />
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 d-flex flex-column justify-content-center px-4">
                        <div class="row">
                            <h3 class="p-0">
                                We Pride Ourselves On Making Real Food From The Best
                                Ingredients
                            </h3>
                        </div>
                        <div class="row mt-1 mt-lg-3 opacity-1">
                            At our core, we believe great food starts with great
                            ingredients. That’s why every dish we prepare is crafted with
                            care, using only the freshest, highest-quality ingredients to
                            deliver authentic flavor in every bite.
                        </div>
                        <div class="row d-flex gap-3 mt-2">
                            <a class="btn phoneBtn w-auto fw-bold" data-bs-toggle="modal" data-bs-target="#loginUser"
                                href="#" tabindex="-1">Learn More
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-5 col-lg-5 px-4 pt-lg-5 mb-4 mb-lg-0">
                        <div class="row pt-lg-5">
                            <h3 class="p-0 fs-2">
                                Crafted With Care Using Only the Finest Natural Ingredients
                            </h3>
                        </div>
                        <div class="row mt-3 opacity-75">
                            Every product is made by skilled hands using traditional
                            methods. We believe in quality, sustainability, and taste that
                            speaks for itself. Experience the goodness in every bite and
                            feel the difference.
                        </div>
                        <div class="row mt-2">
                            <span class="p-0">
                                <i class="fa fa-leaf me-2 text-success"></i>100% Organic and
                                Eco-Friendly
                            </span>
                        </div>
                        <div class="row">
                            <span class="p-0">
                                <i class="fa fa-heart me-2 text-danger"></i>Handcrafted With
                                Love and Passion
                            </span>
                        </div>
                        <div class="row">
                            <span class="p-0">
                                <i class="fa fa-star me-2 text-warning"></i>Trusted by
                                Thousands of Happy Customers
                            </span>
                        </div>
                        <div class="row d-flex gap-3 mt-4">
                            <a class="btn phoneBtn w-auto fw-bold" data-bs-toggle="modal" data-bs-target="#loginUser"
                                href="#" tabindex="-1">
                                Learn More
                            </a>
                        </div>
                    </div>

                    <div class="col-12 col-md-7 col-lg-7 mt-lg-0">
                        <div class="row p-0">
                            <img src="images/img/img-2.png" alt="" width="100%"
                                class="w-fit rounded mt-0" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fuild OrderNowConainer">
                <div class="row d-flex justify-content-center text-center p-2 px-3">
                    <div class="col-12 col-md-10 col-lg-8">
                        <h1 class="">
                            When A Man's Stomach is Full It Makes No Difference Whether He
                            is Rich Or Poor.
                        </h1>
                        <p>
                            True satisfaction comes from a hearty meal, not a heavy wallet.
                            We serve food that fills not just the stomach, but also the soul
                            — because everyone deserves the joy of good food, no matter who
                            they are.
                        </p>
                        <a class="btn phoneBtn heroBtn fw-bold px-5" href="#" tabindex="-1"
                            data-bs-toggle="modal" data-bs-target="#loginUser">Order Now <i
                                class="fa-solid fa-cart-shopping"></i></a>
                    </div>
                </div>
            </div>
        </section>
        <!--about us ends  -->
        <!-- Explore foods starts -->
        <section id="ExploreFood">
            <div class="container">
                <div class="row d-flex flex-column align-items-center">
                    <div class="col-11 col-md-9 col-lg-8 text-center py-5">
                        <h1>Explore Our Foods</h1>
                        <p>
                            Dive into a world of flavors with our wide range of delicious
                            dishes. From spicy street-style snacks to hearty meals, there's
                            something to satisfy every craving and every mood.
                        </p>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="card" style="width: 100%">
                                    <img src="images/img/img-3.jpg" class="card-img-top rounded" alt="..." />
                                    <div class="card-body px-0">
                                        <h5 class="card-title">Rainbow Vegetable Sandwich</h5>
                                        <p class="card-text">
                                            <span>Time: 15 - 20 Minuts | </span><span>serves: 1</span>
                                        </p>

                                        <p class="card-text">
                                            <span class="price">$10.50 </span><span class="beforeDiscount">
                                                $11.70</span>
                                        </p>
                                        <hr />
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#loginUser"
                                            class="btn CardBtn">Order Now</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="card" style="width: 100%">
                                    <img src="images/img/img-3.jpg" class="card-img-top rounded" alt="..." />
                                    <div class="card-body px-0">
                                        <h5 class="card-title">Rainbow Vegetable Sandwich</h5>
                                        <p class="card-text">
                                            <span>Time: 15 - 20 Minuts | </span><span>serves: 1</span>
                                        </p>

                                        <p class="card-text">
                                            <span class="price">$10.50 </span><span class="beforeDiscount">
                                                $11.70</span>
                                        </p>
                                        <hr />
                                        <a href="#" class="btn CardBtn" data-bs-toggle="modal"
                                            data-bs-target="#loginUser">Order Now</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="card" style="width: 100%">
                                    <img src="images/img/img-3.jpg" class="card-img-top rounded" alt="..." />
                                    <div class="card-body px-0">
                                        <h5 class="card-title">Rainbow Vegetable Sandwich</h5>
                                        <p class="card-text">
                                            <span>Time: 15 - 20 Minuts | </span><span>serves: 1</span>
                                        </p>

                                        <p class="card-text">
                                            <span class="price">$10.50 </span><span class="beforeDiscount">
                                                $11.70</span>
                                        </p>
                                        <hr />
                                        <a href="#" class="btn CardBtn" data-bs-toggle="modal"
                                            data-bs-target="#loginUser">Order Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Explore foods ends -->
        <!-- reviews start -->
        <section id="reviews" class="py-5 my-5">
            <div class="container-fluid h-full">
                <div class="row">
                    <div class="col-12">
                        <h1 class="text-center text-white py-3 fs-3">Reviews</h1>
                        <div class="row d-flex justify-content-center">
                            <div class="col-10 col-md-8">
                                <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-indicators">
                                        <button type="button" data-bs-target="#carouselExampleCaptions"
                                            data-bs-slide-to="0" class="active" aria-current="true"
                                            aria-label="Slide 1"></button>
                                        <button type="button" data-bs-target="#carouselExampleCaptions"
                                            data-bs-slide-to="1" aria-label="Slide 2"></button>
                                        <button type="button" data-bs-target="#carouselExampleCaptions"
                                            data-bs-slide-to="2" aria-label="Slide 3"></button>
                                    </div>
                                    <div class="carousel-inner">
                                        <div class="carousel-item bg-white active rounded">
                                            <img src="images/review/review-2.jpg" class="d-block reviewer-img"
                                                alt="reviewer image" />
                                            <br />
                                            <div class="carousel-caption d-block h-fit d-md-block">
                                                <p class="text-dark">
                                                    "Absolutely loved the food! Everything was fresh,
                                                    tasty, and delivered on time. Will definitely order
                                                    again!"
                                                </p>
                                                <h5 class="">Elisha</h5>
                                            </div>
                                        </div>
                                        <div class="carousel-item bg-white active rounded">
                                            <img src="images/review/review-2.jpg" class="d-block reviewer-img"
                                                alt="reviewer image" />
                                            <br />
                                            <div class="carousel-caption d-block d-md-block">
                                                <p class="text-dark">
                                                    "Great variety and flavors. The biryani was spot on,
                                                    and the portion size was perfect. Keep it up!"
                                                </p>
                                                <h5 class="">Elisha</h5>
                                            </div>
                                        </div>
                                        <div class="carousel-item bg-white active rounded">
                                            <img src="images/review/review-1.jpg" class="d-block reviewer-img"
                                                alt="reviewer image" />
                                            <br />
                                            <div class="carousel-caption d-block d-md-block">
                                                <p class="text-dark">
                                                    "Best food delivery experience so far! Easy to
                                                    order, fast delivery, and the quality was
                                                    top-notch."
                                                </p>
                                                <h5 class="">Joy</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button"
                                        data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                        data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- reviews end -->
        <!-- FAQS start -->
        <section id="FAQS">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <h1 class="text-center mb-5">Frequently Asked Questions</h1>
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button faqHead" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true"
                                        aria-controls="collapseOne">
                                        What are your delivery timings?
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show"
                                    aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <strong>We deliver from 9 AM to 9 PM, seven days a
                                            week.</strong>
                                        Orders placed after 8 PM are scheduled for the next day.
                                        You can also choose your preferred delivery slot during
                                        checkout to ensure timely delivery. We offer real-time
                                        tracking for all orders once they are dispatched.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed faqHead" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                                        aria-controls="collapseTwo">
                                        Do you offer same-day delivery?
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse"
                                    aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <strong>Yes, same-day delivery is available in select
                                            locations.</strong>
                                        To qualify, your order must be placed before 4 PM on the
                                        same day. This service is available for a limited range of
                                        products and is subject to local availability. Additional
                                        charges may apply depending on the delivery distance and
                                        urgency.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed faqHead" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                        aria-expanded="false" aria-controls="collapseThree">
                                        What is your return and refund policy?
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse"
                                    aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <strong>You can return eligible items within 7 days of
                                            receiving them.</strong>
                                        Products must be in their original packaging and unused
                                        condition. Perishable items, personalized products, or
                                        opened packages are not returnable unless there's a defect
                                        or damage during transit. Refunds are processed within 3–5
                                        business days after inspection and confirmation of the
                                        returned item.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFour">
                                    <button class="accordion-button collapsed faqHead" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                        aria-expanded="false" aria-controls="collapseFour">
                                        How can I track my order?
                                    </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse"
                                    aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <strong>You can track your order in real-time through your
                                            account dashboard.</strong>
                                        Once your order is dispatched, you will receive an SMS and
                                        email with a tracking link. You can also go to the "My
                                        Orders" section on our website to view the latest status
                                        and expected delivery time.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFive">
                                    <button class="accordion-button collapsed faqHead" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFive"
                                        aria-expanded="false" aria-controls="collapseFive">
                                        Do you provide customer support?
                                    </button>
                                </h2>
                                <div id="collapseFive" class="accordion-collapse collapse"
                                    aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <strong>Yes, we provide 24/7 customer support for all your
                                            queries and issues.</strong>
                                        You can reach us through live chat, email, or our
                                        toll-free customer support number. Our support team is
                                        trained to assist you with orders, refunds, technical
                                        issues, and general inquiries.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-12 col-md-8 fs-3 text-white text-center">
                        Baked Fresh Daily By Bakers With Possible.
                    </div>
                    <div class="col-12 col-md-2 text-center">
                        <a href="" data-bs-toggle="modal" data-bs-target="#loginUser"
                            class="btn btn-outline-danger px-5 rounded-0 faqs-btn">Learn More</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- FAQS ends -->
        <!-- newsleter starts -->
        <section id="newsLetter mb-5">
            <div class="container">
                <div class="row d-flex justify-content-center mt-5">
                    <div class="col-12 col-md-8 text-center newsleterHeading">
                        <h2 class="fs-4 fs-md-2 fs-lg-1">
                            Hurry Up! Subscribe Our Newsletter And Get 25% Off
                        </h2>
                    </div>
                    <div class="col-8">
                        <p class="p-0 m-0 text-center">
                            Limited time offer for this month . No credit card required
                        </p>
                    </div>
                    <div class="col-12 col-md-8 d-flex justify-content-between mt-5">
                        <input type="text" class="newsleterInput" placeholder="Email Address here" />
                        <button class="btn btn-outline-danger newsleterInputBtn rounded-0" data-bs-toggle="modal"
                            data-bs-target="#loginUser">
                            Subscribe
                        </button>
                    </div>
                </div>
            </div>
        </section>
        <!-- newsletter ends -->
        <!-- footer starts -->
        <footer class="px-5 pt-5">
            <div class="container d-flex flex-column align-items-center">
                <div class="col-12 col-mg-10 col-lg-8 d-flex justify-content-evenly flex-wrap">
                    <span class="text-white fw-bold opacity-75">Register</span>
                    <span class="text-white fw-bold opacity-75">Forum</span>
                    <span class="text-white fw-bold opacity-75">Affilliate</span>
                    <span class="text-white fw-bold opacity-75">FAQ</span>
                </div>
                <div class="col-12 col-mg-10 col-lg-8 d-flex justify-content-evenly my-3 flex-wrap">
                    <a href="#" class="text-white fs-2"><i class="fa-brands fa-facebook"></i></a>
                    <a href="https://x.com/rajmishra_5" class="text-white fs-2" target="_blank"><i
                            class="fa-brands fa-square-x-twitter"></i></a>
                    <a href="#" class="text-white fs-2"><i class="fa-brands fa-youtube"></i></a>
                    <a href="https://www.linkedin.com/in/raj-mishra-187183258/" target="_blank"
                        class="text-white fs-2"><i class="fa-brands fa-linkedin"></i></a>
                    <a href="https://www.instagram.com/rajmishra_5/" target="_blank" class="text-white fs-2"><i
                            class="fa-brands fa-square-instagram"></i></a>
                </div>
                <div
                    class="col-12 col-mg-10 col-lg-8 d-flex flex-column align-items-center justify-content-center mt-5">
                    <p class="text-white opacity-75 pb-0 mb-0">
                        2025. Foodies.All rights reserved
                    </p>
                    <p class="text-white opacity-50">Developed by Raj Mishra</p>
                </div>
            </div>
        </footer>
        <!-- footer ends -->
        <!-- faqbanner -->
        <!-- code of body ends -->
        <!-- bootsrap javaScript cdn  -->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <!-- my oun javaScript file -->
    {{-- <script src="js/app.js"></script> --}}
</body>

</html>
