{{-- <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>User Dashboard</title>
    <!-- fontawesome cdn -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
      integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <!-- bootsrap cdn -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />

    <!-- our own css -->
    <link rel="stylesheet" href="../../css/style.css" />
    <link rel="stylesheet" href="../../css/fuild.css" />
    <link rel="stylesheet" href="user.css" />
    <link rel="stylesheet" href="userFluid.css" />
  </head>
  <body>
    <div class="container-fluid">
      <!-- header section starts -->
      <header class="" id="header">
        <nav class="navbar navbar-expand-lg navbar-light bg-white">
          <div class="container">
            <a class="navbar-brand" href="../../index.html"
              ><img src="../../images/logo.png" alt=""
            /></a>
            <button
              class="navbar-toggler"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#navbarNav"
              aria-controls="navbarNav"
              aria-expanded="false"
              aria-label="Toggle navigation"
            >
              <span class="navbar-toggler-icon text-primary-color"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <!-- here i added ms-auto class to do space between of the items -->
              <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                  <a
                    class="nav-link fw-bold active"
                    aria-current="page"
                    href="#"
                    >All Products</a
                  >
                </li>

                <li class="nav-item">
                  <a class="nav-link fw-bold" href="MyCart.html">My Cart</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link fw-bold" href="MyOrders.html">My Orders</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link fw-bold" href="userProfile.html"
                    >Profile</a
                  >
                </li>
                <li class="nav-item">
                  <form action="{{route("logout")}}" method="post">
                    @csrf
                    <button type="submit" class="btn phoneBtn fw-bold">Logout</button>
                  </form>
                </li>
              </ul>
            </div>
          </div>
        </nav>
      </header>
      <!-- header section starts -->
      <!--all products start-->
      <section id="allProducts">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <h1 class="fs-5 pt-1">All Products</h1>

              <!-- filter feature start -->
              <form id="filterForm">
                <section class="navbar navbar-expand-lg navbar-white bg-white">
                  <div class="p-0 container-fluid">
                    <h4 class="opacity-75 fw-normal filter-heading">filters</h4>
                    <button
                      class="p-0 navbar-toggler"
                      type="button"
                      data-bs-toggle="collapse"
                      data-bs-target="#navbarSupportedContent"
                      aria-controls="navbarSupportedContent"
                      aria-expanded="false"
                      aria-label="Toggle navigation"
                    >
                      <!-- <span class="navbar-toggler-icon"></span> -->
                      <i
                        class="fa-solid fa-sliders fs-5 me-2 text-primary-color"
                      ></i>
                    </button>
                    <div
                      class="collapse navbar-collapse"
                      id="navbarSupportedContent"
                    >
                      <div
                        class="navbar-nav w-full ms-auto mb-2 mb-lg-0 d-flex justify-content-between"
                      >
                        <div
                          class="nav-item col-12 col-6 col-md-3 col-lg-3 filters mx-0 mx-lg-1"
                        >
                          <select
                            class="form-select form-select-sm"
                            aria-label=".form-select-sm "
                            name="price"
                          >
                            <option selected value="0">Filter by price</option>
                            <option value="100">upto &#8377;100</option>
                            <option value="150">upto &#8377;150</option>
                            <option value="200">upto &#8377;200</option>
                            <option value="250">upto &#8377;250</option>
                            <option value="300">upto &#8377;300</option>
                            <option value="350">upto &#8377;350</option>
                            <option value="400">upto &#8377;400</option>
                            <option value="450">upto &#8377;450</option>
                          </select>
                        </div>
                        <div
                          class="nav-item col-12 col-6 col-md-3 col-lg-3 filters mx-0 mx-lg-1 my-1 my-md-0"
                        >
                          <select
                            class="form-select form-select-sm"
                            aria-label=".form-select-sm example"
                            name="category"
                          >
                            <option selected value="">Filter by</option>
                            <option value="Veg">Veg</option>
                            <option value="Non-Veg">Non-Veg</option>
                          </select>
                        </div>
                        <div
                          class="nav-item col-12 col-6 col-md-3 col-lg-3 filters mx-0 mx-lg-1 my-1 my-md-0"
                        >
                          <select
                            class="form-select form-select-sm"
                            aria-label=".form-select-sm example"
                            name="in_stock"
                          >
                            <option selected value="">Filter by Stock</option>
                            <option value="in_stock">In Stock</option>
                            <option value="out_stock">Up Comming</option>
                          </select>
                        </div>

                        <div
                          class="nav-item col-12 col-6 col-md-3 col-lg-3 filters mx-0 mx-lg-1 my-1 my-md-0 d-flex align-items-center"
                        >
                          <!-- <select
                            class="form-select form-select-sm"
                            aria-label=".form-select-sm example"
                          >
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                          </select> -->
                          <button
                            type="submit"
                            class="btn fiter-submit-btn bg-primary-color fw-bold p-1 px-2"
                          >
                            Apply
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </section>
              </form>
              <!-- filter feacher ends -->
              <!-- product-card-container starts -->
              <div
                class="p-0 row product-card-container d-flex justify-content-around gap-1 py-2"
              >
                <div class="card product-card col-12 col-md-5 col-lg-3 p-0">
                  <!-- <div class="ribbon red d-flex justify-content-between">
                    <div class="ribbon-content">
                      <span>Popular</span>
                      <div class="ri-container w-full">
                        <div class="ri-up">r</div>
                        <div class="ri-down">i</div>
                      </div>
                    </div>
                  </div> -->
                  <img
                    class="card-img-top"
                    src="../../images/userDashboard/burger1.jpg"
                    alt="Card image cap"
                  />

                  <div class="card-body pb-0">
                    <h5 class="Product-title">Classic Cheese Burger</h5>
                    <p class="product-desc p-0 m-0">
                      Juicy beef patty with fresh lettuce & tomato.
                    </p>
                    <p class="product-cat p-0 m-0">
                      <i class="fa-solid fa-seedling me-1 text-success"></i>veg
                      <i class="fa-solid fa-tags text-primary-color ms-2"></i>
                      Bestseller
                    </p>
                    <p class="product-cat text-dark fw-bold p-0 m-0">
                      <i
                        class="fa-solid fa-warehouse me-1 text-primary-color"
                      ></i
                      >Instock
                    </p>
                    <p class="product-price-details">
                      <span
                        ><i
                          class="fa-solid fa-indian-rupee-sign text-warning"
                        ></i>
                        Price :
                      </span>
                      <span class=""> &#8377; 165/- </span>
                      <span
                        class="text-decoration-line-through opacity-75 ms-2"
                      >
                        &#8377; 230
                      </span>
                      <span class="text-success"> 50% off</span>
                    </p>
                  </div>
                  <button class="add2cartbtn">
                    <i class="fa-solid fa-cart-plus mx-2"></i>add to cart
                  </button>
                </div>
              </div>
              <!-- product-card-container ends -->
            </div>
          </div>
        </div>
      </section>
      <!--all products ends-->
    </div>
    <!-- footer starts -->
    <footer class="p-5">
      <div class="container d-flex flex-column align-items-center">
        <div
          class="col-12 col-mg-10 col-lg-8 d-flex justify-content-evenly flex-wrap"
        >
          <span class="text-white fw-bold opacity-75">Register</span>
          <span class="text-white fw-bold opacity-75">Forum</span>
          <span class="text-white fw-bold opacity-75">Affilliate</span>
          <span class="text-white fw-bold opacity-75">FAQ</span>
        </div>
        <div
          class="col-12 col-mg-10 col-lg-8 d-flex justify-content-evenly my-3 flex-wrap"
        >
          <a href="#" class="text-white fs-2"
            ><i class="fa-brands fa-facebook"></i
          ></a>
          <a href="#" class="text-white fs-2"
            ><i class="fa-brands fa-square-x-twitter"></i
          ></a>
          <a href="#" class="text-white fs-2"
            ><i class="fa-brands fa-youtube"></i
          ></a>
          <a href="#" class="text-white fs-2"
            ><i class="fa-brands fa-linkedin"></i
          ></a>
          <a href="#" class="text-white fs-2"
            ><i class="fa-brands fa-square-instagram"></i
          ></a>
        </div>
        <div
          class="col-12 col-mg-10 col-lg-8 d-flex flex-column align-items-center justify-content-center mt-5"
        >
          <p class="text-white fw-bold opacity-75">
            2025. Foodies.All rights reserved
          </p>
          <p class="text-white fw-bold opacity-50">developed by Raj Mishra</p>
        </div>
      </div>
    </footer>
    <!-- footer ends -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
    <!-- my oun javaScript file -->
    <script src="../../js/app.js"></script>
    <script src="user.js"></script>
  </body>
</html> --}}

