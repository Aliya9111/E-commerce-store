document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('salesChart').getContext('2d');

    const data = {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [
            {
                label: 'Product A',
                data: [100, 200, 150, 180, 140, 130, 100, 80, 150, 200, 250, 300],
                backgroundColor: 'rgba(0, 181, 204, 0.5)',
                borderColor: 'rgba(0, 181, 204, 1)',
                borderWidth: 2,
                fill: true
            },
            {
                label: 'Product B',
                data: [50, 100, 130, 160, 120, 100, 70, 50, 120, 180, 210, 250],
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 2,
                fill: true
            },
            {
                label: 'Product C',
                data: [80, 150, 120, 140, 130, 110, 90, 70, 100, 160, 200, 240],
                backgroundColor: 'rgba(255, 159, 64, 0.5)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 2,
                fill: true
            }
        ]
    };

    const config = {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    };

    new Chart(ctx, config);
});
