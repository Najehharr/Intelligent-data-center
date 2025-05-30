@php
    use App\Models\Status;
    use Carbon\Carbon;

    $temperatureThreshold = 10; // °C
    $humidityThreshold = 90; // %
    $co2Threshold = 700; // ppm

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

<div class="row">
    {{-- Temperature Card --}}
    <div class="col-12 mb-4">
        <div class="card bg-transparent shadow-none text-dark" style="border-radius: 10px;">
            <div class="card-body p-3 text-center">
                

                @if ($latestTemp->temperature > $temperatureThreshold)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        🔥 <strong>Attention !</strong> Température élevée détectée ({{ $latestTemp->temperature }}°C).
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Humidity Card --}}
    <div class="col-12 mb-4">
        <div class="card bg-transparent shadow-none text-dark" style="border-radius: 10px;">
            <div class="card-body p-3 text-center">


                @if ((float)$latestHumidity->humidete > $humidityThreshold)
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        💦 <strong>Humidité élevée !</strong> ({{ $latestHumidity->humidete }}%)
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- CO2 Gas Card --}}
    <div class="col-12 mb-4">
        <div class="card bg-transparent shadow-none text-dark" style="border-radius: 10px;">
            <div class="card-body p-3 text-center">


                @if ($latestGas->niveauco2 > $co2Threshold)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        🚨 <strong>Alerte !</strong> Niveau de CO₂ élevé détecté ({{ $latestGas->niveauco2 }} ppm).
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
