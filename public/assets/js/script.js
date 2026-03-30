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

// ===== COLOR PICKER =====
const colorInput = document.getElementById("color");
const colorSample = document.getElementById("colorSample");
const colorValue = document.getElementById("colorValue");

if (colorInput) {
    colorInput.addEventListener("input", (e) => {
        const color = e.target.value;
        if (colorSample) colorSample.style.backgroundColor = color;
        if (colorValue) colorValue.textContent = color.toUpperCase();
    });
}

// ===== TRANSACTION TYPE TOGGLE =====
function selectType(type) {
    const incomeBtn = document.getElementById("incomeBtnDisplay");
    const expenseBtn = document.getElementById("expenseBtnDisplay");

    if (incomeBtn && expenseBtn) {
        incomeBtn.classList.remove("active");
        expenseBtn.classList.remove("active");

        if (type === "income") {
            incomeBtn.classList.add("active");
        } else {
            expenseBtn.classList.add("active");
        }
    }
}

// ===== EDIT TRANSACTION PAGE =====
// Handles type toggle radio buttons for edit page
// selectType function already handles income/expense toggle

// Initialize edit page with correct type button state
document.addEventListener("DOMContentLoaded", function () {
    const typeIncome = document.getElementById("typeIncome");
    const typeExpense = document.getElementById("typeExpense");

    if (typeIncome && typeExpense) {
        // Set initial active state based on checked radio
        if (typeExpense.checked) {
            document
                .getElementById("expenseBtnDisplay")
                .classList.add("active");
            document
                .getElementById("incomeBtnDisplay")
                .classList.remove("active");
        } else {
            document.getElementById("incomeBtnDisplay").classList.add("active");
            document
                .getElementById("expenseBtnDisplay")
                .classList.remove("active");
        }
    }
});

// ===== EXPORT PAGE — QUICK SELECT BUTTONS =====
function setDateRange(range) {
    const fromDate = document.getElementById("date_from");
    const toDate = document.getElementById("date_to");

    if (!fromDate || !toDate) return;

    const now = new Date();
    const year = now.getFullYear();
    const month = now.getMonth();

    switch (range) {
        case "this_month":
            fromDate.value = formatDate(new Date(year, month, 1));
            toDate.value = formatDate(new Date(year, month + 1, 0));
            break;
        case "last_month":
            fromDate.value = formatDate(new Date(year, month - 1, 1));
            toDate.value = formatDate(new Date(year, month, 0));
            break;
        case "last_3_months":
            fromDate.value = formatDate(new Date(year, month - 2, 1));
            toDate.value = formatDate(new Date(year, month + 1, 0));
            break;
        case "this_year":
            fromDate.value = formatDate(new Date(year, 0, 1));
            toDate.value = formatDate(new Date(year, 11, 31));
            break;
    }
}

function formatDate(date) {
    // Formats date to YYYY-MM-DD for input[type=date]
    const y = date.getFullYear();
    const m = String(date.getMonth() + 1).padStart(2, "0");
    const d = String(date.getDate()).padStart(2, "0");
    return `${y}-${m}-${d}`;
}
