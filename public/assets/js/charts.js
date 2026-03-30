// ===== KHARCHATRACK CHARTS =====
// This file handles all Chart.js initializations
// Data is injected from Blade via window.chartData object
// set in dashboard index.blade.php @push('scripts')

document.addEventListener("DOMContentLoaded", function () {
    // ===== PIE CHART — Spending by Category =====
    // Only runs if pieChart canvas exists (dashboard page only)
    const pieCtx = document.getElementById("pieChart");

    if (pieCtx) {
        // Get data injected from Blade
        const spendingData = window.spendingData || [];

        if (spendingData.length > 0) {
            new Chart(pieCtx, {
                type: "doughnut",
                data: {
                    // Extract category names for labels
                    labels: spendingData.map((item) => item.name),
                    datasets: [
                        {
                            // Extract amounts for data
                            data: spendingData.map((item) => item.total),
                            // Use category colors from database
                            backgroundColor: spendingData.map(
                                (item) => item.color,
                            ),
                            borderWidth: 2,
                            borderColor: "#ffffff",
                        },
                    ],
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: "bottom",
                            labels: {
                                padding: 15,
                                font: { size: 12 },
                            },
                        },
                        tooltip: {
                            callbacks: {
                                // Custom tooltip showing NPR currency
                                label: function (context) {
                                    const value = context.parsed;
                                    return (
                                        context.label +
                                        ": NPR " +
                                        value.toLocaleString("en-US", {
                                            minimumFractionDigits: 2,
                                        })
                                    );
                                },
                            },
                        },
                    },
                },
            });
        } else {
            // Show empty state if no expense data
            pieCtx.parentElement.innerHTML = `
                <h3 class="chart-title">
                    <i class="fas fa-chart-pie"></i>
                    Spending by Category
                </h3>
                <div class="chart-empty">
                    <i class="fas fa-chart-pie"></i>
                    <p>No expense data this month</p>
                </div>
            `;
        }
    }

    // ===== BAR CHART — Monthly Overview =====
    // Only runs if barChart canvas exists (dashboard page only)
    const barCtx = document.getElementById("barChart");

    if (barCtx) {
        // Get data injected from Blade
        const monthlyData = window.monthlyData || [];

        new Chart(barCtx, {
            type: "bar",
            data: {
                // Extract month labels e.g. ['Oct 2025', 'Nov 2025'...]
                labels: monthlyData.map((item) => item.month),
                datasets: [
                    {
                        label: "Income",
                        // Extract income amounts
                        data: monthlyData.map((item) => item.income),
                        backgroundColor: "rgba(34, 197, 94, 0.8)",
                        borderColor: "#22c55e",
                        borderWidth: 1,
                        borderRadius: 6,
                    },
                    {
                        label: "Expense",
                        // Extract expense amounts
                        data: monthlyData.map((item) => item.expense),
                        backgroundColor: "rgba(239, 68, 68, 0.8)",
                        borderColor: "#ef4444",
                        borderWidth: 1,
                        borderRadius: 6,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: "top",
                        labels: {
                            font: { size: 12 },
                            padding: 15,
                        },
                    },
                    tooltip: {
                        callbacks: {
                            // Custom tooltip showing NPR currency
                            label: function (context) {
                                return (
                                    context.dataset.label +
                                    ": NPR " +
                                    context.parsed.y.toLocaleString("en-US", {
                                        minimumFractionDigits: 2,
                                    })
                                );
                            },
                        },
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            // Format Y axis with NPR
                            callback: function (value) {
                                return "NPR " + value.toLocaleString();
                            },
                        },
                    },
                },
            },
        });
    }
});
