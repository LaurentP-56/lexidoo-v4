<nav >
    <header >
        <x-application-logo  />
        <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
            <x-nav-link :href="route('login')" class="btn btn-primary" >Se connecter</x-nav-link>
            <x-nav-link :href="route('register')" class="btn btn-primary">S'inscrire</x-nav-link>
        </div>
    </header>
</nav>
