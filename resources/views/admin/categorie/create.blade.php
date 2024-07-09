<x-adminapp>

    <div class="py-12">
        <div class=" max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container mx-auto px-4 py-8">
                <div class="w-full max-w-lg mx-auto">
                    <h2 class="text-xl font-semibold mb-6">Créer un nouveau thème</h2>
                    <form action="{{ route('admin.theme.store') }}" method="POST"
                        class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                                Nom du thème
                            </label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="name" type="text" name="name" required autofocus>
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
                        </div>

                        <div class="flex items-center justify-between">
                            <button
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                type="submit">
                                Créer
                            </button>
                            <a href="{{ route('admin.theme.index') }}"
                                class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                                Retour
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-adminapp>
