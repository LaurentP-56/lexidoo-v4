@php
    $tarifs = App\Models\Tarifs::all(); // Ce n'est PAS une bonne pratique
 @endphp

    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Scripts -->
        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
<link rel="stylesheet" type="text/css" href="/styles/gindex.css" media="all" />
    </head>
    <body class="antialiased bodybg">
    @include('layouts.gnav')
    <div style="overflow-x: hidden;">
        <div id="second-row" class="row">
            <div class="col-md-6 col-12">
                <div class="d-flex align-items-end justify-content-around">
                    <img id="cat-img" src="{{ asset('images/cat.png') }}" style="width: 200px; height:auto;" />
                    <div>
                        <div class="citation">
                            <div>
                                Qui mieux que vous sait ce qu'il vous faut ? Avec Lexidoo, c'est vous qui décidez de
                                mémoriser ou non chaque mot proposé !
                            </div>
                            <img src="{{ asset('images/v1.png') }}" />
                        </div>

                        <div class="citation">
                            <div>
                                Sans grammaire mais avec des mots, on peut se faire comprendre (l'inverse, bof !), alors
                                c'est parti !
                            </div>
                            <img src="{{ asset('images/v1.png') }}" />
                        </div>
                        <div style="text-align: right;">
                            <a href="/login" class="btn btn-primary btn-lg active start-btn" role="button"
                               aria-pressed="true">
                                Je veux commencer !
                            </a>
                        </div>

                    </div>
                </div>
            </div>
            <div id="girls-container" class="col-md-6" class="d-flex align-items-center justify-content-center">
                <img src="{{ asset('images/girls.png') }}" />
                <x-tarif-card :tarifs="$tarifs" />

            </div>
        </div>
    <div id="footer" class="text-center">
        <a href="cgu" target="_blank" style="display: inline-block; background : #0a4fd0; padding: 6px 16px; border: 1px solid #0a4fd0; border-radius: 25px;">
            CONDITIONS GENERALES D’ABONNEMENT ET D’UTILISATION
        </a>
    </div>
    </div>

    </body>
</html>
