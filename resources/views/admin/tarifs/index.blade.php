<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="p-6 bg-sky-800/20 border-b border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <a href="{{ route('admin.tarifs.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">Ajouter un nouveau tarif</a>
                    <table class="table-auto w-full mt-4">
                        <thead>
                        <tr>
                            <th>Nom de l'offre</th>
                            <th>Prix</th>
                            <th>Description</th>
                            <th>Durée</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tarifs as $tarif)
                            <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-teal-500' : 'bg-sky-500' }}">
                                <td>{{ $tarif->nom_offre }}</td>
                                <td>{{ $tarif->prix }}</td>
                                <td>{{ $tarif->description }}</td>
                                <td>{{ $tarif->duree }}</td>
                                <td>
                                    <a href="{{ route('admin.tarifs.edit', $tarif->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded text-xs">Éditer</a>
                                    <form action="{{ route('admin.tarifs.destroy', $tarif->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-4 rounded text-xs">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                </div>
        </div>
    </div>
</x-app-layout>
