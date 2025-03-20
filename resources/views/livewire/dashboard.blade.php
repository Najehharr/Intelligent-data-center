<div>
    <!-- Navbar -->
    <!-- End Navbar -->
    <div class="container-fluid py-4">





        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar (Assuming You Have a Sidebar Here) -->


                <!-- Main Content -->
                <div class="col-md-10 col-lg-10">
                    <div class="card mt-4">
                        <div class="card-body">
                            <h6 class="mb-0">Gas Sensor Readings</h6>
                            <p class="text-sm">Latest Air Quality Data</p>
                            <hr class="dark horizontal">

                            <!-- Chart Container -->
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
                            <h6 class="mb-0">Température moyenne haute et basse</h6>
                            <p class="text-sm">Données de température</p>
                            <hr class="dark horizontal">
                            <div id="temperature-chart" style="width: 100%; height: 350px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <br><br>





    </div>
    @push('js')
    @push('js')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var options = {
            chart: {
                height: 350,
                type: "line",
                dropShadow: {
                    enabled: true,
                    color: "#000",
                    top: 18,
                    left: 7,
                    blur: 10,
                    opacity: 0.5,
                },
                zoom: { enabled: false },
                toolbar: { show: false },
            },
            colors: ["#77B6EA", "#545454"],
            dataLabels: { enabled: true },
            stroke: { curve: "smooth" },
            title: { text: "Température moyenne haute et basse", align: "left" },
            grid: {
                borderColor: "#e7e7e7",
                row: { colors: ["#f3f3f3", "transparent"], opacity: 0.5 },
            },
            markers: { size: 1 },
            xaxis: {
                categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
                title: { text: "Mois" },
            },
            yaxis: {
                title: { text: "Température" },
                min: 5,
                max: 40,
            },
            legend: {
                position: "top",
                horizontalAlign: "right",
                floating: true,
                offsetY: -25,
                offsetX: -5,
            },
            series: [
                {
                    name: "Haut - 2013",
                    data: [28, 29, 33, 36, 32, 32, 33],
                },
                {
                    name: "Faible - 2013",
                    data: [12, 11, 14, 18, 17, 13, 13],
                },
            ],
        };

        new ApexCharts(document.querySelector("#temperature-chart"), options).render();
    });
