
        <div class="container my-auto">
            <div class="row">
                <div class="col-lg-4 col-md-8 col-12 mx-auto">
                    <div class="card z-index-0 fadeIn3 fadeInBottom">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">


                            //bg gardient primary hewe rose
                            <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                                <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">
                                    Réinitialiser le mot de passe</h4>
                                <p class='text-light p-2'>Vous recevrez un e-mail dans 60 secondes maximum</p>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (Session::has('status'))
                            <div class="alert alert-success alert-dismissible text-white" role="alert">
                                <span class="text-sm">{{ Session::get('status') }}</span>
                                <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @elseif (Session::has('email'))
                            <div class="alert alert-danger alert-dismissible text-white" role="alert">
                                <span class="text-sm">{{ Session::get('email') }}</span>
                                <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif
                            @if (Session::has('demo'))
                            <div class="row">
                                <div class="alert alert-danger alert-dismissible text-white" role="alert">
                                    <span class="text-sm">{{ Session::get('demo') }}</span>
                                    <button type="button" class="btn-close text-lg py-3 opacity-10"
                                        data-bs-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                            @endif
                            <form wire:submit="show">

                                <div class="input-group input-group-outline mt-3 @if(strlen($email ?? '') > 0) is-filled @endif">
                                    <label class="form-label">Email</label>
                                    <input wire:model.live="email" type="email" class="form-control"
                                        >
                                </div>
                                @error('email')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                                <div class="text-center">
                                    <button type="submit"
                                        style="background: #004687; color: white; border: none; width: 100%; padding: 10px; border-radius: 5px; margin-top: 20px; cursor: pointer;">
                                      Envoyer
                                    </button>
                                </div>
                                <p class="mt-4 text-sm text-center">
                                    Vous n'avez pas de compte ?
                                    <a href="{{ route('register') }}" style="color: #004687; font-weight: bold;">S'inscrire</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

