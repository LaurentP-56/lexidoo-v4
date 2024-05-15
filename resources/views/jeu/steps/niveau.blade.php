{{-- jeu/steps/niveau.blade.php --}}
<div id="niveauSection" class="step-section">
    <h2>Choisissez un niveau :</h2>
    @foreach($levels as $level)
        <button class="step-btn" onclick="selectNiveau({{ $level->id }})">{{ $level->label }}</button>
    @endforeach
</div>
