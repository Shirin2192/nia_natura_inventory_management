document.addEventListener('DOMContentLoaded', function () {
//     const fullLabels = stockProductNames;
// var stockLevelChart = new Chart(document.getElementById('stockLevelChart'), {
//     type: 'bar',
//     data: {
//         labels: stockProductNames.map(name => name.length > 15 ? name.substring(0, 15) + '...' : name), // 👈 Place it here
//         datasets: [{
//             label: 'Available Stock',
//             data: stockQuantities,
//             backgroundColor: 'rgba(123, 104, 238, 0.9)',
//             borderColor: '#8A2BE2',
//             borderWidth: 2,
//             borderRadius: 10,
//         }]
//     },
//     options: {
//         responsive: true,
//         maintainAspectRatio: false,
//         plugins: {
//             tooltip: {
//                 callbacks: {
//                     title: function(tooltipItems) {
//                         return fullLabels[tooltipItems[0].dataIndex];
//                     }
//                 }
//             },
//             legend: {
//                 display: true
//             }
//         },
//         scales: {
//             x: {
//                 ticks: {
//                     color: '#4B0082',
//                     autoSkip: false,
//                     maxRotation: 60,
//                     minRotation: 45
//                 },
//                 grid: { color: 'rgba(200, 200, 200, 0.2)' }
//             },
//             y: {
//                 beginAtZero: true,
//                 ticks: { color: '#4B0082' },
//                 grid: { color: 'rgba(200, 200, 200, 0.2)' }
//             }
//         }
//     }
// });
// ✅ Set dynamic canvas width based on number of products
const dynamicWidth = Math.max(stockProductNames.length * 60, 800); // 60px per bar minimum
const chartCanvas = document.getElementById('stockLevelChart');
chartCanvas.style.width = dynamicWidth + 'px'; // Set canvas width
chartCanvas.parentElement.style.overflowX = 'auto'; // Enable horizontal scroll if needed

// ✅ Initialize Chart.js
const stockLevelChart = new Chart(chartCanvas, {
    type: 'bar',
    data: {
        labels: stockProductNames.map(name => name.length > 15 ? name.substring(0, 15) + '...' : name),
        datasets: [{
            label: 'Available Stock',
            data: stockQuantities,
            backgroundColor: 'rgba(123, 104, 238, 0.9)',
            borderColor: '#8A2BE2',
            borderWidth: 2,
            borderRadius: 10,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            tooltip: {
                callbacks: {
                    title: function(tooltipItems) {
                        return stockProductNames[tooltipItems[0].dataIndex]; // Full name in tooltip
                    }
                }
            },
            legend: { display: true }
        },
        scales: {
            x: {
                ticks: {
                    color: '#4B0082',
                    autoSkip: false,
                    maxRotation: 60,
                    minRotation: 45
                },
                grid: { color: 'rgba(200, 200, 200, 0.2)' }
            },
            y: {
                beginAtZero: true,
                ticks: { color: '#4B0082' },
                grid: { color: 'rgba(200, 200, 200, 0.2)' }
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
