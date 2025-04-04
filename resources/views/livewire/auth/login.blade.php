





<div class="container my-auto mt-5">
 <div class="row signin-margin">
        <div class="col-lg-4 col-md-8 col-12 mx-auto">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">

                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-center">
        <img src="{{ asset('assets/img/logos/hopital/Hopital.jpg') }}" alt="Hospital Image" width="250">
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
                        <div class="input-group input-group-outline mt-3 @if (strlen($email ?? '') > 0) is-filled @endif" style="border-color: #004687 !important;">
                            <label class="form-label">Email</label>
                            <input wire:model.live='email' type="email" class="form-control">
                        </div>
                        @error('email')
                        <p class='text-danger inputerror'>{{ $message }} </p>
                        @enderror

                        <!-- Champ Password -->
                        <div
                            class="input-group input-group-outline mt-3 @if (strlen($password ?? '') > 0) is-filled @endif">
                            <label class="form-label">Mot de passe</label>
                            <input wire:model.live="password" type="password" class="form-control">
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
