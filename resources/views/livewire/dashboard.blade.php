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

    <div class="container-fluid py-4">
        <div class="row mb-2">
            <!-- Temperature Card -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow-0 border border-dark border-5 text-dark" style="border-radius: 10px;">
                    <div class="card-body p-3 text-center">
                        <p class="h5 mb-3">🌡️ Température</p>
                        <div class="d-flex justify-content-around align-items-center my-3">
                            <p class="fw-bold mb-0" style="font-size: 4rem;">{{ $latestTemp->temperature }}°C</p>
                            <div class="text-start">
                                <p class="small">{{ \Carbon\Carbon::parse($latestTemp->datetimes)->format('H:i') }}</p>
                                <p class="h6">{{ \Carbon\Carbon::parse($latestTemp->datetimes)->format('l') }}</p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-around flex-wrap">
                            @foreach ($temperatureData as $entry)
                                <div class="border rounded p-2 m-1 text-center" style="min-width: 60px;">
                                    <p class="small mb-1">{{ \Carbon\Carbon::parse($entry->datetimes)->format('H:i') }}
                                    </p>
                                    <p class="small mb-0"><strong>{{ $entry->temperature }}°C</strong></p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Humidity Card -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow-0 border border-dark border-5 text-dark" style="border-radius: 10px;">
                    <div class="card-body p-3 text-center">
                        <p class="h5 mb-3">💧 Humidité</p>
                        <div class="d-flex justify-content-around align-items-center my-3">
                            <p class="fw-bold mb-0" style="font-size: 4rem;">{{ $latestHumidity->humidete }}%</p>
                            <div class="text-start">
                                <p class="small">{{ \Carbon\Carbon::parse($latestHumidity->datetimes)->format('H:i') }}
                                </p>
                                <p class="h6">{{ \Carbon\Carbon::parse($latestHumidity->datetimes)->format('l') }}
                                </p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-around flex-wrap">
                            @foreach ($humidityData as $entry)
                                <div class="border rounded p-2 m-1 text-center" style="min-width: 60px;">
                                    <p class="small mb-1">{{ \Carbon\Carbon::parse($entry->datetimes)->format('H:i') }}
                                    </p>
                                    <p class="small mb-0"><strong>{{ $entry->humidete }}%</strong></p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gas Card -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow-0 border border-dark border-5 text-dark" style="border-radius: 10px;">
                    <div class="card-body p-3 text-center">
                        <p class="h5 mb-3">🫁 Gaz (CO₂)</p>
                        <div class="d-flex justify-content-around align-items-center my-3">
                            <p class="fw-bold mb-0" style="font-size: 4rem;">{{ $latestGas->niveauco2 }} ppm</p>
                            <div class="text-start">
                                <p class="small">{{ \Carbon\Carbon::parse($latestGas->datetimes)->format('H:i') }}</p>
                                <p class="h6">{{ \Carbon\Carbon::parse($latestGas->datetimes)->format('l') }}</p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-around flex-wrap">
                            @foreach ($gasData as $entry)
                                <div class="border rounded p-2 m-1 text-center" style="min-width: 60px;">
                                    <p class="small mb-1">{{ \Carbon\Carbon::parse($entry->datetimes)->format('H:i') }}
                                    </p>
                                    <p class="small mb-0"><strong>{{ $entry->niveauco2 }} ppm</strong></p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row">
            <div class="col-md-6">
                <div class="card custom-chart">
                    <div class="card-body">
                        <h6 class="mb-0">Lectures du capteur de Gaz</h6>
                        <div id="gas-sensor-chart" style="width: 100%; height: 350px;"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card custom-chart">
                    <div class="card-body">
                        <h6 class="mb-0">Lectures du capteur d'Humidité</h6>
                        <div id="humidity-chart" style="width: 100%; height: 350px;"></div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card custom-chart">
                    <div class="card-body">
                        <h6 class="mb-0">Lectures du capteur de Température</h6>
                        <div id="temperature-chart" style="width: 100%; height: 350px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card custom-chart">
    <div class="card-body px-0 pb-2">
        <h6 class="text-center text-sm font-weight-bold pt-3">Accès Acceptés (RFID)</h6>
        <div class="table-responsive p-0" style="max-height: 350px; overflow-y: auto;">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            Numéro de carte</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                            Date d'entrée</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            Access</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            Traité</th>
                        <th class="text-secondary opacity-7"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data->where('access', 'ACCEPTED') as $entry)
                    <tr>
                        <td>
                            <div class="d-flex px-2 py-1">
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">{{ $entry->Numcart }}</h6>
                                </div>
                            </div>
                        </td>
                        <td>
                            <p class="text-xs font-weight-bold mb-0">{{ $entry->date }}</p>
                        </td>
                        <td class="align-middle text-center text-sm">
                            <span class="badge badge-sm bg-gradient-success">
                                Accepté
                            </span>
                        </td>
                        <td class="align-middle text-center">
                            <span class="text-secondary text-xs font-weight-bold">
                                {{ $entry->traite == '1' ? 'Oui' : 'Non' }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                    @if($data->where('access', 'ACCEPTED')->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                            Aucun accès accepté trouvé.
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>



            </div>
        </div>
    </div>

    <!-- Chart Scripts -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
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
</body>

</html>
