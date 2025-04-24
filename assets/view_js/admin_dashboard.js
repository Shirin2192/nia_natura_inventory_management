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

});
