

<div class="container my-auto mt-5">
    <div class="row signin-margin">
        <div class="col-lg-4 col-md-8 col-12 mx-auto">
            <div class="card z-index-0 ">
                <div class="card-header p-0  mt-n4 mx-3 z-index-2">

                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-center">
                        <img src="{{ asset('assets/img/logos/hopital/Hopital.jpg') }}" alt="Hospital Image" width="250" height="">
                    </div>

                    <div class="d-flex justify-content-center">
                        <h4>Se Connecter</h4>
                    </div>

                    <form wire:submit='store'>
                        @if (Session::has('status'))
                            <div class="alert alert-success alert-dismissible text-white" role="alert">
                                <span class="text-sm">{{ Session::get('status') }}</span>
                                <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <!-- Champ Email -->
                        <div
                        class="input-group mt-3" style="border: 1px solid #004687; border-radius: 4px;" @if (strlen($email ?? '') > 0) is-filled @endif>
                        <input type="email" wire:model.lazy="email" autocomplete="off" class="form-control" placeholder="E-mail" />
                        </div>
                        @error('email')
                            <p class='text-danger inputerror'>{{ $message }} </p>
                        @enderror

                        <!-- Champ Password -->
                        <div
                        class="input-group mt-3" style="border: 1px solid #004687; border-radius: 4px;" @if (strlen($password ?? '') > 0) is-filled @endif>
                        <input type="password" wire:model.lazy="password" autocomplete="new-password" class="form-control" placeholder="Password">

                        </div>
                        @error('password')
                            <p class='text-danger inputerror'>{{ $message }} </p>
                        @enderror

                        <!-- Bouton Se Connecter -->
                        <div class="text-center">
                            <button type="submit"
                                style="background: #004687; color: white; border: none; width: 100%; padding: 10px; border-radius: 5px; margin-top: 20px; cursor: pointer;">
                                Se Connecter
                            </button>
                        </div>

                        <!-- Lien Création de Compte -->
                        <p class="mt-4 text-sm text-center">
                            Vous n'avez pas de compte?
                            <a href="{{ route('register') }}" style="color: #004687; font-weight: bold;">Créer un
                                compte</a>
                        </p>

                        <!-- Lien Mot de Passe Oublié -->
                        <p class="text-sm text-center">
                            Mot de passe oublié?
                            Réinitialisez votre mot de passe
                            <a href="{{ route('password.forgot') }}" style="color: #004687; font-weight: bold;">Ici</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
