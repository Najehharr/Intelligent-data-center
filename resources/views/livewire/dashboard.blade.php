<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sensor Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            direction: ltr; /* Ensuring left-to-right display */
            text-align: left;
        }
    </style>
</head>
<body>

    <div class="container-fluid py-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Main Content -->
                <div class="col-md-10 col-lg-10">
                    <div class="card mt-4">
                        <div class="card-body">
                            <h6 class="mb-0">Gas Sensor Readings</h6>
                            <p class="text-sm">Latest Air Quality Data</p>
                            <hr class="dark horizontal">
                            <div id="gas-sensor-chart" style="width: 100%; height: 500px;"></div>
                            <div class="d-flex">
                                <i class="material-icons text-sm my-auto me-1">schedule</i>
                                <p class="mb-0 text-sm">Last measurement taken 2 minutes ago</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-10 col-lg-10">
                    <div class="card mt-4">
                        <div class="card-body">
                            <h6 class="mb-0">Humidity Levels</h6>
                            <p class="text-sm">Latest Humidity Data</p>
                            <hr class="dark horizontal">
                            <div id="humidity-chart" style="width: 100%; height: 350px;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-10 col-lg-10">
                    <div class="card mt-4">
                        <div class="card-body">
                            <h6 class="mb-0">Température Moyenne Haute et Basse</h6>
                            <p class="text-sm">Données de Température</p>
                            <hr class="dark horizontal">
                            <div id="temperature-chart" style="width: 100%; height: 350px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
    // Temperature Chart
    var tempOptions = {
        chart: { height: 350, type: "line", toolbar: { show: false } },
        colors: ["#77B6EA", "#545454"],
        dataLabels: { enabled: true },
        stroke: { curve: "smooth" },
        title: { text: "Température Moyenne Haute et Basse", align: "left" },
        grid: { borderColor: "#e7e7e7" },
        xaxis: { categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"], title: { text: "Mois" } },
        yaxis: { title: { text: "Température" }, min: 5, max: 40 },
        series: [
            { name: "Haut - 2013", data: [28, 29, 33, 36, 32, 32, 33] },
            { name: "Faible - 2013", data: [12, 11, 14, 18, 17, 13, 13] }
        ]
    };
    new ApexCharts(document.querySelector("#temperature-chart"), tempOptions).render();

    // Humidity Chart
    var humidityChartOptions = {
        chart: { type: "area", height: 350 },
        colors: ["#00E396"],
        dataLabels: { enabled: false },
        stroke: { curve: "smooth" },
        xaxis: { type: "datetime" },
        series: [{ name: "Humidity", data: [] }] // Initially empty
    };

    var humidityChart = new ApexCharts(document.querySelector("#humidity-chart"), humidityChartOptions);
    humidityChart.render();

    // Fetch Humidity Data from ESP32
    function fetchHumidityData() {
        fetch('/api/get-latest-humidity')
            .then(response => response.json())
            .then(data => {
                if (!data || !data.humidity) return; // Ensure data is valid

                const timestamp = new Date().getTime();
                const humidityValue = data.humidity;

                // Append new data point
                let updatedData = humidityChart.w.globals.series[0].data;
                updatedData.push([timestamp, humidityValue]);

                // Keep last 20 entries for smooth display
                if (updatedData.length > 20) {
                    updatedData.shift();
                }

                // Update the chart
                humidityChart.updateSeries([{ name: "Humidity", data: updatedData }]);
            })
            .catch(error => console.error('Error fetching humidity data:', error));
    }

    // Fetch new humidity data every 5 seconds
    setInterval(fetchHumidityData, 5000);
});

    </script>
    @endpush

</body>
</html>
