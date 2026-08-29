document.addEventListener("DOMContentLoaded", () => {
  const toggle = document.querySelector(".nav-toggle");
  const nav = document.querySelector(".site-header nav");

  if (toggle && nav) {
    toggle.addEventListener("click", () => {
      nav.classList.toggle("open");
    });
  }

  document.querySelectorAll('a[href^="#"]').forEach(link => {
    link.addEventListener("click", e => {
      const target = document.querySelector(link.getAttribute("href"));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({
          behavior: "smooth",
          block: "start"
        });
      }
    });
  });

  document.querySelectorAll(".more").forEach(button => {
    button.addEventListener("click", () => {
      const targetId = button.dataset.target;
      const target = document.getElementById(targetId);

      if (target) {
        target.hidden = !target.hidden;
        button.textContent = target.hidden ? "More" : "Show less";
      }
    });
  });

  document.querySelectorAll("form[data-confirm]").forEach(form => {
    form.addEventListener("submit", e => {
      if (!confirm(form.dataset.confirm)) {
        e.preventDefault();
      }
    });
  });
});
