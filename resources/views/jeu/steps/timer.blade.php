{{-- jeu/steps/timer.blade.php --}}
<div id="timerSection" class="step-section" style="display:none;">
    <h2>Choisissez votre temps d'apprentissage quotidien :</h2>
    @foreach($tempsOptions as $option)
        <button class="step-btn" onclick="selectTimer({{ $option['id'] }})">{{ $option['duree'] }}</button>
    @endforeach
</div>
