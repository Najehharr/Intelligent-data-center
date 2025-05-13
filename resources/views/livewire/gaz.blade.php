<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sensor Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <style>
        body {
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            min-height: 100vh;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 1rem;
            display: block;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .content {
            flex: 1;
            padding: 2rem;
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="p-3">Menu</h4>
        <a href="/dashboard">📊 Dashboard</a>
        <a href="/temperature">🌡️ Temperature</a>
        <a href="/humidity">💧 Humidity</a>
        <a href="/gas">🟢 CO2</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h3>Sensor Dashboard</h3>

        <!-- CO2 Chart -->
        <div class="card mt-4">
            <div class="card-body">
                <h6 class="mb-0">Lectures du capteur de Gaz</h6>
                <div id="gas-sensor-chart" style="width: 100%; height: 350px;"></div>
            </div>
        </div>

        <!-- Humidity Chart -->
        <div class="card mt-4">
            <div class="card-body">
                <h6 class="mb-0">Lectures du capteur d'Humidité</h6>
                <div id="humidity-chart" style="width: 100%; height: 350px;"></div>
            </div>
        </div>

        <!-- Temperature Chart -->
        <div class="card mt-4">
            <div class="card-body">
                <h6 class="mb-0">Lectures du capteur de Température</h6>
                <div id="temperature-chart" style="width: 100%; height: 350px;"></div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const temperatureChart = new ApexCharts(document.querySelector("#temperature-chart"), {
                chart: { height: 350, type: 'line', toolbar: { show: false } },
                colors: ['#77B6EA'],
                stroke: { curve: 'smooth' },
                dataLabels: { enabled: true },
                xaxis: { type: 'datetime', title: { text: 'Temps' } },
                yaxis: { title: { text: 'Température (°C)' }, min: 0, max: 50 },
                series: [{ name: "Température", data: [] }]
            });
            temperatureChart.render();
            fetch("/chart-data/temperature")
                .then(res => res.json())
                .then(data => temperatureChart.updateSeries([{ name: "Température", data }]));

            const humidityChart = new ApexCharts(document.querySelector("#humidity-chart"), {
                chart: { height: 350, type: 'line' },
                xaxis: { type: 'datetime', title: { text: 'Temps' } },
                yaxis: { title: { text: 'Humidité (%)' }, min: 0, max: 100 },
                series: [{ name: "Humidité", data: [] }]
            });
            humidityChart.render();
            fetch("/chart-data/humidity")
                .then(res => res.json())
                .then(data => humidityChart.updateSeries([{ name: "Humidité", data }]));

            const gasChart = new ApexCharts(document.querySelector("#gas-sensor-chart"), {
                chart: { height: 350, type: 'line' },
                xaxis: { type: 'datetime', title: { text: 'Temps' } },
                yaxis: { title: { text: 'Niveau CO2 (ppm)' }, min: 0, max: 1000 },
                series: [{ name: "CO2", data: [] }]
            });
            gasChart.render();
            fetch("/chart-data/gas")
                .then(res => res.json())
                .then(data => gasChart.updateSeries([{ name: "CO2", data }]));
        });
    </script>
</body>

</html>
