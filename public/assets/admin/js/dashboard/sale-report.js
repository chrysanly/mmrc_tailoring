
const saleReportRoute = "/admin/dashboard/api/sales-report";
let currentStartDate = moment().startOf('week').add(1, 'day'); // Start of the week (Monday)
let currentEndDate = moment().endOf('week').add(1, 'day'); // End of the week (Sunday)
let year = $("#year").val();
let startofWeek = currentStartDate.format('YYYY-MM-DD');
let endofWeek = currentEndDate.format('YYYY-MM-DD');
let currentRangeType = $("#rangeType").val();
let chartLabel = [];
let chartData = [];

const ctx = document.getElementById('lineChart').getContext('2d');

const fetchSaleReport = () => {
    // show loading indicator
    // const pieCountCard = document.getElementsByClassName('pieCountCard');
    // loadingIndicator(true); // show loading indicator
    chartLabel = [];
    chartData = [];

    fetch(saleReportRoute + `?rangeType=${currentRangeType}&year=${year}&startofWeek=${startofWeek}&endofWeek=${endofWeek}`)
        .then(response => response.json())
        .then(data => {
            chartLabel = data.labels;
            chartData = data.data;
            fetchChartData();
        })
        .catch(error => {
            console.error('Error fetching counts:', error);
        });
}






// Initialize the chart
let myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [], // Start with empty labels
        datasets: [{
            label: 'Sales Report',
            data: [], // Start with empty data
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false,
            },
            tooltip: {
                enabled: true
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});



currentDate = moment(); // Current date

// Function to fetch and update chart data
function fetchChartData() {
    const year = document.getElementById('year').value;

    if (currentRangeType === 'weekly') {
        myLineChart.data.labels = chartLabel; // Example weekly labels
        myLineChart.data.datasets[0].data = chartData; // Example weekly data
        myLineChart.data.datasets[0].label = chartLabel;
    } else if (currentRangeType === 'monthly') {
        startofWeek = currentStartDate.startOf('month').format('YYYY-MM-DD');
        endofWeek = currentEndDate.endOf('month').format('YYYY-MM-DD');
        myLineChart.data.labels = chartLabel; // Example weekly labels
        myLineChart.data.datasets[0].data = chartData; // Example weekly data
        myLineChart.data.datasets[0].label = chartLabel;
    } else if (currentRangeType === 'today') {
        myLineChart.data.labels = chartLabel; // Example weekly labels
        myLineChart.data.datasets[0].data = chartData; // Example weekly data
        myLineChart.data.datasets[0].label = chartLabel;
    }

    myLineChart.update();
}

// Function to update the displayed range text
function updateRangeText() {
    const rangeText = document.getElementById('rangeText');

    if (currentRangeType === 'weekly') {
        rangeText.innerText = `${currentStartDate.format('MMMM D')} - ${currentEndDate.format('MMMM D')}`;
    } else if (currentRangeType === 'monthly') {
        rangeText.innerText = currentStartDate.format('MMMM YYYY');
    } else if (currentRangeType === 'today') {
        rangeText.innerText = currentStartDate.format('MMMM D, YYYY');
    }
}

// Previous and Next navigation buttons for weekly and monthly ranges
document.getElementById('prevRangeBtn').addEventListener('click', () => {
    if (currentRangeType === 'weekly') {
        currentStartDate.subtract(1, 'week');
        currentEndDate.subtract(1, 'week');

        
    } else if (currentRangeType === 'monthly') {
        currentStartDate.subtract(1, 'month');
        currentEndDate.subtract(1, 'month');
    }

    startofWeek = currentStartDate.format('YYYY-MM-DD');
    endofWeek = currentEndDate.format('YYYY-MM-DD');

    updateRangeText();
    fetchSaleReport();
});

