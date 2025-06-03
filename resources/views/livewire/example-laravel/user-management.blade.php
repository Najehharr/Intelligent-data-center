<x-layouts.app>
    <div class="container-fluid py-4">

        {{-- Flash Message --}}
        @if (session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        {{-- Edit User (inline form) --}}
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
                        <button type="button" class="btn bg-gradient-dark mb-0" data-bs-toggle="modal" data-bs-target="#createUserModal">
                            <i class="material-icons text-sm">add</i>&nbsp;&nbsp;Ajouter un nouvel utilisateur
                        </button>
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
                                                <button class="btn btn-sm btn-primary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editUserModal"
                                                        data-user-id="{{ $user->id }}"
                                                        data-user-name="{{ $user->name }}"
                                                        data-user-email="{{ $user->email }}">
                                                    <i class="material-icons">edit</i>
                                                </button>

                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
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

        <!-- Create User Modal -->
        <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content p-3">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createUserModalLabel">Ajouter un utilisateur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('users.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="new_name">Nom</label>
                                <input type="text" name="name" id="new_name" class="form-control" required>
                                @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="new_email">Email</label>
                                <input type="email" name="email" id="new_email" class="form-control" required>
                                @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="new_role">Rôle</label>
                                <select name="role" id="new_role" class="form-control" required>
                                    <option value="">-- Sélectionnez --</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Agent">Agent</option>
                                    <option value="Technicien">Technicien</option>
                                    <option value="User">User</option>
                                </select>
                                @error('role') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Créer</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit User Modal -->
        <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('users.update', ['user' => 0]) }}" id="editUserForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editUserModalLabel">Modifier l'utilisateur</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="user_id" id="editUserId">
                            <div class="mb-3">
                                <label for="editUserName" class="form-label">Nom</label>
                                <input type="text" class="form-control" name="name" id="editUserName" required>
                            </div>
                            <div class="mb-3">
                                <label for="editUserEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="editUserEmail" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Enregistrer</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

    {{-- Edit Modal Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editUserModal = document.getElementById('editUserModal');
            editUserModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const userId = button.getAttribute('data-user-id');
                const userName = button.getAttribute('data-user-name');
                const userEmail = button.getAttribute('data-user-email');

                document.getElementById('editUserId').value = userId;
                document.getElementById('editUserName').value = userName;
                document.getElementById('editUserEmail').value = userEmail;
                document.getElementById('editUserForm').action = `/users/${userId}`;
            });
        });
    </script>
</x-layouts.app>
