{{-- jeu/steps/themes.blade.php --}}
<div id="themesSection" class="step-section" style="display:none;">
    <h2>Choisissez un thème :</h2>
    @foreach($themes as $theme)
        <button class="step-btn" onclick="selectTheme({{ $theme->id }})">{{ $theme->name }}</button>
    @endforeach
</div>
