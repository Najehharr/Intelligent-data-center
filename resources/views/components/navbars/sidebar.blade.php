<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3"
    style="background: linear-gradient(180deg, #004687, #004687);" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0 d-flex text-wrap align-items-center" href="{{ route('dashboard') }}">
            <img src="{{ asset('assets') }}/img/logo-ct.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-2 font-weight-bold text-white">Hopital de Sfax</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse w-auto max-height-vh-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">

            {{-- Show only to agents --}}
            @auth
                @if (Auth::user()->role === 'Agent')
                    {{-- User Management --}}
                    <li class="nav-item">
                        <a class="nav-link text-white {{ Route::currentRouteName() == 'user-management' ? 'active' : '' }}"
                            href="{{ route('user-management') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i style="font-size: 1rem;" class="fas fa-lg fa-list-ul ps-2 pe-2 text-center"></i>
                            </div>
                            <span class="nav-link-text ms-1">Gestion Des Utilisateurs</span>
                        </a>
                    </li>
                @endif
            @endauth

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Pages</h6>
            </li>

            {{-- Dashboard --}}
            <li class="nav-item">
                <a class="nav-link text-white {{ Route::currentRouteName() == 'dashboard' ? 'active bg-gradient-primary' : '' }}"
                    href="{{ route('dashboard') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            {{-- Temperature --}}
            <li class="nav-item">
                <a class="nav-link text-white {{ Route::currentRouteName() == 'temperature' ? 'active' : '' }}"
                    href="{{ route('temperature') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">🌡️</i>
                    </div>
                    <span class="nav-link-text ms-1">Temperature</span>
                </a>
            </li>

            {{-- Humidite --}}
            <li class="nav-item">
                <a class="nav-link text-white {{ Route::currentRouteName() == 'humidite' ? 'active' : '' }}"
                    href="{{ route('humidite') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">💧</i>
                    </div>
                    <span class="nav-link-text ms-1">Humidite</span>
                </a>
            </li>

            {{-- Gaz --}}
            <li class="nav-item">
                <a class="nav-link text-white {{ Route::currentRouteName() == 'gaz' ? 'active' : '' }}"
                    href="{{ route('gaz') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">🫁</i>
                    </div>
                    <span class="nav-link-text ms-1">Gaz</span>
                </a>
            </li>

            {{-- Tables and Accès: Agent Only --}}
            @auth
                @if (Auth::user()->role === 'Agent')
                    {{-- Acces --}}
                    <li class="nav-item">
                        <a class="nav-link text-white {{ Route::currentRouteName() == 'tables' ? 'active' : '' }}"
                            href="{{ route('tables') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">🔐</i>
                            </div>
                            <span class="nav-link-text ms-1">Accès</span>
                        </a>
                    </li>

                    {{-- Gestion d'accès --}}
                    <li class="nav-item">
                        <a class="nav-link text-white {{ Route::currentRouteName() == 'rfid.search' ? 'active' : '' }}"
                            href="{{ route('rfid.search') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">table_view</i>
                            </div>
                            <span class="nav-link-text ms-1">Gestion d'accès</span>
                        </a>
                    </li>
                @endif
            @endauth

            {{-- Notifications --}}
            <li class="nav-item">
                <a class="nav-link text-white {{ Route::currentRouteName() == 'notifications' ? 'active' : '' }}"
                    href="{{ route('notifications') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">notifications</i>
                    </div>
                    <span class="nav-link-text ms-1">Notifications</span>
                </a>
            </li>

        </ul>
    </div>
</aside>
