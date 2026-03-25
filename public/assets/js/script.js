// ===== DOM ELEMENTS =====
const sidebar = document.querySelector(".sidebar");
const sidebarToggle = document.getElementById("sidebarToggle");
const userDropdownBtn = document.getElementById("userDropdownBtn");
const userDropdownMenu = document.getElementById("userDropdownMenu");

// ===== SIDEBAR TOGGLE =====
if (sidebarToggle) {
    sidebarToggle.addEventListener("click", () => {
        sidebar.classList.toggle("active");
    });
}

// ===== USER DROPDOWN TOGGLE =====
if (userDropdownBtn) {
    userDropdownBtn.addEventListener("click", (e) => {
        e.stopPropagation();
        userDropdownMenu.classList.toggle("active");
    });
}

// ===== CLOSE DROPDOWN WHEN CLICKING OUTSIDE =====
document.addEventListener("click", (e) => {
    if (!e.target.closest(".user-dropdown-container")) {
        if (userDropdownMenu) {
            userDropdownMenu.classList.remove("active");
        }
    }
});

// ===== NOTIFICATION BUTTON =====
const notificationBtn = document.querySelector(".notification-btn");
if (notificationBtn) {
    notificationBtn.addEventListener("click", () => {
        alert("No new notifications");
    });
}

// ===== CARD HOVER ANIMATION =====
const summaryCards = document.querySelectorAll(".summary-card");
summaryCards.forEach((card) => {
    card.addEventListener("mouseenter", () => {
        card.style.transition = "all 0.3s cubic-bezier(0.4, 0, 0.2, 1)";
    });
});

// ===== RESPONSIVE SIDEBAR =====
let resizeTimer;
window.addEventListener("resize", () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
        if (window.innerWidth > 768) {
            sidebar.classList.remove("active");
        }
    }, 250);
});

console.log("[KharchaTrack] Dashboard initialized");
s