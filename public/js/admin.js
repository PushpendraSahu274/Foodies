fetch("../../data/products.json")
  .then((response) => {
    // console.log("Response URL:", response.url);
    if (!response.ok) throw new Error("HTTP error " + response.status);
    return response.json();
  })
  .then((data) => {
    // console.log("Loaded Data:", data);

    let productDataContainer = document.getElementById(
      "product-data-container"
    );
    // console.log(productDataContainer);
    displayProductsData(productDataContainer, data);
  })
  .catch((error) => console.error("Error loading JSON:", error));

function displayProductsData(container, data) {
  console.log(container, data);
  container.innerHTML = data
    .map((item) => {
      return `
         <tr>
                  <th scope="row">${item.id}</th>
                  <td>${item.name}</td>
                  <td>${item.price}</td>
                  <td>${item.category}</td>
                  <td>${item.discount}</td>
                  <td>${item.in_stock}</td>
                  <td><img
                      src="${item.image}"
                      alt=""
                      width="100px"
                      max-height ="150px"
                      class="img-fluid rounded"
                    /></td>
                  <td>345 pieces</td>
                  <th scope="col"><a href="editProduct.html" class ="text-success"><i class="fas fa-edit text-success"></i>
                    </a></th>
                  <th scope="col"><a href="#" class="text-danger"><i class="fas fa-trash text-danger"></i>
                </a></th>
                </tr>
        `;
    })
    .join("");
}
fetch("../../data/costomers.json")
  .then((response) => {
    // console.log("Response URL:", response.url);
    if (!response.ok) throw new Error("HTTP error " + response.status);
    return response.json();
  })
  .then((data) => {
    // console.log("Loaded Data:", data);

    let costomersDataContainer = document.getElementById(
      "costomers-data-container"
    );
    // console.log(productDataContainer);
    displayCostomersData(costomersDataContainer, data);
  })
  .catch((error) => console.error("Error loading JSON:", error));

function displayCostomersData(container, data) {
  console.log(container, data);
  container.innerHTML = data
    .map((item) => {
      return `
        <tr>
                  <th scope="row">${item.id}</th>
                  <td>${item.name}</td>
                  <td>${item.email}</td>
                  <td>+91 ${item.mobile}</td>
                   <td> ${item.registration_date}</td>
                  <td>
                    <img
                      src="${item.profile_picture}"
                      class="card-img-top w-25 h-25 img-fluid rounded-circle mx-auto"
                      alt="..."
                    />
                  </td>
                  <td><button class="btn btn-sm btn-danger">block</button></td>
                  <td><button class="btn btn-sm btn-success">view profile</button></td>
                </tr>
        `;
    })
    .join("");
}
// coding for orders render
fetch("../../data/orders.json")
  .then((response) => {
    console.log("Response URL:", response.url);
    if (!response.ok) throw new Error("HTTP error " + response.status);
    return response.json();
  })
  .then((data) => {
    // console.log("Loaded Data:", data);

    let costomersOrderContainer = document.getElementById(
      "customers-orders-container"
    );
    // console.log(productDataContainer);
    displayCostomerOrder(costomersOrderContainer, data);
    // viewing and updating the status of orders
    let viewAndUpdateBtn = document.querySelectorAll(".vAndaBtn");
    viewAndUpdateBtn.forEach((btn) => {
      btn.addEventListener("click", () => {
        const orderId = btn.dataset.orderId;
        displayOrderDetails(data, orderId);

        // Optionally open modal or perform an action
      });
    });
  })
  .catch((error) => console.error("Error loading JSON:", error));
