document.addEventListener("DOMContentLoaded", function () {

    var navbar = document.querySelector(".navbar");
    if (navbar) {
        var onScroll = function () {
            if (window.scrollY > 12) {
                navbar.classList.add("is-scrolled");
            } else {
                navbar.classList.remove("is-scrolled");
            }
        };
        onScroll();
        window.addEventListener("scroll", onScroll, { passive: true });
    }

    var revealTargets = document.querySelectorAll(".reveal, .reveal-stagger");
    if (revealTargets.length && "IntersectionObserver" in window) {
        revealTargets.forEach(function (el) { el.classList.add("reveal-hidden"); });

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.remove("reveal-hidden");
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15, rootMargin: "0px 0px -40px 0px" });

        revealTargets.forEach(function (el) { observer.observe(el); });
    }

    var counters = document.querySelectorAll("[data-count-target]");
    counters.forEach(function (el) {
        var target = parseInt(el.getAttribute("data-count-target"), 10) || 0;
        var duration = 900;
        var startTime = null;

        function step(timestamp) {
            if (!startTime) startTime = timestamp;
            var progress = Math.min((timestamp - startTime) / duration, 1);
            var eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = Math.floor(eased * target);
            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                el.textContent = target;
            }
        }
        requestAnimationFrame(step);
    });

    var flash = document.querySelectorAll(".container > div[style*=\"background:#eaf3ec\"], .container > div[style*=\"background:#f7eae8\"]");
    flash.forEach(function (el) {
        setTimeout(function () {
            el.style.transition = "opacity .5s ease, max-height .5s ease, margin .5s ease, padding .5s ease";
            el.style.opacity = "0";
            el.style.maxHeight = el.offsetHeight + "px";
            requestAnimationFrame(function () {
                el.style.maxHeight = "0";
                el.style.marginTop = "0";
                el.style.padding = "0";
                el.style.overflow = "hidden";
            });
        }, 4000);
    });

    // ---- Sidebar slide-out (menu geser), aktif di semua halaman publik ----
    var sidebarToggle = document.querySelector("[data-sidebar-toggle]");
    var sidebarDrawer = document.querySelector("[data-sidebar-drawer]");
    var sidebarOverlay = document.querySelector("[data-sidebar-overlay]");
    var sidebarClose = document.querySelector("[data-sidebar-close]");

    function openSidebar() {
        if (!sidebarDrawer || !sidebarOverlay) return;
        sidebarDrawer.classList.add("open");
        sidebarOverlay.classList.add("active");
        document.body.style.overflow = "hidden";
    }
    function closeSidebar() {
        if (!sidebarDrawer || !sidebarOverlay) return;
        sidebarDrawer.classList.remove("open");
        sidebarOverlay.classList.remove("active");
        document.body.style.overflow = "";
    }
    if (sidebarToggle) sidebarToggle.addEventListener("click", openSidebar);
    if (sidebarClose) sidebarClose.addEventListener("click", closeSidebar);
    if (sidebarOverlay) sidebarOverlay.addEventListener("click", closeSidebar);
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape") closeSidebar();
    });

});
