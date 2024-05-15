<x-adminapp>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-4">
                <h2>Gestion des Tarifs</h2>
                <div class="container mx-auto px-4">
                    <h1 class="text-xl font-bold mb-4">Modifier le tarif</h1>
                    <div class="price-table">
                        <form method="POST" action="{{ route('admin.tarifs.update', $tarif->id) }}" class="mb-4">
                            @csrf
                            @method('PUT')
                            <div class="price-carde">
                                <div>
                                    <label for="nom_offre-{{ $tarif->id }}">Nom de l'offre</label>
                                    <input id="nom_offre-{{ $tarif->id }}" type="text" name="nom_offre" value="{{ $tarif->nom_offre }}" class="block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4">
                                </div>
                                <div class="price">
                                    <label for="prix-{{ $tarif->id }}">Prix</label>
                                    <input id="prix-{{ $tarif->id }}" type="number" step="0.01" name="prix" value="{{ $tarif->prix }}" class="block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4">
                                </div>
                                <div>
                                    <label for="duree-{{ $tarif->id }}">Durée</label>
                                    <input id="duree-{{ $tarif->id }}" type="text" name="duree" value="{{ $tarif->duree }}" class="block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4">
                                </div>
                                <div class="mb-4">
                                    <label for="description-{{ $tarif->id }}">Description</label>
                                    <textarea id="description-{{ $tarif->id }}" name="description" class="block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4">{{ $tarif->description }}</textarea>
                                </div>
                                <div>
                                    <button type="submit" class="appearance-none block w-full bg-blue-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        Modifier
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
