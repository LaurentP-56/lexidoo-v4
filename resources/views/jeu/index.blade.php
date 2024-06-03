<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Initialisation du jeu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-sky-800/20 border-b border-gray-200 place-items-end">
                <div x-data="gameInit()" x-init="init(@js($levels), @js($themes), @js($sousThemes), @js($categories), @js($sousCategories), @js($tempsOptions), @js($isPremium))">

                    <!-- Niveau -->
                    <div x-show="step === 1" class="gap-4">
                        <h3 class="text-center py-4 text-xl text-sky-900 font-semibold">Choisissez votre niveau</h3>
                        <div class="flex flex-wrap justify-center gap-4">
                            <template x-for="level in levels" :key="level.id">
                                <button @click="selectOption('level', level.id)" class="btn-12 text-white w-full ">
                                    <span x-text="level.label + ' (' + level.sub_label + ')'"></span>
                                    <span x-text="level.label + ' (' + level.sub_label + ')'"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- Temps d'apprentissage -->
                    <div x-show="step === 2" class="gap-4">
                        <h3 class="text-center py-4 text-xl text-sky-900 font-semibold">Choisissez le temps
                            d'apprentissage</h3>
                        <div class="flex flex-wrap justify-center space-y-4">
                            <template x-for="temps in tempsOptions" :key="temps.id">
                                <button @click="selectOption('temps', temps.id)" class="btn-12 text-white w-full ">
                                    <span x-text="temps.duree"></span>
                                    <span x-text="temps.duree"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- Thème -->
                    <div x-show="step === 3" class="gap-4">
                        <h3 class="text-center py-4 text-xl text-sky-900 font-semibold">Choisissez un thème</h3>
                        <div class="flex flex-wrap justify-center space-y-4">
                            <template x-for="theme in themes" :key="theme.id">
                                <button @click="selectOption('theme', theme.id)" class="btn-12 text-white w-full ">
                                    <span x-text="theme.name"></span>
                                    <span x-text="theme.name"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- Sous-Thème -->
                    <div x-show="step === 4 && filteredSousThemes.length > 0" class="gap-4">
                        <h3 class="text-center py-4 text-xl text-sky-900 font-semibold">Choisissez un sous-thème</h3>
                        <div class="flex flex-wrap justify-center space-y-4">
                            <template x-for="sousTheme in filteredSousThemes" :key="sousTheme.id">
                                <button @click="selectOption('sousTheme', sousTheme.id)"
                                    class="btn-12 text-white w-full ">
                                    <span x-text="sousTheme.name"></span>
                                    <span x-text="sousTheme.name"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- Catégorie -->
                    <div x-show="step === 5 && filteredCategories.length > 0" class="gap-4">
                        <h3 class="text-center py-4 text-xl text-sky-900 font-semibold">Choisissez une catégorie</h3>
                        <div class="flex flex-wrap justify-center space-y-4">
                            <template x-for="categorie in filteredCategories" :key="categorie.id">
                                <button @click="selectOption('categorie', categorie.id)"
                                    class="btn-12 text-white w-full ">
                                    <span x-text="categorie.nom"></span>
                                    <span x-text="categorie.nom"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- Sous-Catégorie -->
                    <div x-show="step === 6 && filteredSousCategories.length > 0" class="gap-4">
                        <h3 class="text-center py-4 text-xl text-sky-900 font-semibold">Choisissez une sous-catégorie
                        </h3>
                        <div class="flex flex-wrap justify-center space-y-4">
                            <template x-for="sousCategorie in filteredSousCategories" :key="sousCategorie.id">
                                <button @click="selectOption('sousCategorie', sousCategorie.id)"
                                    class="btn-12 text-white w-full ">
                                    <span x-text="sousCategorie.nom"></span>
                                    <span x-text="sousCategorie.nom"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- Word -->
                    <div x-show="step === 7 && filteredMots.length > 0" class="gap-4">
                        <h3 class="text-center py-4 text-xl text-sky-900 font-semibold">Choisissez un mot</h3>
                        <div class="flex flex-wrap justify-center space-y-4">
                            <template x-for="mot in filteredMots" :key="mot.id">
                                <button @click="selectOption('mot', mot.id)" class="btn-12 text-white w-full ">
                                    <span x-text="mot.nom"></span>
                                    <span x-text="mot.nom"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('gameInit', () => ({
                step: 1,
                levels: [],
                themes: [],
                sousThemes: [],
                categories: [],
                sousCategories: [],
                tempsOptions: [],
                isPremium: false,
                isFetchWords: false,
                mots: [],

                selectedLevelId: null,
                selectedTempsId: null,
                selectedThemeId: null,
                selectedSousThemeId: null,
                selectedCategorieId: null,
                selectedSousCategorieId: null,

                init(levels, themes, sousThemes, categories, sousCategories, tempsOptions, isPremium) {
                    console.log("Initial Data:", {
                        levels,
                        themes,
                        sousThemes,
                        categories,
                        sousCategories,
                        tempsOptions,
                        isPremium
                    });
                    this.levels = levels || [];
                    this.themes = themes || [];
                    this.sousThemes = sousThemes || [];
                    this.categories = categories || [];
                    this.sousCategories = sousCategories || [];
                    this.tempsOptions = tempsOptions || [];
                    this.isPremium = isPremium || false;
                },

                selectOption(type, id) {
                    this[`selected${type}Id`] = id;
                    this.step++;

                    if (type === 'level' && !this.isPremium && !this.levels.find(level => level.id ===
                            id).available) {
                        this.step--;
                        this[`selected${type}Id`] = null;
                        console.log("Not premium or level not available");
                        return;
                    }

                    if (type === 'level') {
                        this.selectedLevelId = id;
                    }

                    if (type === 'temps') {
                        this.selectedTempsId = id;
                    }

                    if (type === 'theme') {
                        this.selectedThemeId = id;
                    }

                    if (type === 'sousTheme') {
                        this.selectedSousThemeId = id;
                    }

                    if (type == 'categorie') {
                        this.selectedCategorieId = id;
                    }

                    if (type == 'sousCategorie') {
                        this.selectedSousCategorieId = id;
                    }

                    console.log(`Selected ${type} ID:`, this[`selected${type}Id`], "New step:", this
                        .step);
                },

                get filteredSousThemes() {
                    console.log("Filtered SousThemes:", this.sousThemes.filter(st => st
                        .parent_id === this.selectedThemeId));
                    return this.sousThemes.filter(st => st.parent_id === this.selectedThemeId);
                },

                get filteredCategories() {
                    console.log("Filtered Categories:", this.categories.filter(c => c.theme_id ===
                        this.selectedSousThemeId));
                    return this.categories.filter(c => c.theme_id === this.selectedSousThemeId);
                },

                get filteredSousCategories() {
                    console.log("Filtered SousCategories:", this.sousCategories.filter(sc => sc
                        .categorie_theme_id === this.selectedCategorieId));
                    this.isFetchWords = true;
                    return this.sousCategories.filter(sc => sc.categorie_theme_id === this
                        .selectedCategorieId);
                },

                async getFilteredMots() {
                    if (this.selectedLevelId && this.selectedTempsId && this.selectedThemeId && this
                        .selectedSousThemeId && this.selectedCategorieId && this
                        .selectedSousCategorieId && this.isFetchWords) {
                        const response = await fetch("{{ route('jeu.mots') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                level_id: this.selectedLevelId,
                                temps_id: this.selectedTempsId,
                                theme_id: this.selectedThemeId,
                                sous_theme_id: this.selectedSousThemeId,
                                categorie_id: this.selectedCategorieId,
                                sous_categorie_id: this.selectedSousCategorieId,
                            })
                        });

                        const data = await response.json();
                        if (data.mots) {
                            this.mots = data.mots;
                            this.isFetchWords = false;
                        }
                    }
                },

                get filteredMots() {
                    this.getFilteredMots();
                    return this.mots;
                }
            }));
        });
    </script>
</x-app-layout>
