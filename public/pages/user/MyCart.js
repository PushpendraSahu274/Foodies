// accessing the data from the localstorage of cart
console.log("hii");
let productAmount = 0;
let cart = JSON.parse(localStorage.getItem("cart")) || [];
console.log(cart);

//selecting the cart container to show the all cards in this container
cartContainer = document.querySelector(".my-card-container");
//function for adjust the items amount
function setProductAmount(e) {
  const card = e.closest(".cart-product-card");
  const title = card.querySelector(".Product-title").innerText;

  cart = cart.map((item) => {
    if (item.name === title) {
      if (e.classList.contains("increase")) {
        item.quantity += 1;
      }
      if (e.classList.contains("decrease") && item.quantity > 1) {
        item.quantity -= 1;
      }
    }
    return item;
  });

  localStorage.setItem("cart", JSON.stringify(cart));
  displayCartProduct(cart);
}

// function for display the carts in the cartContainer
const displayCartProduct = function (cart) {
  cartContainer.innerHTML = cart
    // for accessing all the data from the cart
    .map((item) => {
      return `<div class="card cart-product-card col-sm-12 col-md-5 col-lg-3 p-0 mx-auto my-2" >
          <img
            class="card-img-top"
            src="${item.image}"
            alt="Card image cap"
          />

          <div class="card-body pb-0">
            <h5 class="Product-title">${item.name}</h5>
            <p class="product-desc p-0 m-0">
              ${item.description}
            </p>
           <p class="product-cat p-0 m-0">
                      ${
                        item.category == "Veg"
                          ? `<i class="fa-solid fa-seedling me-1 text-success"></i>veg`
                          : `<i class="fa-solid fa-seedling me-1 text-danger"></i>nonveg`
                      }
                      <i class="fa-solid fa-tags text-primary-color ms-2"></i> Bestseller
                    </p>
           <p class="product-cat text-dark fw-bold p-0 m-0">
                      <i class="fa-solid fa-warehouse me-1 text-primary-color"></i>${
                        item.in_stock == "in_stock" ? "instock" : "outstock"
                      }
                    </p>
            <div
              class="btn-group py-2"
              role="group"
              aria-label="Basic outlined example"
            >
              <button
                type="button"
                class="btn btn-outline-danger fs-sm py-0 rounded-start decrease"
                onClick = "setProductAmount(this)"
              >
               -
              </button>
              <button
                type="button"
                class="btn btn-outline-danger py-0 rounded-0 mx-1"
              >
                ${item.quantity}
              </button>
              <button
                type="button"
                class="btn btn-outline-danger py-0 rounded-end increase"
                onClick = "setProductAmount(this)" 
              >
                +
              </button>
            </div>
           <p class="product-price-details">
                      <span><i class="fa-solid fa-indian-rupee-sign text-warning"></i> Price :</span>
                      <span class=""> &#8377; ${Math.floor(
                        (item.price * (100 - item.discount)) / 100
                      )}/- </span>
                      <span class="text-decoration-line-through opacity-75 ms-2"> &#8377; ${
                        item.price
                      }</span>
                      <span class="text-success"> ${item.discount}% off</span>
                    </p>
            <p class="product-price-details">
              <span> Total Price : </span>
              <span class=""> &#8377; ${
                Math.floor((item.price * (100 - item.discount)) / 100) *
                item.quantity
              } </span>
              <span class="opacity-75 ms-2"> You saved &#8377; </span>
              <span class="text-success"> ${
                item.price * item.quantity -
                Math.floor((item.price * (100 - item.discount)) / 100) *
                  item.quantity
              }</span>
            </p>
          </div>
          <div class="btns row d-flex justify-content-evenly py-2 gap-2 gap-md-0 p-2">
         <button class="RemoveBtn col-12 col-md-6">
            <i class="fa-solid fa-trash mx-2"></i>Remove Item
          </button>
           <button class="OrderBtn bg-success col-12  col-md-5">
            <i class="fa-solid fa-cart-plus mx-2"></i>Order Now
          </button>
          
          </div>
          
        </div>`;
    })
    // to remove the commas
    .join("");
};
// show the data after all the content loaded
document.addEventListener("DOMContentLoaded", function () {
  // calling the function to show the carts in the product container here cart contains all the data from local storage
  displayCartProduct(cart);
  // onclick function to remove the cart from my cart
  // applying click event on the whole document
  document.addEventListener("click", (event) => {
    // checking which button is remove button
    if (event.target.classList.contains("RemoveBtn")) {
      // selcecting the exact cart which on the user clicked
      let ProductCart = event.target.closest(".cart-product-card");
      // storing the title name to search related data of the cart from the cart array
      let ProductTitle = ProductCart.querySelector(".Product-title");
      // filtering the the data which have no this title and that's a way to remove clicked product
      cart = cart.filter((item) => {
        return item.name != ProductTitle.innerText;
      });
      // debugging starts --- completed successfully-- data was updated after the refresh because of fetck keyword
      setTimeout(() => {
        // console.log("this is data returned by filter function");
        // console.log(cart);
        // console.log("this is previous data");
        // console.log(cart);
        localStorage.setItem("cart", JSON.stringify(cart));
        // console.log("this is updated data");
        // console.log(cart);
        displayCartProduct(cart);
      }, 10);
      // debugging ends
    }
  });
});

// alert("hello");