document.getElementById('nextRangeBtn').addEventListener('click', () => {
    if (currentRangeType === 'weekly') {
        currentStartDate.add(1, 'week');
        currentEndDate.add(1, 'week');
    } else if (currentRangeType === 'monthly') {
        currentStartDate.add(1, 'month');
        currentEndDate.add(1, 'month');
    }

    startofWeek = currentStartDate.format('YYYY-MM-DD');
    endofWeek = currentEndDate.format('YYYY-MM-DD');

    updateRangeText();
    fetchSaleReport();
});


// Function to update the range type and toggle UI elements
function updateChartRange() {
    const rangeType = document.getElementById('rangeType').value;
    const prevBtn = document.getElementById('prevRangeBtn');
    const nextBtn = document.getElementById('nextRangeBtn');
    const rangeText = document.getElementById('rangeText');
    const dateRangeContainer = document.getElementById('dateRangeContainer');

    currentRangeType = rangeType;

    if (rangeType === 'weekly') {
        // Show week navigation buttons and hide the date range picker
        prevBtn.style.display = 'inline-block';
        nextBtn.style.display = 'inline-block';
        rangeText.style.display = 'inline-block';
        dateRangeContainer.style.display = 'none';
        currentStartDate = moment().startOf('week').add(1, 'day'); // Reset to this week's Monday
        currentEndDate = moment().endOf('week').add(1, 'day'); // Reset to this week's Sunday
      
    } else if (rangeType === 'monthly') {
        // Hide week navigation buttons and show the date range picker
        prevBtn.style.display = 'none';
        nextBtn.style.display = 'none';
        rangeText.style.display = 'none';
        dateRangeContainer.style.display = 'block';

        setupMonthlyDateRangePicker(); // Set up the date range picker limited to one month
    } else if (rangeType === 'today') {
        // Hide week navigation buttons and date range picker
        prevBtn.style.display = 'none';
        nextBtn.style.display = 'none';
        rangeText.style.display = 'inline-block';
        dateRangeContainer.style.display = 'none';

        currentStartDate = moment(); // Today's date
        currentEndDate = moment(); // Same as start for a single day
    }

    updateRangeText();
    fetchSaleReport(); // Fetch data for the selected range type
}

// Function to set up the date range picker for monthly selection
function setupMonthlyDateRangePicker() {
    $('#dateRangePicker').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        },
        minDate: moment().startOf('year'), // Minimum allowed date (start of the year)
        maxDate: moment().endOf('year'), // Maximum allowed date (end of the year)
        autoApply: true, // Automatically apply the range
        singleDatePicker: false, // Allow range selection
        opens: 'center', // Position the picker
        isInvalidDate: function (date) {
            // Prevent selection that spans multiple months
            const startOfMonth = date.clone().startOf('month');
            const endOfMonth = date.clone().endOf('month');
            return (
                !date.isSameOrAfter(startOfMonth, 'day') ||
                !date.isSameOrBefore(endOfMonth, 'day')
            );
        }
    }).on('apply.daterangepicker', function (ev, picker) {
        currentStartDate = moment(picker.startDate);
        currentEndDate = moment(picker.endDate);
        startofWeek = currentStartDate.format('YYYY-MM-DD');
        endofWeek = currentEndDate.format('YYYY-MM-DD');
        fetchSaleReport(); // Fetch data for the selected date range
    });
}

function updateYearRange() {
    // Get the selected year from the dropdown
    const selectedYear = document.getElementById('year').value;

    year = selectedYear;
    // Update the date range picker (if applicable)
    $('#dateRangePicker').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        },
        startDate: `${selectedYear}-01-01`, // Start of the selected year
        endDate: `${selectedYear}-12-31`,  // End of the selected year
        minDate: `${selectedYear}-01-01`,
        maxDate: `${selectedYear}-12-31`,
        autoUpdateInput: false,
        showDropdowns: true
    });

    // Optionally, trigger data reload or other updates
    fetchSaleReport(); // Reload the report data for the selected year
}


fetchSaleReport();
updateRangeText();
