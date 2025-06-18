document.addEventListener("DOMContentLoaded", function () {
  let AllProductsData;
  fetch("../../data/products.json")
    .then((response) => response.json())
    .then((data) => {
      AllProductsData = data;
      displayProducts(data);
    })
    .catch((error) => console.error("Error loading JSON:", error));

  let productCardContainer = document.querySelector(".product-card-container");

  const displayProducts = function (data) {
    productCardContainer.innerHTML = data
      .map((item) => {
        return `<div class="card product-card col-12 col-md-5 col-lg-3 p-2 mx-1 my-2">
                  <img class="card-img-top" src="${
                    item.image
                  }" alt="Card image cap" />
                  <div class="card-body pb-0">
                    <h5 class="Product-title">${item.name}</h5>
                    <p class="product-desc p-0 m-0">${item.description}</p>
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
                  </div>
                  <button class="add2cartbtn rounded">
                    <i class="fa-solid fa-cart-plus mx-2"></i>add to cart
                  </button>
                </div>`;
      })
      .join("");
  };

  let filterForm = document.getElementById("filterForm");
  filterForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const formData = new FormData(filterForm);
    let Price = parseInt(formData.get("price"));
    let Category = formData.get("category");
    let In_stock = formData.get("in_stock");

    setTimeout(() => {
      let filteredData = AllProductsData.filter((item) => {
        return (
          item.price >= Price &&
          (!Category || item.category == Category) &&
          (!In_stock || item.in_stock == In_stock)
        );
      });

      displayProducts(filteredData);
    }, 1000);
  });

  // Attach event listener to dynamically created buttons
  document.addEventListener("click", (event) => {
    if (event.target.classList.contains("add2cartbtn")) {
      AddToCart(event);
    }
  });
  // adding product into the local storage
  const addStorageCart = function (product) {
    // Retrieve existing cart data or initialize an empty array
    console.log(product);

    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    // Check if the product already exists in the cart
    let existingProduct = cart.find((item) => item.id === product.id);

    if (existingProduct) {
      // If product exists, update the quantity
      alert(`${product.name} is already added to cart`);
    } else {
      // Otherwise, add a new product to the cart

      cart.push(product);
      alert(`${product.name} is added to cart`);
    }

    // Save updated cart data back to `localStorage`
    localStorage.setItem("cart", JSON.stringify(cart));
  };
  let AddToCartProduct;
  const AddToCart = function (event) {
    let productCard = event.target.closest(".product-card");
    let productName = productCard.querySelector(".Product-title").innerText;
    // alert(`Added "${productName}" to cart`);
    AddToCartProduct = AllProductsData.find((item) => {
      return item.name === productName;
    });
    console.log(AddToCartProduct);
    addStorageCart(AddToCartProduct);
  };
});