function displayOrderDetails(data, orderId) {
  console.log(data, orderId);
  let orderDetail = data.filter((item) => {
    return item.order_id == orderId;
  });
  let offcanvasBody = document.getElementById("offcanvas-body");
  console.log(offcanvasBody);
  console.log(orderDetail);

  offcanvasBody.innerHTML = `
  <!-- Order Details Card -->
                <div class="card mb-4">
                  <div class="card-body">
                    <h5 class="card-title mb-3 text-primary-color">
                      Customer Information
                    </h5>
                    <p>
                      <img
                        src="${orderDetail[0].customer.profile_picture}"
                        class="card-img-top w-25 h-25 img-fluid rounded-circle mx-auto"
                        alt="..."
                      />
                    </p>
                    <p>
                      <strong>Customer ID:</strong>
                      <span id="order-id">${orderDetail[0].customer.id}</span>
                    </p>
                    <p>
                      <strong>Name:</strong>
                      <span id="customer-name">${
                        orderDetail[0].customer.name
                      }</span>
                    </p>
                    <p>
                      <strong>Email:</strong>
                      <span id="customer-email">${
                        orderDetail[0].customer.email
                      }</span>
                    </p>
                    <p>
                      <strong>Mobile:</strong>
                      <span id="customer-mobile">${
                        orderDetail[0].customer.mobile
                      }</span>
                    </p>
                    <p>
                      <strong>Order Date:</strong>
                      <span id="order-date">${orderDetail[0].order_date}</span>
                    </p>
                    <p>
                      <strong>Delivery Address:</strong>
                      <span id="order-date">${
                        orderDetail[0].customer.demo_address
                      }</span>
                    </p>
                    <h5 class="card-title mb-3 text-primary-color">
                      Order Information
                    </h5>
                    <p>
                      <img
                        src="${orderDetail[0].product.image}"
                        alt=""
                        width="100px"
                        max-height="150px"
                        class="img-fluid rounded"
                      />
                    </p>
                    <p>
                      <strong>Order ID:</strong>
                      <span id="order-id">${orderDetail[0].order_id}</span>
                    </p>
                    <p>
                      <strong>Product Name:</strong>
                      <span id="order-name">${
                        orderDetail[0].product.name
                      }</span>
                    </p>
                    <p>
                      <strong>Total Quantity : </strong>
                      <span id="total-price">${
                        orderDetail[0].product.quantity_ordered
                      }</span>
                    </p>
                    <p>
                      <strong>Total Price : </strong>
                      <span id="total-price">${
                        orderDetail[0].product.price *
                        orderDetail[0].product.quantity_ordered
                      }</span>
                    </p>

                    
                  </div>
                </div>

                <!-- Update Order Status Form -->
                <form
                  id="update-order-form"
                  onsubmit="event.preventDefault(); updateOrderStatus();"
                >
                  <h6 class="mb-3 text-primary-color">Update Order Status</h6>
                  <div class="mb-3">
                    <label for="order-status" class="form-label">Status</label>
                    <select class="form-select" id="order-status" required>
                      <option value="Pending">Pending</option>
                      <option value="Processing">Confirmed</option>
                      <option value="Delivered">Delivered</option>
                      <option value="Cancelled">Cancelled</option>
                    </select>
                  </div>
                  <button type="submit" class="btn btn-success w-100">
                    Update Status
                  </button>
                </form>
  
  
  `;
}
function displayCostomerOrder(container, data) {
  console.log(container, data);
  container.innerHTML = data
    .map((item) => {
      return `
        <tr>
                  <th scope="row">${item.order_id}</th>
                  <td>${item.product.name}</td>
                  <td>${item.product.quantity_ordered}</td>
                  <td> ${
                    item.product.price * item.product.quantity_ordered
                  }</td>
                   <td> <img
                      src="${item.product.image}"
                      alt=""
                      width="100px"
                      max-height ="150px"
                      class="img-fluid rounded"
                    /></td>
                  <td>
                  ${item.customer.id}
                  </td>
                  <td> ${item.customer.name}</td>
                  <td class="text-info"> ${item.status}</td>
                  <td><button class="btn btn-sm btn-danger view-btn vAndaBtn"
          type="button" 

          data-bs-toggle="offcanvas"
          data-bs-target="#offcanvasWithBackdrop"
          data-order-id="${item.order_id}">
          Update
        </button>
        </td>
                </tr>
        `;
    })
    .join("");
}
