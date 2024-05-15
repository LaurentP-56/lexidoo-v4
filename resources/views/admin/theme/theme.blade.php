<x-adminapp>

    <div class="py-12">
        <div class=" max-w-7xl mx-auto sm:px-6 lg:px-8">
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-8">Gestion des Thèmes</h1>

    {{-- Message de succès --}}
    @if(session('success'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('success') }}
        </div>
    @endif

    {{-- Lien pour ajouter un nouveau thème --}}
    <a href="{{ route('admin.theme.create') }}" class="mb-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Ajouter un nouveau thème
    </a>

    {{-- Liste des thèmes --}}
    <div class="overflow-hidden shadow-md sm:rounded-lg">
        <table class="min-w-full">
            <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Nom
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Sous-Thèmes
                </th>
                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Actions
                </th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @foreach($themes as $theme)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $theme->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{-- Affichez ici les sous-thèmes ou un message si absent --}}
                        @if($theme->mots->count())
                            @foreach($theme->mots as $mot)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ $mot->name }}
                                        </span>
                            @endforeach
                        @else
                            Pas de sous-thèmes
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.theme.edit', $theme->id) }}" class="text-indigo-600 hover:text-indigo-900">Éditer</a>
                        <form action="{{ route('admin.theme.destroy', $theme->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce thème ?');">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{-- Pagination --}}
    <div class="py-4">
        {{ $themes->links() }}
    </div>


</div>
        </div>
    </div>
</x-adminapp>
