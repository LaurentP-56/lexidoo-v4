<x-adminapp>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-sky-800/20 border-b border-gray-200">
                    <h2 class="text-xl text-black font-semibold mb-4">Gestion des Thèmes</h2>
                    <a href="{{ route('admin.theme.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Ajouter un nouveau thème</a>

                    <!-- Tableau des thèmes -->
                    <table class="mt-4 w-full text-left">
                        <thead>
                        <tr>
                            <th class="pb-4 text-sm text-center">Nom</th>
                            <th class="pb-4 text-sm text-center">Sous-theme</th>
                            <th class="pb-4 text-sm text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($themes as $theme)
                            <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-teal-500' : 'bg-sky-500' }}">
                                <td class="pt-2 pb-2 text-xs">{{ $theme->name }}</td>
                                <td class="pt-2 pb-2 text-xs whitespace-nowrap">
                                    {{-- Insérez la logique pour afficher les sous-thèmes ou un message si absent --}}
                                    @if(false) {{-- Remplacez `false` par votre condition pour les sous-thèmes --}}
                                    {{-- Logique pour afficher les sous-thèmes --}}
                                    @else
                                        Pas de sous-thèmes
                                    @endif
                                </td>
                                <td class="pt-2 pb-3 text-xs">
                                    <a href="{{ route('admin.theme.edit', $theme->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded text-xs">Modifier</a>
                                    <form action="{{ route('admin.theme.destroy', $theme->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce thème ?');" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-4 rounded text-xs">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $themes->links() }}
                </div>
            </div>
        </div>
    </div>
</x-adminapp>
