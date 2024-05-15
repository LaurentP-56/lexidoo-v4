<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Jeu des mots') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Vous êtes prêt à commencer le jeu !
                    <!-- Affichage des mots ici -->
                    <div x-data="gameInit()">
                        <template x-for="mot in mots" :key="mot.id">
                            <div x-text="mot.nom"></div>
                        </template>
                        <button @click="nextWord()">Mot suivant</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
