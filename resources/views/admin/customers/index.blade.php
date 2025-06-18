
@extends('admin.layouts.master')
@section('page-title')
customer
@endsection

@section('admin-page-content')
 <div class="container-fluid px-0">

      <!-- sidebar ends -->
      <div class="container">
        <div class="row">
          <div
            class="col-sm-12 text-white opacity-100 fw-bold p-1 px-2 p-lg-2 rounded mb-3 bg-primary-color"
          >
            <i
              class="fa-solid fa-users bg-white text-primary-color rounded p-1"
            ></i>
            Customers
          </div>
          <div class="col-sm-12 table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Customer Id</th>
                  <th scope="col">Customer Name</th>
                  <th scope="col">Customer Email</th>
                  <th scope="col">Customer Mobile</th>
                  <th scope="col">Customer Joined</th>

                  <th scope="col" colspan="3">Profile Picture</th>
                </tr>
              </thead>
              <tbody id="costomers-data-container">
                <tr>
                  <th scope="row">1</th>
                  <td>Raj Mishra</td>
                  <td>erajmishra@gmail.com</td>
                  <td>+91 6387874250</td>
                  <td>
                    <img
                      src="../../images/review/review-1.jpg"
                      class="card-img-top w-25 h-25 img-fluid rounded-circle mx-auto"
                      alt="..."
                    />
                  </td>
                  <td><button class="btn btn-sm btn-danger">remove</button></td>
                  <td>Give Discount</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
@endsection