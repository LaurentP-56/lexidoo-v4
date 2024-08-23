<x-adminapp>

    <div class="py-12">
        <div class=" max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container mx-auto px-4 py-8">
                <div class="w-full max-w-lg mx-auto">
                    <h2 class="text-xl font-semibold mb-6">Définir le niveau de probabilité</h2>

                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            <p class="font-bold">Success</p>
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    <form action="{{ route('admin.probabilities.store') }}" method="POST"
                        class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                                Savoir
                            </label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="name" type="text" name="know" required autofocus
                                value="{{ old('know', $probability->know) }}" />
                            @error('know')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                                Je ne le savais pas
                            </label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="name" type="text" name="dont_know" required
                                value="{{ old('dont_know', $probability->dont_know) }}" />
                            @error('dont_know')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <button
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                type="submit">
                                Sauvegarder
                            </button>

                            <a class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                id="resetUserProbability" href="javascript:void(0)">
                                Réinitialiser la probabilité de l'utilisateur
                            </a>
                        </div>
                    </form>

                    <form action="{{ route('admin.probabilities.reset') }}" method="POST" class="hidden"
                        id="resetUserProbabilityForm">
                        @csrf
                    </form>

                    <script>
                        document.getElementById('resetUserProbability').addEventListener('click', function() {
                            if (confirm('Etes-vous sûr de vouloir réinitialiser la probabilité d'utilisation ?')) {
                                document.getElementById('resetUserProbabilityForm').submit();
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-adminapp>