@extends('user.layouts.master')

@section('page-content')

<!--all products start-->
<section id="allProducts">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h1 class="fs-5 pt-1">All Products</h1>

        <!-- filter feature start -->
        <form id="filterForm">
          <section class="navbar navbar-expand-lg navbar-white bg-white">
            <div class="p-0 container-fluid">
              <h4 class="opacity-75 fw-normal filter-heading">filters</h4>
              <button
                class="p-0 navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
              >
                <!-- <span class="navbar-toggler-icon"></span> -->
                <i
                  class="fa-solid fa-sliders fs-5 me-2 text-primary-color"
                ></i>
              </button>
              <div
                class="collapse navbar-collapse"
                id="navbarSupportedContent"
              >
                <div
                  class="navbar-nav w-full ms-auto mb-2 mb-lg-0 d-flex justify-content-between"
                >
                  <div
                    class="nav-item col-12 col-6 col-md-3 col-lg-3 filters mx-0 mx-lg-1"
                  >
                    <select
                      class="form-select form-select-sm"
                      aria-label=".form-select-sm "
                      name="price"
                    >
                      <option selected value="0">Filter by price</option>
                      <option value="100">upto &#8377;100</option>
                      <option value="150">upto &#8377;150</option>
                      <option value="200">upto &#8377;200</option>
                      <option value="250">upto &#8377;250</option>
                      <option value="300">upto &#8377;300</option>
                      <option value="350">upto &#8377;350</option>
                      <option value="400">upto &#8377;400</option>
                      <option value="450">upto &#8377;450</option>
                    </select>
                  </div>
                  <div
                    class="nav-item col-12 col-6 col-md-3 col-lg-3 filters mx-0 mx-lg-1 my-1 my-md-0"
                  >
                    <select
                      class="form-select form-select-sm"
                      aria-label=".form-select-sm example"
                      name="category"
                    >
                      <option selected value="">Filter by</option>
                      <option value="Veg">Veg</option>
                      <option value="Non-Veg">Non-Veg</option>
                    </select>
                  </div>
                  <div
                    class="nav-item col-12 col-6 col-md-3 col-lg-3 filters mx-0 mx-lg-1 my-1 my-md-0"
                  >
                    <select
                      class="form-select form-select-sm"
                      aria-label=".form-select-sm example"
                      name="in_stock"
                    >
                      <option selected value="">Filter by Stock</option>
                      <option value="in_stock">In Stock</option>
                      <option value="out_stock">Up Comming</option>
                    </select>
                  </div>

                  <div
                    class="nav-item col-12 col-6 col-md-3 col-lg-3 filters mx-0 mx-lg-1 my-1 my-md-0 d-flex align-items-center"
                  >
                    <!-- <select
                      class="form-select form-select-sm"
                      aria-label=".form-select-sm example"
                    >
                      <option selected>Open this select menu</option>
                      <option value="1">One</option>
                      <option value="2">Two</option>
                      <option value="3">Three</option>
                    </select> -->
                    <button
                      type="submit"
                      class="btn fiter-submit-btn bg-primary-color fw-bold p-1 px-2"
                    >
                      Apply
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </form>
        <!-- filter feacher ends -->
        
        <!-- product-card-container starts -->
        <div
          class="p-0 row product-card-container d-flex justify-content-around gap-1 py-2"
        >
          <div class="card product-card col-12 col-md-5 col-lg-3 p-0">
            <!-- <div class="ribbon red d-flex justify-content-between">
              <div class="ribbon-content">
                <span>Popular</span>
                <div class="ri-container w-full">
                  <div class="ri-up">r</div>
                  <div class="ri-down">i</div>
                </div>
              </div>
            </div> -->
            <img
              class="card-img-top"
              src="../../images/userDashboard/burger1.jpg"
              alt="Card image cap"
            />

            <div class="card-body pb-0">
              <h5 class="Product-title">Classic Cheese Burger</h5>
              <p class="product-desc p-0 m-0">
                Juicy beef patty with fresh lettuce & tomato.
              </p>
              <p class="product-cat p-0 m-0">
                <i class="fa-solid fa-seedling me-1 text-success"></i>veg
                <i class="fa-solid fa-tags text-primary-color ms-2"></i>
                Bestseller
              </p>
              <p class="product-cat text-dark fw-bold p-0 m-0">
                <i
                  class="fa-solid fa-warehouse me-1 text-primary-color"
                ></i
                >Instock
              </p>
              <p class="product-price-details">
                <span
                  ><i
                    class="fa-solid fa-indian-rupee-sign text-warning"
                  ></i>
                  Price :
                </span>
                <span class=""> &#8377; 165/- </span>
                <span
                  class="text-decoration-line-through opacity-75 ms-2"
                >
                  &#8377; 230
                </span>
                <span class="text-success"> 50% off</span>
              </p>
            </div>
            <button class="add2cartbtn">
              <i class="fa-solid fa-cart-plus mx-2"></i>add to cart
            </button>
          </div>
        </div>
        <!-- product-card-container ends -->
      </div>
    </div>
  </div>
</section>
<!--all products ends-->

@endsection

