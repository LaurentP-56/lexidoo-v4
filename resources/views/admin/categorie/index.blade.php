<x-adminapp>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-sky-800/20 border-b border-gray-200">
                <div class="flex justify-between">
                    <h2 class="text-xl text-center text-black font-bold mb-2">Liste des Catégories</h2>
                    <a href="{{ route('admin.categories.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">Ajouter une Catégorie</a>
                </div>

                <table class="table-auto w-full mt-4">
                    <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="pb-4 text-sm text-center">Nom</th>
                        <th class="pb-4 text-sm text-center">Thème Associé</th>
                        <th class="pb-4 text-sm text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="pt-2 pb-2 text-xs text-white">
                    @foreach ($categories as $categorie)
                        <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-teal-500' : 'bg-sky-500' }}">

                            <td class="pt-2 pb-2 text-xs text-white">
                                {{ $categorie->nom }}
                            </td>
                            <td class="pt-2 pb-2 text-xs text-white">
                                {{ $categorie->theme->name ?? 'Non spécifié' }}
                            </td>
                            <td class="pt-2 pb-2 text-xs text-white">
                                <a href="{{ route('admin.categories.edit', $categorie->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded text-xs">Éditer</a>
                                <form action="{{ route('admin.categories.destroy', $categorie->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-4 rounded text-xs" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                @if($categories->hasPages())
                    <div class="mt-4">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-adminapp>
