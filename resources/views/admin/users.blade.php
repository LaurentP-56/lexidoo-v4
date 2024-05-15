<x-adminapp>
    <div>
        @if (session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif
            <div class="py-12">
                <div class=" max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="p-6 bg-sky-800/20 border-b border-gray-200">
                        <div class="p-6 text-sky-800">
            <form method="GET" action="{{ route('admin.users') }}">
                <input
                type="text"
                name="search"
                placeholder="Recherche par e-mail..."
                value="{{ $searchTerm }}"
            />
            <button type="submit">Rechercher</button>
        </form>

        <h2>Liste des utilisateurs</h2>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th><a href="{{ route('admin.users', ['sortBy' => 'email', 'sortDirection' => request('sortDirection', 'desc') == 'asc' ? 'desc' : 'asc']) }}">Email</a></th>
                    <th><a href="{{ route('admin.users', ['sortBy' => 'created_at', 'sortDirection' => request('sortDirection', 'desc') == 'asc' ? 'desc' : 'asc']) }}">Inscrit Le</a></th>
                    <th><a href="{{ route('admin.users', ['sortBy' => 'premium', 'sortDirection' => request('sortDirection', 'desc') == 'asc' ? 'desc' : 'asc']) }}">Premium</a></th>
                </tr>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-teal-500' : 'bg-sky-500' }}">
                        <td class="text-center text-white">{{ $user->nom }}</td>
                        <td class="text-center text-white">{{ $user->prenom }}</td>
                        <td class="text-center text-white">{{ $user->email }}</td>
                        <td class="text-center text-white">
                            @if($user->created_at)
                                {{ $user->created_at->format('d/m/Y') }}
                            @else
                                Non précisé
                            @endif
                        </td>
                        <td class="text-center text-white premium-status" data-user-id="{{ $user->id }}">{{ $user->premium ? 'Oui' : 'Non' }}</td>
                        </td>
                        </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $users->appends(['search' => $searchTerm])->links() }}
    </div>
                    </div>
                </div>
            </div></div>
</x-adminapp>>
