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
                                        class="rounded bg-blue-500 active:bg-blue-600 hover:bg-blue-700 py-2 px-4 text-white focus:ring-2 focus:ring-offset-2 w-full">
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
                            <h3 class="text-center py-4 text-xl text-sky-900 font-semibold">Choisissez le temps d'apprentissage</h3>
                            <div class="flex flex-wrap justify-center space-y-4">
                                @foreach ($tempsOptions as $temps)
                                    <button type="button" wire:click="selectOption('temps', {{ $temps['id'] }})"
                                        class="rounded bg-blue-500 active:bg-blue-600 hover:bg-blue-700 py-2 px-4 text-white focus:ring-2 focus:ring-offset-2 w-full">
                                        <span>{{ $temps['duree'] }} minutes</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if ($step === 3 && count($themes) > 0)
                        <div class="rightBtn">
                            <a href="javascript:void(0)" wire:click="backToStep(2)" class="btn btn-primary btn-lg">
                                Retour
                            </a>
                        </div>
                        <div class="gap-4">
                            <h3 class="text-center py-4 text-xl text-sky-900 font-semibold">Choisissez un thème</h3>
                            <div class="flex flex-wrap justify-center space-y-4">
                                @foreach ($themes as $themeId => $theme)
                                    <button type="button" wire:click="selectOption('theme', {{ $themeId }})"
                                        class="rounded bg-blue-500 active:bg-blue-600 hover:bg-blue-700 py-2 px-4 text-white focus:ring-2 focus:ring-offset-2 w-full">
                                        <span>{{ $theme }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if ($step === 4 && $categories && $categories->isNotEmpty())
                        <div class="rightBtn">
                            <a href="javascript:void(0)" wire:click="backToStep(3)" class="btn btn-primary btn-lg">
                                Retour
                            </a>
                        </div>
                        <div class="gap-4">
                            <h3 class="text-center py-4 text-xl text-sky-900 font-semibold">Choisissez une catégorie</h3>
                            <div class="flex flex-wrap justify-center space-y-4">
                                @foreach ($categories as $categoryId => $category)
                                    <button type="button" wire:click="selectOption('category', {{ $categoryId }})"
                                        class="rounded bg-blue-500 active:bg-blue-600 hover:bg-blue-700 py-2 px-4 text-white focus:ring-2 focus:ring-offset-2 w-full">
                                        <span>{{ $category }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if ($step === 5 && $subCategories && $subCategories->isNotEmpty())
                        <div class="rightBtn">
                            <a href="javascript:void(0)" wire:click="backToStep(4)" class="btn btn-primary btn-lg">
                                Retour
                            </a>
                        </div>
                        <div class="gap-4">
                            <h3 class="text-center py-4 text-xl text-sky-900 font-semibold">Choisissez une sous-catégorie</h3>
                            <div class="flex flex-wrap justify-center space-y-4">
                                @foreach ($subCategories as $subCategoryId => $subCategory)
                                    <button type="button" wire:click="selectOption('subCategory', {{ $subCategoryId }})"
                                        class="rounded bg-blue-500 active:bg-blue-600 hover:bg-blue-700 py-2 px-4 text-white focus:ring-2 focus:ring-offset-2 w-full">
                                        <span>{{ $subCategory }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

  <div>
                        @if ($step == 6 && $currentWord)
                            <div class="rightBtn">
                                <a href="javascript:void(0)" wire:click="backToStep(3)" class="btn btn-primary btn-lg">
                                    Retour
                                </a>
                            </div>

                            <div class="gap-4">
                                <h3 class="text-center py-4 text-xl text-sky-900 font-semibold">
                                    A vous de jouer
                                </h3>

                                @if ($isGameRunning)
                                    <div wire:poll.1000ms="tick">
                                        <h2>Temps restant : <span>{{ $this->getFormattedTime() }}</span></h2>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="bg-body-tertiary p-5 rounded">
                                                <p class="lead"> {{ $currentWord }}</p>
                                                <small>
                                                    Réfléchissez quelques secondes puis cliquez pour voir la réponse
                                                </small>
                                                <a class="btn btn-lg btn-primary" wire:click="showNewAnswer()" href="#" role="button">
                                                    Réponse »
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    @if ($showAnswer)
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="bg-body-tertiary p-5 rounded">
                                                    <p class="lead"> {{ $currentTranslation }}</p>
                                                    @if ($currentAudio)
                                                        <audio controls>
                                                            <source src="data:audio/wav;base64,{{ base64_encode($currentAudio) }}" type="audio/wav">
                                                            Votre navigateur ne supporte pas l'élément audio.
                                                        </audio>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-2 justify-content-center py-5">
                                            <a class="bg-success text-white rounded-pill px-3"
                                                wire:click="updateProbability('know')" href="JavaScript:void(0)">
                                                Je le savais
                                            </a>
                                            <a class=" bg-danger text-white rounded-pill px-3"
                                                wire:click="updateProbability('dont_know')" href="JavaScript:void(0)">
                                                Je ne le savais pas
                                            </a>
                                            <a class="bg-info rounded-pill text-white px-3"
                                                wire:click="updateProbability('dont_want_to_learn')" href="JavaScript:void(0)">
                                                Je ne veux pas apprendre ce mot
                                            </a>
                                        </div>
                                    @endif
                                @else
                                    <div>
                                        <h2>Fin du jeu</h2>
                                        <p>Total de mots : {{ $totalWords }}</p>
                                        <p>Je le savais : {{ $knewWordClicks }}</p>
                                        <p>Je ne le savais pas : {{ $didntKnowWordClicks }}</p>
                                        <p>Je ne veux pas apprendre ce mot : {{ $dontWantToLearnClicks }}</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>


<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('start-countdown', event => {
            let timeLeft = event.timeLeft;
            let countdownElement = document.getElementById('countdown');

            let countdownInterval = setInterval(() => {
                timeLeft--;
                countdownElement.textContent = timeLeft;

                if (timeLeft <= 0) {
                    clearInterval(countdownInterval);
                    Livewire.emit('endGame');
                }
            }, 1000);
        });
    });
</script>
