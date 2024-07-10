<x-adminapp>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <a href="{{ route('admin.mots.create') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Ajouter un nouveau
                    mot</a>

                <div class="p-6 bg-sky-800/20 border-b border-gray-200">
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="pb-4 text-sm text-center">Nom</th>
                                <th class="pb-4 text-sm text-center">Traduction</th>
                                <th class="pb-4 text-sm text-center">Niveau</th>
                                <th class="pb-4 text-sm text-center">Thème</th>
                                <th class="pb-4 text-sm text-center">Catégories</th>
                                <th class="pb-4 text-sm text-center">Sous-catégories</th>
                                <th class="pb-4 text-sm text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mots as $mot)
                                <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-teal-500' : 'bg-sky-500' }}">
                                    <td class="pt-2 pb-2 text-center text-xs">{{ $mot->nom }}</td>
                                    <td class="pt-2 pb-2 text-center text-xs">{{ $mot->traduction }}</td>
                                    <td class="pt-2 pb-2 text-center text-xs">{{ $mot->level->label ?? 'N/A' }}</td>
                                    <td class="pt-2 pb-2 text-center text-xs">{{ $mot->theme->name ?? 'N/A' }}</td>
                                    <td class="pt-2 pb-2 text-center text-xs">{{ $mot->category->name ?? 'N/A' }}</td>
                                    <td class="pt-2 pb-2 text-center text-xs">{{ $mot->subCategory->name ?? 'N/A' }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.mots.edit', $mot->id) }}"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded text-xs">Éditer</a>
                                        <form action="{{ route('admin.mots.destroy', $mot->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-4 rounded text-xs">Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $mots->links() }}
                </div>
            </div>
        </div>
    </div>
</x-adminapp>
