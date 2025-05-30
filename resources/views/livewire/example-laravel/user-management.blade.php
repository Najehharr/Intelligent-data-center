
<div>
@extends('layouts.app') {{-- Assuming you have a main layout called layouts.app --}}

@section('content')
<div class="container-fluid py-4">

    {{-- Flash Message --}}
    @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    {{-- Edit User Form --}}
    @isset($editUser)
        <div class="row mb-4">
            <div class="col-12">
                <div class="card p-4">
                    <h5>Modifier l'utilisateur</h5>
                    <form action="{{ route('users.update', $editUser->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name">Nom</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $editUser->name) }}" class="form-control" required>
                            @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $editUser->email) }}" class="form-control" required>
                            @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="role">Rôle</label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="Admin" {{ old('role', $editUser->role) == 'Admin' ? 'selected' : '' }}>Admin</option>
                                <option value="Agent" {{ old('role', $editUser->role) == 'Agent' ? 'selected' : '' }}>Agent</option>
                                <option value="Technicien" {{ old('role', $editUser->role) == 'Technicien' ? 'selected' : '' }}>Technicien</option>
                                <option value="User" {{ old('role', $editUser->role) == 'User' ? 'selected' : '' }}>User</option>
                            </select>
                            @error('role') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        {{-- Uncomment to allow password change --}}
                        {{--
                        <div class="mb-3">
                            <label for="password">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation">Confirmer le nouveau mot de passe</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                        </div>
                        --}}

                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        <a href="{{ route('user-management') }}" class="btn btn-secondary">Annuler</a>
                    </form>
                </div>
            </div>
        </div>
    @endisset

    {{-- User List Table --}}
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-black text-capitalize ps-3">Gestion des utilisateurs</h6>
                    </div>
                </div>

                <div class="me-3 my-3 text-end">
                    <a href="{{ route('users.create') }}" class="btn bg-gradient-dark mb-0">
                        <i class="material-icons text-sm">add</i>&nbsp;&nbsp;Ajouter un nouvel utilisateur
                    </a>
                </div>

                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Rôle</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td class="text-center">{{ $user->email }}</td>
                                        <td class="text-center">{{ $user->role }}</td>
                                        <td class="text-center">{{ $user->created_at->format('d/m/Y') }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-success btn-sm" title="Modifier">
                                                <i class="material-icons">edit</i>
                                            </a>

                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Supprimer">
                                                    <i class="material-icons">close</i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">Aucun utilisateur trouvé.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection
</div>
