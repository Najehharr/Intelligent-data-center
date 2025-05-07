

        <main class="main-content  mt-0">
            <section>
                <div class="page-header min-vh-100">
                    <div class="container">
                        <div class="row">
                            <div
                                class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
                                <img src="{{ asset('assets/img/logos/hopital/Hopital.jpg') }}" alt="Hospital Image" width="350" style="margin-left: 120px">               </div>
                            <div
                                class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
                                <div class="card card-plain">
                                    <div class="card-header">
                                        <h4 class="font-weight-bolder">S'inscrire</h4>
                                        <p class="mb-0">Entrer votre nom, email et mot de passe pour enregistrer:</p>
                                    </div>
                                    <div class="card-body">
                                        <form wire:submit ="store">

                                            <div class="input-group mt-3"style="border: 1px solid #004687; border-radius: 4px;" @if(strlen($name?? '') > 0) is-filled @endif">

                                                <input wire:model.lazy="name" type="text" class="form-control"placeholder="Nom"
                                                >
                                            </div>
                                            @error('name')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                            @enderror

                                            <div class="input-group mt-3"style="border: 1px solid #004687; border-radius: 4px;" @if(strlen($email ?? '') > 0) is-filled @endif">

                                                <input wire:model.lazy="email" autocomplete="off"  type="email"  class="form-control"placeholder="E-mail"
                                                     >
                                            </div>
                                            @error('email')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                            @enderror
                                            <div class="input-group mt-3"style="border: 1px solid #004687; border-radius: 4px;" @if(strlen($role ?? '') > 0) is-filled @endif">

                                                <input wire:model.lazy="role" autocomplete="off"  type="text"  class="form-control"placeholder="Role"
                                                     >
                                            </div>
                                            @error('role')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                            @enderror

                                            <div class="input-group mt-3"style="border: 1px solid #004687; border-radius: 4px;" @if(strlen($password ?? '') > 0) is-filled @endif">

                                                <input wire:model.lazy="password"  autocomplete="new-password" type="password" class="form-control"placeholder="Mot de passe" >
                                            </div>
                                            @error('password')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                            @enderror

                                            <div class="text-center">
                                                <button type="submit"
                                                    style="background: #004687; color: white; border: none; width: 100%; padding: 10px; border-radius: 5px; margin-top: 20px; cursor: pointer;">
                                                    S'inscrire
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
