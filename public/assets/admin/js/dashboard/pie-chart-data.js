const appointmentCountRoute = "/admin/dashboard/api/appointment-counts";
const orderStatusRoute = "/admin/dashboard/api/order-payment-counts";

const fetchAppointmentCounts = () => {
    // show loading indicator
    const pieCountCard = document.getElementsByClassName('pieCountCard');
    loadingIndicator(true); // show loading indicator

    fetch(appointmentCountRoute)
        .then(response => response.json())
        .then(data => {
            loadingIndicator(); // hide loading indicator
            
            Array.from(pieCountCard).forEach(card => {
                card.classList.add('loaded');
            });
            const ctxAppointment = document.getElementById('appointmentPieChart').getContext('2d');
            const ctxOrder = document.getElementById('orderPieChart').getContext('2d');
            const appointmentCounts = data.appointmentCount;
            const orderCounts = data.orderCount;

            loadPieChartData(appointmentCounts, ctxAppointment);
            loadPieChartData(orderCounts, ctxOrder);
        })
        .catch(error => {
            loadingIndicator() // hide loading indicator
            console.error('Error fetching counts:', error);
        });
}
const fetchOrderStatusCounts = () => {
    // show loading indicator
    const pieCountCard = document.getElementsByClassName('pieCountCard');
    loadingIndicator(true); // show loading indicator

    fetch(orderStatusRoute)
        .then(response => response.json())
        .then(data => {
            loadingIndicator(); // hide loading indicator
            
            Array.from(pieCountCard).forEach(card => {
                card.classList.add('loaded');
            });

            console.log(data.orderCount);
            
            const ctx = document.getElementById('orderStatusPieChart').getContext('2d');
            const counts = data.orderCount;

            loadPieChartData(counts, ctx);
        })
        .catch(error => {
            loadingIndicator() // hide loading indicator
            console.error('Error fetching counts:', error);
        });
}

function loadPieChartData(counts, canvas){
    const filteredCounts = Object.entries(counts).filter(([key, value]) => value > 0);
    const labels = filteredCounts.map(([key]) => key.replace(/\b\w/g, char => char.toUpperCase()));
    const countsValues = filteredCounts.map(([key, value]) => value);

    const chartData = {
        labels: labels,
        datasets: [{
            data: countsValues,
            backgroundColor: [
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
            ],
            borderWidth: 1
        }]
    };

    new Chart(canvas, {
        type: 'pie',
        data: chartData,
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    },
                    padding: 20,
                    boxWidth: 20,
                },
                datalabels: {
                    color: '#000',
                    font: {
                        weight: 'bold',
                        size: 14
                    },
                    formatter: (value) => value,
                    anchor: 'center',
                    align: 'center',
                }
            },
            tooltip: {
                enabled: true,
                callbacks: {
                    label: function (tooltipItem) {
                        const label = tooltipItem.label || '';
                        const value = tooltipItem.raw || 0;
                        return `${label}: ${value}`;
                    }
                }
            }
        },
        plugins: [ChartDataLabels],
    });
}

function loadingIndicator(isLoading = false) {
    const loadingIndicator = document.getElementsByClassName('loading');
    if (isLoading) {
        Array.from(loadingIndicator).forEach(element => {
            element.style.display = 'block';
        });
    } else {
        Array.from(loadingIndicator).forEach(element => {
            element.style.display = 'none';
        });
    }
}

fetchAppointmentCounts();
fetchOrderStatusCounts();