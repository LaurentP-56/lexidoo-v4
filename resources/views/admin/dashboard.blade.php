<?php
$userStatus = fn() => Auth::user()->isAdmin ? 'Admine' : (Auth::user()->premium ? 'Premium' : 'non abonné');
?>
<x-adminapp>
    <x-slot name="header" >
        <h2 class="text-center font-semibold text-xl text-emeral-500 dark:text-gray-200 leading-tight">
            {{ __('Tableau de borde  ') }} de {{Auth::user()->prenom}} {{Auth::user()->nom}}
        </h2>
    </x-slot>


                    {{ __(    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">"Vous êtes actuellement connecté en tant que ") }} {{$userStatus()}}
                </div>
            </div>
        </div>
    </div> )}}

</x-adminapp>
