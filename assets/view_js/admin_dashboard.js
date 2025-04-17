document.addEventListener('DOMContentLoaded', function () {
    
   // Stock Levels by Product (Bar) - Single Color Effect
   var stockLevelChart = new Chart(document.getElementById('stockLevelChart'), {
    type: 'bar',
    data: {
        labels: stockProductNames, // JavaScript variable for product names
        datasets: [{
            label: 'Available Stock',
            data: stockQuantities, // JavaScript variable for quantities
            backgroundColor: 'rgba(123, 104, 238, 0.9)', // Single vibrant color (Purple)
            borderColor: '#8A2BE2',  // Border color matches the bar color (Violet)
            borderWidth: 2,
            borderRadius: 10, // Rounded corners for bars
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { 
                labels: { color: '#8A2BE2', font: { size: 14, weight: 'bold' } } // Legend color matching the theme
            },
            tooltip: {
                backgroundColor: '#8A2BE2', // Tooltip background with the same violet color
                titleColor: '#fff',
                bodyColor: '#fff',
                borderColor: '#FFD700', // Golden border for contrast
                borderWidth: 1
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { color: '#4B0082' }, // Indigo for ticks
                grid: { color: 'rgba(200, 200, 200, 0.2)' } // Subtle grid lines
            },
            x: {
                ticks: { color: '#4B0082' }, // Indigo for ticks
                grid: { color: 'rgba(200, 200, 200, 0.2)' } // Subtle grid lines
            }
        }
    }
});




    // Prepare data for chart
    var productLabels = [];
    var nearExpiryCounts = [];
    var healthyCounts = [];

    // Collect labels and counts
    batchExpiryNear.forEach(function(item) {
        productLabels.push(item.product_name);
        nearExpiryCounts.push(item.near_expiry_count);
    });

    // Match healthy products (make sure order matches)
    batchExpiryHealthy.forEach(function(item) {
        var index = productLabels.indexOf(item.product_name);
        if (index !== -1) {
            healthyCounts[index] = item.healthy_count;
        } else {
            // If healthy product not in near expiry list, add it separately
            productLabels.push(item.product_name);
            nearExpiryCounts.push(0);
            healthyCounts.push(item.healthy_count);
        }
    });

    // Build pie chart (Batch Expiry Status)
    var batchExpiryChart = new Chart(document.getElementById('batchExpiryChart'), {
        type: 'pie',
        data: {
            labels: productLabels, // Product names
            datasets: [{
                label: 'Batch Expiry Status',
                data: nearExpiryCounts.map((v, i) => v + healthyCounts[i]), // Total batches per product
                backgroundColor: ['#e74a3b', '#1cc88a', '#36b9cc', '#f6c23e', '#858796', '#4e73df'], // Add more colors if needed
                hoverBackgroundColor: ['#d82a2a', '#17a673', '#2c9faf', '#dda20a', '#6c757d', '#2e59d9'],
                hoverBorderColor: "rgba(234, 236, 244, 1)"
            }]
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            var label = context.label || '';
                            var index = context.dataIndex;
                            var total = nearExpiryCounts[index] + healthyCounts[index];
                            return label + ': ' + total + ' batches (Near expiry: ' + nearExpiryCounts[index] + ', Healthy: ' + healthyCounts[index] + ')';
                        }
                    }
                }
            }
        }
    });

    // Top 5 Products by Quantity (Horizontal Bar)
    var topProductsChart = new Chart(document.getElementById('topProductsChart'), {
        type: 'bar',
        data: {
            labels: top5ProductNames, // JavaScript variable for product names
            datasets: [{
                label: 'Quantity',
                data: top5Quantities, // JavaScript variable for quantities
                backgroundColor: '#36b9cc'
            }]
        },
        options: {
            indexAxis: 'y', // This makes it horizontal
            responsive: true,
            scales: { x: { beginAtZero: true } }
        }
    });

    // Out-of-Stock Trends (Line)
    var outOfStockTrendsChart = new Chart(document.getElementById('outOfStockTrendsChart'), {
        type: 'line',
        data: {
            labels: trendWeeksOrMonths, // JavaScript variable for trend weeks or months
            datasets: [{
                label: 'Out-of-Stock Events',
                data: outOfStockCounts, // JavaScript variable for out-of-stock counts
                fill: false,
                borderColor: '#f6c23e',
                tension: 0.4
            }]
        },
        options: {
            responsive: true
        }
    });

});
