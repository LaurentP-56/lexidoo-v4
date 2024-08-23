<div>
    <style>
        .rightBtn a {
            float: right;
        }
    </style>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Initialisation du jeu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-sky-800/20 border-b border-gray-200 place-items-end">
                <div>

                    @if ($step === 1)
                        <div class="gap-4">
                            <h3 class="text-center py-4 text-xl text-sky-900 font-semibold">Choisissez votre niveau</h3>
                            <div class="flex flex-wrap justify-center gap-4">
                                @foreach ($levels as $level)
                                    <button type="button" wire:click="selectOption('level', {{ $level->id }})"
                                        class="btn-12 text-white w-full ">
                                        <span>{{ $level->label }} ({{ $level->sub_label }})</span>
                                        <span>{{ $level->label }} ({{ $level->sub_label }})</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if ($step === 2)
                        <div class="rightBtn">
                            <a href="javascript:void(0)" wire:click="backToStep(1)" class="btn btn-primary btn-lg">
                                Retour
                            </a>
                        </div>

                        <div class="gap-4">
                            <h3 class="text-center py-4 text-xl text-sky-900 font-semibold">Choisissez le temps
                                d'apprentissage</h3>
                            <div class="flex flex-wrap justify-center space-y-4">
                                @foreach ($tempsOptions as $temps)
                                    <button type="button" wire:click="selectOption('temps', {{ $temps['id'] }})"
                                        class="btn-12 text-white w-full ">
                                        <span>{{ $temps['duree'] }}</span>
                                        <span>{{ $temps['duree'] }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Thème -->
                    @if ($step === 3)
                        <div class="rightBtn">
                            <a href="javascript:void(0)" wire:click="backToStep(2)" class="btn btn-primary btn-lg">
                                Retour
                            </a>
                        </div>
                        <div class="gap-4">
                            <h3 class="text-center py-4 text-xl text-sky-900 font-semibold">Choisissez un thème</h3>
                            <div class="flex flex-wrap justify-center space-y-4">
                                @if (count($themes) > 0)
                                    @foreach ($themes as $themeId => $theme)
                                        <button type="button" wire:click="selectOption('theme', {{ $themeId }})"
                                            class="btn-12 text-white w-full ">
                                            <span>{{ $theme }}</span>
                                            <span>{{ $theme }}</span>
                                        </button>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Catégorie -->
                    @if ($step === 4)
                        <div class="rightBtn">
                            <a href="javascript:void(0)" wire:click="backToStep(3)" class="btn btn-primary btn-lg">
                                Retour
                            </a>
                        </div>
                        <div class="gap-4">
                            <h3 class="text-center py-4 text-xl text-sky-900 font-semibold">
                                Choisissez une catégorie
                            </h3>
                            <div class="flex flex-wrap justify-center space-y-4">
                                @if (count($categories) > 0)
                                    @foreach ($categories as $categoryId => $category)
                                        <button type="button"
                                            wire:click="selectOption('category', {{ $categoryId }})"
                                            class="btn-12 text-white w-full ">
                                            <span>{{ $category }}</span>
                                            <span>{{ $category }}</span>
                                        </button>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Sous-Catégorie -->
                    @if ($step === 5)
                        <div class="rightBtn">
                            <a href="javascript:void(0)" wire:click="backToStep(4)" class="btn btn-primary btn-lg">
                                Retour
                            </a>
                        </div>
                        <div class="gap-4">
                            <h3 class="text-center py-4 text-xl text-sky-900 font-semibold">
                                Choisissez une sous-catégorie
                            </h3>
                            <div class="flex flex-wrap justify-center space-y-4">
                                @if (count($subCategories) > 0)
                                    @foreach ($subCategories as $subCategoryId => $subCategory)
                                        <button type="button" wire:click="fetchWords({{ $subCategoryId }})"
                                            class="btn-12 text-white w-full ">
                                            <span>{{ $subCategory }}</span>
                                            <span>{{ $subCategory }}</span>
                                        </button>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Word -->
                    @if ($step === 6 && $currentWord)
                        <div class="gap-4">
                            <h3 class="text-center py-4 text-xl text-sky-900 font-semibold">
                                Choisissez un mot
                            </h3>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="bg-body-tertiary p-5 rounded">
                                        <p class="lead"> {{ $currentWord }}</p>
                                        <small>
                                            Think for a few seconds Then click to see the answer
                                        </small>
                                        <a class="btn btn-lg btn-primary" wire:click="showNewAnswer()" href="#"
                                            role="button">
                                            ANSWER »
                                        </a>
                                    </div>
                                </div>
                            </div>

                            @if ($showAnswer == true)
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="bg-body-tertiary p-5 rounded">
                                            <p class="lead"> {{ $currentTranslation }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex gap-2 justify-content-center py-5">
                                    <a class="btn btn-lg btn-success rounded-pill px-3"
                                        wire:click="updateProbability('know')" href="JavaScript:void(0)">
                                        I KNEW IT
                                    </a>
                                    <a class="btn btn-lg btn-success rounded-pill px-3"
                                        wire:click="updateProbability('dont_know')" href="JavaScript:void(0)">
                                        I DIDN'T KNOW
                                    </a>
                                    <a class="btn btn-lg btn-success rounded-pill px-3"
                                        wire:click="updateProbability('dont_want_to_learn')" href="JavaScript:void(0)">
                                        I don't want to learn
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
