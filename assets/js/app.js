document.addEventListener("DOMContentLoaded", function () {
  // Mobile navigation
  const menuToggle = document.querySelector(".menu-toggle");
  const nav = document.querySelector(".nav");

  if (menuToggle && nav) {
    menuToggle.addEventListener("click", function () {
      nav.classList.toggle("open");

      const expanded = nav.classList.contains("open");
      menuToggle.setAttribute("aria-expanded", expanded ? "true" : "false");
    });

    nav.querySelectorAll("a").forEach(function (link) {
      link.addEventListener("click", function () {
        nav.classList.remove("open");
        menuToggle.setAttribute("aria-expanded", "false");
      });
    });
  }

  // Current year in footer
  document.querySelectorAll("[data-year]").forEach(function (element) {
    element.textContent = new Date().getFullYear();
  });

  // Confirm delete actions
  document.querySelectorAll("[data-confirm-delete]").forEach(function (element) {
    element.addEventListener("click", function (event) {
      const message =
        element.getAttribute("data-confirm-delete") ||
        "Are you sure you want to delete this item?";

      if (!window.confirm(message)) {
        event.preventDefault();
      }
    });
  });

  // Automatically hide alerts after a few seconds
  document.querySelectorAll(".alert[data-auto-hide]").forEach(function (alert) {
    setTimeout(function () {
      alert.style.transition = "opacity 0.4s ease";
      alert.style.opacity = "0";

      setTimeout(function () {
        alert.remove();
      }, 400);
    }, 5000);
  });

  // Prevent accidental double submission
  document.querySelectorAll("form[data-prevent-double-submit]").forEach(function (form) {
    form.addEventListener("submit", function () {
      const submitButton = form.querySelector(
        'button[type="submit"], input[type="submit"]'
      );

      if (submitButton) {
        submitButton.disabled = true;
        submitButton.dataset.originalText =
          submitButton.textContent || submitButton.value;

        if (submitButton.tagName === "INPUT") {
          submitButton.value = "Please wait...";
        } else {
          submitButton.textContent = "Please wait...";
        }
      }
    });
  });

  // Image preview for file inputs
  document.querySelectorAll("input[type='file'][data-preview]").forEach(function (input) {
    input.addEventListener("change", function () {
      const previewSelector = input.getAttribute("data-preview");
      const preview = document.querySelector(previewSelector);

      if (!preview || !input.files || !input.files[0]) {
        return;
      }

      const file = input.files[0];

      if (!file.type.startsWith("image/")) {
        preview.removeAttribute("src");
        preview.classList.add("hidden");
        return;
      }

      const reader = new FileReader();

      reader.onload = function (event) {
        preview.src = event.target.result;
        preview.classList.remove("hidden");
      };

      reader.readAsDataURL(file);
    });
  });
});
