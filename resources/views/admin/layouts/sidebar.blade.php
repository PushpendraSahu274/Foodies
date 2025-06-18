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
          <span class="navbar-toggler-icon"></span>
        </button>
              <div class="collapse navbar-collapse" id="navbarNav">
                <!-- here i added ms-auto class to do space between of the items -->
                <ul class="navbar-nav ms-auto">
          <li class="nav-item">
              <a class="nav-link fw-bold ps-0 text-center {{ request()->routeIs('meals') ? 'active text-primary' : '' }}" 
                href="{{ route('meals') }}">
                  Products
              </a>
          </li>

          <li class="nav-item">
              <a class="nav-link fw-bold ps-0 {{ request()->routeIs('admin.customers') ? 'active text-primary' : '' }}" 
                href="{{ route('admin.customers') }}">
                  Customers
              </a>
          </li>

          <li class="nav-item">
              <a class="nav-link fw-bold {{ request()->routeIs('admin.orders') ? 'active text-primary' : '' }}" 
                href="{{ route('admin.orders') }}">
                  Orders
              </a>
          </li>

          <li class="nav-item">
              <a class="nav-link fw-bold" href="javascript:void(0);" id="loadProfile"
                data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling"
                aria-controls="offcanvasScrolling">
                  Profile
              </a>
          </li>

    <li class="nav-item">
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit" class="btn phoneBtn fw-bold">Logout</button>
        </form>
    </li>
</ul>

        </div>
      </div>
    </nav>
  </header>