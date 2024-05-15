@php
@endphp

<div class="price-table">
    @foreach($tarifs as $tarif)
        <div class="price-card">
            <h3 class="price-card-header">{{ $tarif->nom_offre }}</h3>
            <div class="price">{{ number_format($tarif->prix, 2) }} €</div>
            <p>{{ $tarif->description }}</p>
            <p>Durée: {{ $tarif->duree }}</p>
            @if(auth()->check())
                @if(auth()->user()->premium)
                    <a href="#" class="order-btn">Renouveler</a>
                @else
                    <a href="#" class="order-btn">M'abonner</a>
                @endif
            @endif
        </div>
    @endforeach
</div>
