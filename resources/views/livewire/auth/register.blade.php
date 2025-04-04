

        <main class="main-content  mt-0">
            <section>
                <div class="page-header min-vh-100">
                    <div class="container">
                        <div class="row">
                            <div
                                class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
                                <img src="{{ asset('assets/img/logos/hopital/Hopital.jpg') }}" alt="Hospital Image" width="250">
                            </div>
                            <div
                                class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
                                <div class="card card-plain">
                                    <div class="card-header">
                                        <h4 class="font-weight-bolder">S'inscrire</h4>
                                        <p class="mb-0">Entrer votre nom, email et mot de passe pour enregistrer:</p>
                                    </div>
                                    <div class="card-body">
                                        <form wire:submit ="store">

                                            <div class="input-group input-group-outline @if(strlen($name?? '') > 0) is-filled @endif">
                                                <label class="form-label">Nom</label>
                                                <input wire:model.live="name" type="text" class="form-control"
                                                >
                                            </div>
                                            @error('name')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                            @enderror

                                            <div class="input-group input-group-outline mt-3 @if(strlen($email ?? '') > 0) is-filled @endif">
                                                <label class="form-label">Email</label>
                                                <input wire:model.live="email" type="email"  class="form-control"
                                                     >
                                            </div>
                                            @error('email')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                            @enderror

                                            <div class="input-group input-group-outline mt-3 @if(strlen($password ?? '') > 0) is-filled @endif">
                                                <label class="form-label">Mot de passe</label>
                                                <input wire:model.live="password" type="password" class="form-control" >
                                            </div>
                                            @error('password')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                            @enderror

                                            <div class="text-center">
                                                <button type="submit"
                                                    style="background: #004687; color: white; border: none; width: 100%; padding: 10px; border-radius: 5px; margin-top: 20px; cursor: pointer;">
                                                    Se Connecter
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                        <p class="mb-2 text-sm mx-auto">
                                            Vous n'avez pas de compte ?
                                            <a href="{{ route('register') }}" style="color: #004687; font-weight: bold;">Créer un
                                                compte</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
