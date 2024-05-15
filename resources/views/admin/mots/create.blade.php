<x-adminapp>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-sky-800/20 border-b border-gray-200">
                <div class="p-6  border-b border-gray-200">
                    <h2 class="text-xl text-black text-center font-semibold mb-4">Ajouter un nouveau mot</h2>
                    <form action="{{ route('admin.mots.store') }}" class="bg-teal-300/30 p-5" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="nom" class="block text-gray-700 text-sm font-bold mb-2">Nom:</label>
                            <input type="text" name="nom" id="nom" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        <div class="mb-4">
                            <label for="traduction" class="block text-gray-700 text-sm font-bold mb-2">Traduction:</label>
                            <input type="text" name="traduction" id="traduction" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        <div class="mb-4">
                            <label for="level_id" class="block text-gray-700 text-sm font-bold mb-2">Niveau:</label>
                            <select name="level_id" id="level_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @foreach($levels as $level)
                                    <option value="{{ $level->id }}">{{ $level->label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="theme_id" class="block text-gray-700 text-sm font-bold mb-2">Thème:</label>
                            <select name="theme_id" id="theme_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @foreach($themes as $theme)
                                    <option value="{{ $theme->id }}">{{ $theme->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="categorie_id" class="block text-gray-700 text-sm font-bold mb-2">Catégorie:</label>
                            <select name="categorie_id" id="categorie_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @foreach($categories as $categorie)
                                    <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="inline-flex items-center mt-3">
                                <input type="checkbox" name="gratuit" id="gratuit" class="form-checkbox h-5 w-5 text-blue-600"><span class="ml-2 text-gray-700">Mot gratuit</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">Ajouter</button>
                        </div>
                    </form>

                    <!-- Formulaire d'importation CSV -->
                    <div class="mt-8 bg-teal-300/30 p-5" >
                        <h2 class="text-xl text-black text-center font-semibold mb-4">Importer des mots depuis un fichier CSV</h2>
                        <form action="{{ route('admin.mots.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <input type="file" name="file" required>
                            </div>
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Importer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-adminapp>
