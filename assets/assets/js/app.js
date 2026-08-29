document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.querySelector(".nav-toggle");
    const nav = document.querySelector(".site-header nav");

    if (toggle && nav) {
        toggle.addEventListener("click", function () {
            nav.classList.toggle("open");
        });
    }

    document.querySelectorAll('a[href^="#"]').forEach(function (link) {
        link.addEventListener("click", function (e) {
            const target = document.querySelector(
                link.getAttribute("href")
            );

            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });
            }
        });
    });

    document.querySelectorAll(".more").forEach(function (button) {
        button.addEventListener("click", function () {
            const targetId = button.dataset.target;
            const target = document.getElementById(targetId);

            if (target) {
                target.hidden = !target.hidden;
                button.textContent = target.hidden
                    ? "More"
                    : "Show less";
            }
        });
    });
});
