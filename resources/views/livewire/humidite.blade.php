    @extends('layouts.base')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sensor Dashboard</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/soft-ui-dashboard.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>

<body>
    @php
        use App\Models\Status;
        use Carbon\Carbon;

        $temperatureData = Status::orderBy('datetimes', 'desc')
            ->limit(3)
            ->get(['temperature', 'datetimes']);
        $humidityData = Status::orderBy('datetimes', 'desc')
            ->limit(3)
            ->get(['humidete', 'datetimes']);
        $gasData = Status::orderBy('datetimes', 'desc')
            ->limit(3)
            ->get(['niveauco2', 'datetimes']);

        $latestTemp = $temperatureData->first();
        $latestHumidity = $humidityData->first();
        $latestGas = $gasData->first();
    @endphp





<!-- Humidity Card -->


<!-- Humidity Chart -->
<div class="col-md-6">
    <div class="card custom-chart">
        <div class="card-body">
            <h6 class="mb-0">Lectures du capteur d'Humidité</h6>
            <div id="humidity-chart" style="width: 100%; height: 350px;"></div>
        </div>
    </div>
</div>

<!-- Chart Scripts -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Humidity Chart
        fetch('/chart-data/humidity')
            .then(response => response.json())
            .then(data => {
                const humidityChart = new ApexCharts(document.querySelector("#humidity-chart"), {
                    chart: {
                        type: 'area',
                        height: 350,
                        stacked: true,
                    },
                    colors: ['#00C9A7'],
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'monotoneCubic'
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            opacityFrom: 0.6,
                            opacityTo: 0.8
                        }
                    },
                    legend: {
                        position: 'top',
                        horizontalAlign: 'left'
                    },
                    xaxis: {
                        type: 'datetime',
                        labels: {
                            datetimeUTC: false
                        }
                    },
                    series: [{
                        name: 'Humidité',
                        data
                    }]
                });
                humidityChart.render();
            });

        // Temperature Chart
        const temperatureChart = new ApexCharts(document.querySelector("#temperature-chart"), {
            chart: {
                type: 'line',
                height: 350
            },
            colors: ['#77B6EA'],
            dataLabels: {
                enabled: true
            },
            stroke: {
                curve: 'smooth'
            },
            xaxis: {
                type: 'datetime',
                title: {
                    text: 'Temps'
                }
            },
            yaxis: {
                title: {
                    text: 'Température (°C)'
                },
                min: 0,
                max: 50
            },
            series: [{
                name: "Température",
                data: []
            }]
        });
        temperatureChart.render();

        fetch("/chart-data/temperature")
            .then(res => res.json())
            .then(data => temperatureChart.updateSeries([{
                name: "Température",
                data
            }]));

        // Gas Chart
        const gasChart = new ApexCharts(document.querySelector("#gas-sensor-chart"), {
            chart: {
                type: 'line',
                height: 350
            },
            colors: ['#FF5733'],
            dataLabels: {
                enabled: true
            },
            stroke: {
                curve: 'smooth'
            },
            xaxis: {
                type: 'datetime',
                title: {
                    text: 'Temps'
                }
            },
            yaxis: {
                title: {
                    text: 'Niveau CO₂ (ppm)'
                },
                min: 0,
                max: 1000
            },
            series: [{
                name: "CO₂",
                data: []
            }]
        });
        gasChart.render();

        fetch("/chart-data/gas")
            .then(res => res.json())
            .then(data => gasChart.updateSeries([{
                name: "CO₂",
                data
            }]));
    });
</script>
