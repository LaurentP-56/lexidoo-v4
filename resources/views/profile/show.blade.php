@php
    $user = Auth::user();
    $status = $user->premium ? 'Premium' : 'Non Abonné';
    $offre = '';

    if ($user->premium) {
        switch ($user->offre_premium) {
            case 1:
                $offre = 'Mensuelle';
                break;
            case 2:
                $offre = 'Trimestrielle';
                break;
            case 3:
                $offre = 'Annuelle';
                break;
            default:
                $offre = 'Illimité';
                break;
        }
    }
    $tarifs = App\Models\Tarifs::all(); // Ce n'est PAS une bonne pratique
@endphp

<x-app-layout>
    <div class="containere">
        <div id="CTAS">
            @if(Auth::user()->premium == 0)
                <!-- Cette div class CTA n'apparaît que si premium = 0 -->
                <div class="CTA">
                    <h1>M'abonner</h1>
                </div>
                <!-- Fin de la div -->
            @endif
        </div>
        <div class="leftbox">
            <menu>
                <a id="profile" class="active"><i class="fa fa-user"></i>Mon Profil</a>
                <a id="settings"><i class="fa fa-cog"></i>Modifier mon profil</a>
                <a id="subscription"><i class="fa fa-tv"></i>Abonnement</a>
                <a id="privacy"><i class="fa fa-tasks"></i>Déconnexion</a>

            </menu>
        </div>
        <div class="rightbox">
            <div class="profile">
                <h1>Mon Profil</h1>
                <h2>Nom</h2>
                <p>{{ Auth::user()->nom }}</p>
                <h2>Prénom</h2>
                <p>{{ Auth::user()->prenom }}</p>
                <h2>Email</h2>
                <p>{{ Auth::user()->email }}</p>
                <h2>Status du compte</h2>
                @if($user->premium)
                    <p>Vous êtes {{$status}}, avec l'offre {{$offre}}</p>
                    @if(!is_null($user->finDuPremium))
                        <h2>Date de fin du premium</h2>
                        <p>{{ $user->finDuPremium->format('d/m/Y') }}</p>
                    @else
                        <p>Votre abonnement est actuellement sans date d'expiration spécifiée.</p>
                    @endif
                @else
                    <p>Vous êtes {{$status}}</p>
                @endif
            </div>



                <div class="subscription noshow">
                    <x-tarif-card :tarifs="$tarifs" />
                </div>

                <div class="settings group noshow">
                    <div x-data="{ tab: 'profile' }" class="settings noshow">
                        <div class="tabs ">
                            <button :class="{ 'active': tab === 'profile' }" @click="tab = 'profile'">Profil</button>
                            <button :class="{ 'active': tab === 'password' }" @click="tab = 'password'">Mot de Passe</button>
                            <button :class="{ 'active': tab === 'delete' }" @click="tab = 'delete'">Supprimer le Compte</button>
                        </div>

                        <div class="tab-content">
                            <div x-show="tab === 'profile'" >
                                <!-- Contenu pour 'Modifier Mon Profil' -->
                                <div class="max-w-xl">
                                    @include('profile.partials.update-profile-information-form')
                                </div>
                            </div>

                            <div x-show="tab === 'password'">
                                <!-- Contenu pour 'Changer le Mot de Passe' -->
                                <div class="max-w-xl">
                                    @include('profile.partials.update-password-form')
                                </div>
                            </div>

                            <div x-show="tab === 'delete'" >
                                <!-- Contenu pour 'Supprimer le Compte' -->
                                <div class="max-w-xl">
                                    @include('profile.partials.delete-user-form')
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @vite(['resources/js/profile.js'])
</x-app-layout>
