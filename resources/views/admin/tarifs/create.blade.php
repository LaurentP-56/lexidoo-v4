<x-adminapp>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-4">
                <h2>Gestion des Tarifs</h2>
                <div class="container mx-auto px-4">
                    <h1 class="text-xl font-bold mb-4">Ajouter un nouveau tarif</h1>
                    <div class="price-table">
                        <form method="POST" action="{{ route('admin.tarifs.store') }}" class="mb-4">
                            @csrf
                            <div class="price-carde">
                                <div>
                                    <label for="nom_offre">Nom de l'offre</label>
                                    <input id="nom_offre" type="text" name="nom_offre" value="" class="block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4" required>
                                </div>
                                <div class="price">
                                    <label for="prix">Prix</label>
                                    <input id="prix" type="number" step="0.01" name="prix" value="" class="block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4" required>
                                </div>
                                <div>
                                    <label for="duree">Durée</label>
                                    <input id="duree" type="text" name="duree" value="" class="block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4">
                                </div>
                                <div class="mb-4">
                                    <label for="description">Description</label>
                                    <textarea id="description" name="description" class="block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4"></textarea>
                                </div>
                                <div>
                                    <button type="submit" class="appearance-none block w-full bg-blue-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        Ajouter
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-adminapp>
