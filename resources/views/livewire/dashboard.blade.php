<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sensor Dashboard</title>

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/soft-ui-dashboard.css" rel="stylesheet" />




    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>

<body>

    <div class="container-fluid py-4">
        <div class="row">

            <!-- Temperature Card -->
            <div class="col-md-4">
                <section class="vh-100">
                    <div class="card shadow-0 border border-dark border-5 text-dark" style="border-radius: 10px;">
                        <div class="card-body p-4 text-center">
                            <div class="d-flex justify-content-around mt-3">
                                <p class="h3 mb-3">🌡️ Temperature</p>
                            </div>
                            <div class="d-flex justify-content-around align-items-center py-5 my-4">
                                <p class="fw-bold mb-0" style="font-size: 7rem;">-4°C</p>
                                <div class="text-start">
                                    <p class="small">10:00</p>
                                    <p class="h3 mb-3">Sunday</p>
                                    <p class="small mb-0">Cloudy</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-around align-items-center mb-3">
                                <div class="flex-column"><i class="fas fa-minus"></i></div>
                                @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                                    <div class="flex-column border" style="border-radius: 10px; padding: .75rem;">
                                        <p class="small mb-1">{{ $day }}</p>
                                        <p class="small mb-0"><strong>-4°C</strong></p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Humidity Card -->
            <div class="col-md-4">
                <section class="vh-100">
                    <div class="card shadow-0 border border-dark border-5 text-dark" style="border-radius: 10px;">
                        <div class="card-body p-4 text-center">
                            <div class="d-flex justify-content-around mt-3">
                                <p class="h3 mb-3">💧 Humidite</p>
                            </div>
                            <div class="d-flex justify-content-around align-items-center py-5 my-4">
                                <p class="fw-bold mb-0" style="font-size: 7rem;">-4°C</p>
                                <div class="text-start">
                                    <p class="small">10:00</p>
                                    <p class="h3 mb-3">Sunday</p>
                                    <p class="small mb-0">Cloudy</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-around align-items-center mb-3">
                                <div class="flex-column"><i class="fas fa-minus"></i></div>
                                @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                                    <div class="flex-column border" style="border-radius: 10px; padding: .75rem;">
                                        <p class="small mb-1">{{ $day }}</p>
                                        <p class="small mb-0"><strong>-4°C</strong></p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Gas Card -->
            <div class="col-md-4">
                <section class="vh-100">
                    <div class="card shadow-0 border border-dark border-5 text-dark" style="border-radius: 10px;">
                        <div class="card-body p-4 text-center">
                            <div class="d-flex justify-content-around mt-3">
                                <p class="h3 mb-3">🫁 Gaz</p>
                            </div>
                            <div class="d-flex justify-content-around align-items-center py-5 my-4">
                                <p class="fw-bold mb-0" style="font-size: 7rem;">-4°C</p>
                                <div class="text-start">
                                    <p class="small">10:00</p>
                                    <p class="h3 mb-3">Sunday</p>
                                    <p class="small mb-0">Cloudy</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-around align-items-center mb-3">
                                <div class="flex-column"><i class="fas fa-minus"></i></div>
                                @foreach (['Sun', 'Mon', 'Tue'] as $day)
                                    <div class="flex-column border" style="border-radius: 10px; padding: .75rem;">
                                        <p class="small mb-1">{{ $day }}</p>
                                        <p class="small mb-0"><strong>-4°C</strong></p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>
            </div>

        </div>
        <div class="container-fluid py-4">
            <div class="row">
                <!-- CO2 Chart -->
                <div class="col-md-4">
                    <div class="card mt-4">
                        <div class="card-body">
                            <h6 class="mb-0">Lectures du capteur de Gaz</h6>
                            <div id="gas-sensor-chart" style="width: 100%; height: 350px;"></div>
                        </div>
                    </div>
                </div>

                <!-- Humidity Chart -->
                <div class="col-md-4">
                    <div class="card mt-4">
                        <div class="card-body">
                            <h6 class="mb-0">Lectures du capteur d'Humidité</h6>
                            <div id="humidity-chart" style="width: 100%; height: 350px;"></div>
                        </div>
                    </div>
                </div>

                <!-- Temperature Chart -->
                <div class="col-md-4">
                    <div class="card mt-4">
                        <div class="card-body">
                            <h6 class="mb-0">Lectures du capteur de Température</h6>
                            <div id="temperature-chart" style="width: 100%; height: 350px;"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>





    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Temperature Chart
            const temperatureChart = new ApexCharts(document.querySelector("#temperature-chart"), {
                chart: {
                    height: 350,
                    type: 'line',
                    dropShadow: {
                        enabled: true,
                        color: '#000',
                        top: 18,
                        left: 7,
                        blur: 10,
                        opacity: 0.2
                    },
                    zoom: {
                        enabled: false
                    },
                    toolbar: {
                        show: false
                    }
                },
                colors: ['#77B6EA'],
                dataLabels: {
                    enabled: true
                },
                stroke: {
                    curve: 'smooth'
                },
                grid: {
                    borderColor: '#e7e7e7',
                    row: {
                        colors: ['#f3f3f3', 'transparent'],
                        opacity: 0.5
                    }
                },
                markers: {
                    size: 3
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
                    data: [] // will be populated by fetch
                }]
            });

            temperatureChart.render();

            fetch("/chart-data/temperature")
                .then(res => res.json())
                .then(data => {
                    console.log("Temperature data:", data); // Debugging output
                    temperatureChart.updateSeries([{
                        name: "Température",
                        data: data
                    }]);
                })
                .catch(err => console.error("Failed to load temperature data", err));

            // Humidity Chart
            const humidityChart = new ApexCharts(document.querySelector("#humidity-chart"), {
                chart: {
                    height: 350,
                    type: 'line'
                },
                series: [{
                    name: "Humidité",
                    data: []
                }],
                xaxis: {
                    type: 'datetime',
                    title: {
                        text: 'Temps'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Humidité (%)'
                    },
                    min: 0,
                    max: 100
                }
            });

            humidityChart.render();

            fetch("/chart-data/humidity")
                .then(res => res.json())
                .then(data => {
                    humidityChart.updateSeries([{
                        name: "Humidité",
                        data: data
                    }]);
                });

            // Gas Chart
            const gasChart = new ApexCharts(document.querySelector("#gas-sensor-chart"), {
                chart: {
                    height: 350,
                    type: 'line'
                },
                series: [{
                    name: "CO2",
                    data: []
                }],
                xaxis: {
                    type: 'datetime',
                    title: {
                        text: 'Temps'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Niveau CO2 (ppm)'
                    },
                    min: 0,
                    max: 1000
                }
            });

            gasChart.render();

            fetch("/chart-data/gas")
                .then(res => res.json())
                .then(data => {
                    gasChart.updateSeries([{
                        name: "CO2",
                        data: data
                    }]);
                });
        });
    </script>
</body>

</html>
