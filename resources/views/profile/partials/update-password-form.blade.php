<section>
    <header>
        <h2 class="text-sm font-sm text-gray-900 dark:text-gray-100">
            {{ __('Mettre à jour le mot de passe') }}
        </h2>

        <p class=" text-xs text-gray-600 dark:text-gray-400">
            {{ __('Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester en sécurité.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Mot de passe actuel')" class="text-xs leading-6" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 text-xs block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="sm:col-span-2">
            <x-input-label for="update_password_password" :value="__('Nouveau mot de passe')" class="block text-xs" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 text-xs block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-xs" />
        </div>

        <div class="sm:col-span-2">
            <x-input-label for="update_password_password_confirmation" :value="__('Confirmer votre nouveau mot de passe')" class="block text-xs"/>
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 text-xs block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-xs" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Sauvegarder') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-xs text-gray-600 dark:text-gray-400"
                >{{ __('Sauvegarder.') }}</p>
            @endif
        </div>
    </form>
</section>
