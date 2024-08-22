<x-adminapp>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-sky-800/20 overflow-hidden shadow-xl p-2 sm:rounded-lg">
                    <h2 class="text-xl text-black text-center font-semibold mb-6">Modifier le thème : {{ $categorie->name }}</h2>

                    <form action="{{ route('admin.categories.update', $categorie->id) }}" method="POST"
                        class="bg-teal-300/30  shadow-md rounded px-8 pt-6 pb-8 mb-4">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                                Nom du thème
                            </label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="name" type="text" name="name" value="{{ old('name', $categorie->name) }}"
                                required autofocus />
                            @error('name')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="theme_id">
                                Thème Parent (Optionnel)
                            </label>
                            <select name="theme_id" id="theme_id"
                                class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="">Sélectionnez un thème parent</option>
                                @foreach (getThemes() as $themeId => $themeName)
                                    <option value="{{ $themeId }}">{{ $themeName }}</option>
                                @endforeach
                            </select>
                            @error('theme_id')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <button
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                type="submit">
                                Sauvegarder
                            </button>
                            <a href="{{ route('admin.categories.index') }}"
                                class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                                Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-adminapp>
