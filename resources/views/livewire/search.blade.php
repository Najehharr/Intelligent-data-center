<x-layouts.app>
<div class="">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                            <h6 class="text-black text-capitalize ps-3">Gestion d'accès avec carte RFID</h6>

                            <!-- Search Form -->
                            <form action="{{ route('rfid.search') }}" method="GET" class="d-flex align-items-center pe-3">
                                <input type="date" name="date" class="form-control form-control-sm me-2" required>
                                <button type="submit" class="btn btn-sm btn-primary">Rechercher</button>
                            </form>
                        </div>
                    </div>

                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
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
                                    @foreach($data as $entry)
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
                                            <span class="badge badge-sm {{ $entry->access == 'ACCEPTED' ? 'bg-gradient-success' : 'bg-gradient-danger' }}">
                                                {{ $entry->access == 'ACCEPTED' ? 'Accepté' : 'Refusé' }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $entry->traite == '1' ? 'Oui' : 'Non' }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @if($data->isEmpty())
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            Aucune donnée RFID trouvée.
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
</div>
</x-layouts.app>
