let modalLoginForm = document.getElementById("modal-user-login-form");

// All functions functions
const clearLoginInput = function () {
  document.getElementById("LoginEmail").value = "";
  document.getElementById("LoginPwd").value = "";
};
const userAuth = function (LoginEmail, LoginPwd) {
  if (LoginEmail === "erajmishra000@gmail.com" && LoginPwd === "123") {
    alert("Logged in as " + LoginEmail);
    clearLoginInput();
    window.location.href = "pages/user/userDashboard.html";
  } else if (LoginEmail === "admin@gmail.com" && LoginPwd === "123") {
    alert("You Logged In as Admin");
    clearLoginInput();
    window.location.href = "pages/admin/adminDashboard.html";
  } else {
    alert("Invalid credentials");
    clearLoginInput();
  }
};
modalLoginForm.addEventListener("submit", (e) => {
  e.preventDefault(); // Prevent default form submission
  var LoginEmail = document.getElementById("LoginEmail").value;
  var LoginPwd = document.getElementById("LoginPwd").value;
  userAuth(LoginEmail, LoginPwd);
  console.log(LoginEmail, LoginPwd);
});
// creating alerts
function createAlert(message, type) {
  const alertContainer = document.getElementById("alert-container");
  const wrapper = document.createElement("div");
  wrapper.innerHTML = `
    <div class="alert alert-${type} alert-dismissible fade show" role="alert">
      ${message}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  `;
  alertContainer.append(wrapper);
}

window.addEventListener("DOMContentLoaded", () => {
  setTimeout(() => {
    const credentialsModal = new bootstrap.Modal(
      document.getElementById("credentialsModal")
    );
    credentialsModal.show();
  }, 1000);
});