</script>
@endpush
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                function generateDayWiseTimeSeries(baseTimestamp, count, range) {
                    let series = [];
                    let timestamp = baseTimestamp;

                    for (let i = 0; i < count; i++) {
                        let value = Math.floor(Math.random() * (range.max - range.min + 1)) + range.min;
                        series.push([timestamp, value]);
                        timestamp += 86400000; // Move forward by one day
                    }

                    return series;
                }

                var options = {
                    chart: {
                        type: "area",
                        height: 350,
                        stacked: true,
                    },
                    colors: ["#00E396"],
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: "smooth"
                    },
                    fill: {
                        type: "gradient",
                        gradient: {
                            opacityFrom: 0.6,
                            opacityTo: 0.8
                        }
                    },
                    legend: {
                        position: "top",
                        horizontalAlign: "left"
                    },
                    xaxis: {
                        type: "datetime"
                    },
                    series: [{
                        name: "Humidity",
                        data: generateDayWiseTimeSeries(new Date("11 Feb 2017 GMT").getTime(), 20, {
                            min: 40,
                            max: 90
                        })
                    }]
                };

                new ApexCharts(document.querySelector("#humidity-chart"), options).render();
            });
        </script>
    @endpush

    @push('js')
        <script src="{{ asset('assets') }}/js/plugins/chartjs.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var options = {
                    chart: {
                        type: "line",
                        height: "100%",
                        width: "100%",
                        zoom: {
                            enabled: false
                        },
                        toolbar: {
                            show: false
                        }
                    },
                    colors: ["#77B6EA", "#545454"],
                    dataLabels: {
                        enabled: true
                    },
                    stroke: {
                        curve: "smooth"
                    },
                    title: {
                        text: "Gas Sensor Data",
                        align: "left"
                    },
                    grid: {
                        borderColor: "#e7e7e7"
                    },
                    markers: {
                        size: 1
                    },
                    xaxis: {
                        categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
                        title: {
                            text: "Months"
                        }
                    },
                    yaxis: {
                        title: {
                            text: "PPM"
                        },
                        min: 5,
                        max: 40
                    },
                    series: [{
                            name: "High - 2023",
                            data: [28, 29, 33, 36, 32, 32, 33]
                        },
                        {
                            name: "Low - 2023",
                            data: [12, 11, 14, 18, 17, 13, 13]
                        }
                    ],
                    responsive: [{
                        breakpoint: 768,
                        options: {
                            chart: {
                                height: 400
                            }
                        }
                    }]
                };

                var chart = new ApexCharts(document.querySelector("#gas-sensor-chart"), options);
                chart.render();

                // Function to fetch the latest data
                function fetchLatestData() {
                    fetch('/api/get-latest-gas-level')
                        .then(response => response.json())
                        .then(data => {
                            const latestValue = data.latestValue;
                            // Update the chart with the new data
                            chart.updateSeries([{
                                name: "High - 2023",
                                data: [...chart.w.globals.series[0],
                                    latestValue
                                ] // Append the latest value
                            }]);
                        })
                        .catch(error => console.error('Error fetching data:', error));
                }

                // Poll the data every 5 seconds
                setInterval(fetchLatestData, 5000);
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            var ctx = document.getElementById("chart-bars").getContext("2d");

            new Chart(ctx, {
                type: "bar",
                data: {
                    labels: ["M", "T", "W", "T", "F", "S", "S"],
                    datasets: [{
                        label: "Sales",
                        tension: 0.4,
                        borderWidth: 0,
                        borderRadius: 4,
                        borderSkipped: false,
                        backgroundColor: "rgba(255, 255, 255, .8)",
                        data: [50, 20, 10, 22, 50, 10, 40],
                        maxBarThickness: 6
                    }, ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    scales: {
                        y: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5],
                                color: 'rgba(255, 255, 255, .2)'
                            },
                            ticks: {
                                suggestedMin: 0,
                                suggestedMax: 500,
                                beginAtZero: true,
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                                color: "#fff"
                            },
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5],
                                color: 'rgba(255, 255, 255, .2)'
                            },
                            ticks: {
                                display: true,
                                color: '#f8f9fa',
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                            }
                        },
                    },
                },
            });


            var ctx2 = document.getElementById("chart-line").getContext("2d");

            new Chart(ctx2, {
                type: "line",
                data: {
                    labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    datasets: [{
                        label: "Mobile apps",
                        tension: 0,
                        borderWidth: 0,
                        pointRadius: 5,
                        pointBackgroundColor: "rgba(255, 255, 255, .8)",
                        pointBorderColor: "transparent",
                        borderColor: "rgba(255, 255, 255, .8)",
                        borderColor: "rgba(255, 255, 255, .8)",
                        borderWidth: 4,
                        backgroundColor: "transparent",
                        fill: true,
                        data: [50, 40, 300, 320, 500, 350, 200, 230, 500],
                        maxBarThickness: 6

                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    scales: {
                        y: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5],
                                color: 'rgba(255, 255, 255, .2)'
                            },
                            ticks: {
                                display: true,
                                color: '#f8f9fa',
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                            }
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                display: false,
                                drawOnChartArea: false,
                                drawTicks: false,
                                borderDash: [5, 5]
                            },
                            ticks: {
                                display: true,
                                color: '#f8f9fa',
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                            }
                        },
                    },
                },
            });

            var ctx3 = document.getElementById("chart-line-tasks").getContext("2d");

            new Chart(ctx3, {
                type: "line",
                data: {
                    labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    datasets: [{
                        label: "Mobile apps",
                        tension: 0,
                        borderWidth: 0,
                        pointRadius: 5,
                        pointBackgroundColor: "rgba(255, 255, 255, .8)",
                        pointBorderColor: "transparent",
                        borderColor: "rgba(255, 255, 255, .8)",
                        borderWidth: 4,
                        backgroundColor: "transparent",
                        fill: true,
                        data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
                        maxBarThickness: 6

                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    scales: {
                        y: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5],
                                color: 'rgba(255, 255, 255, .2)'
                            },
                            ticks: {
                                display: true,
                                padding: 10,
                                color: '#f8f9fa',
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                            }
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                display: false,
                                drawOnChartArea: false,
                                drawTicks: false,
                                borderDash: [5, 5]
                            },
                            ticks: {
                                display: true,
                                color: '#f8f9fa',
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                            }
                        },
                    },
                },
            });
        </script>
        <canvas id="chart-bars"></canvas>
        <canvas id="chart-line"></canvas>
        <canvas id="chart-line-tasks"></canvas>
    @endpush
