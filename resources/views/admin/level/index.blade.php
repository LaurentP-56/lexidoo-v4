<x-adminapp>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-sky-800/20 border-b border-gray-200">
                <h2 class="text-xl text-center text-black font-bold mb-2">Gestion des Niveaux</h2>
                <a href="{{ route('admin.levels.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">
                    Ajouter un nouveau niveau
                </a>
                <table class="table table-striped mt-4">
                    <thead>
                        <tr>
                            <th scope="col">Label</th>
                            <th scope="col">Sous-label</th>
                            <th scope="col">Classe</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($levels as $level)
                            <tr class="tr {{ $loop->iteration % 2 == 0 ? 'bg-teal-500' : 'bg-sky-500' }}">

                                <td>{{ $level->label }}</td>
                                <td>{{ $level->sub_label }}</td>
                                <td>{{ $level->classe }}</td>
                                <td>
                                    <a href="{{ route('admin.levels.edit', $level->id) }}"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded text-xs">Éditer</a>
                                    <form action="{{ route('admin.levels.destroy', $level->id) }}" method="POST"
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce niveau ?');"
                                        style="display: inline-block;">
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
            </div>
        </div>
    </div>
</x-adminapp>
