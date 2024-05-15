{{-- jeu/steps/categorie.blade.php --}}
<div id="categorieSection" class="step-section" style="display:none;">
    <h2>Choisissez une catégorie :</h2>
    @foreach($categories as $categorie)
        <button class="step-btn" onclick="selectCategorie({{ $categorie->id }})">{{ $categorie->name }}</button>
    @endforeach
</div>
