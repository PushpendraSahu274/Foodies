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