document.addEventListener("DOMContentLoaded", () => {
  const togglePassword = document.getElementById("togglePassword");
  const passwordInput = document.getElementById("password");
  const employerForm = document.getElementById("employerLoginForm");

  // Toggle Password Field Visibility
  if (togglePassword && passwordInput) {
    togglePassword.addEventListener("click", () => {
      const isPassword = passwordInput.getAttribute("type") === "password";
      passwordInput.setAttribute("type", isPassword ? "text" : "password");

      togglePassword.classList.toggle("fa-eye");
      togglePassword.classList.toggle("fa-eye-slash");
    });
  }

  // Handle Form Submission
  if (employerForm) {
    employerForm.addEventListener("submit", (e) => {
      e.preventDefault();
      
      const email = document.getElementById("workEmail").value;
      const remember = document.getElementById("rememberMe").checked;

      const btn = employerForm.querySelector(".btn-submit");
      btn.style.opacity = "0.7";
      btn.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> Signing in...`;

  });
  }
});