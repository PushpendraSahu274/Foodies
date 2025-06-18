@extends('admin.layouts.master')

@section('page-title')
Orders
@endsection

@section('admin-page-content')
<div class="container-fluid smallFont px-0">
      <!-- modals -->

      <!-- sidebar starts -->
      
      <!-- sidebar ends -->
      <div class="container">
        <div class="row">
          <div class="col-sm-12" id="orderDetailsModal">
            <!-- Offcanvas Template (Place it once in your HTML body) -->
            <!-- Bootstrap Offcanvas for Order Details -->
            <div
              class="offcanvas offcanvas-end"
              tabindex="-1"
              id="offcanvasWithBackdrop"
              aria-labelledby="offcanvasLabel"
            >
              <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="offcanvasLabel">
                  Order Details
                </h5>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="offcanvas"
                  aria-label="Close"
                ></button>
              </div>
              <div class="offcanvas-body" id="offcanvas-body"></div>
            </div>
          </div>
        </div>
        <div class="row">
          <div
            class="col-sm-12 text-white opacity-100 py-1 p-lg-2 rounded mb-3 bg-primary-color"
          >
            <i class="fa-solid fa-gift"></i> Orders
          </div>
          <div class="col-sm-12 table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Order Id</th>
                  <th scope="col">Product Name</th>
                  <th scope="col">Frequency</th>
                  <th scope="col">Total Price</th>
                  <th scope="col">Product Image</th>
                  <th scope="col">Customer Id</th>
                  <th scope="col">Customer Name</th>
                  <th scope="col ">order status</th>
                  <th scope="col ">Details</th>
                </tr>
              </thead>
              <tbody id="customers-orders-container">
                <tr>
                  <td scope="col">Order Id</td>
                  <td scope="col">Product Name</td>
                  <td scope="col">Frequency</td>
                  <td scope="col">Total Price</td>
                  <td scope="col">Product Image</td>
                  <td scope="col">Customer Id</td>
                  <td scope="col">Customer Name</td>
                  <td scope="col "><span class="text-info">pending</span></td>

                  <td scope="col ">
                    <button class="btn btn-sm btn-danger">view</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
</div>
@endsection
