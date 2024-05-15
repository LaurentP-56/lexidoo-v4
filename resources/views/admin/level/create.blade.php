<x-adminapp>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2>Ajouter un Nouveau Niveau</h2>
            <form action="{{ route('admin.levels.store') }}" method="POST">
                @csrf
                <div>
                    <label for="label">Label:</label>
                    <input type="text" id="label" name="label" required>
                </div>
                <div>
                    <label for="sub_label">Sous-label:</label>
                    <input type="text" id="sub_label" name="sub_label">
                </div>
                <div>
                    <label for="classe">Classe:</label>
                    <input type="text" id="classe" name="classe">
                </div>
                <button type="submit">Ajouter</button>
            </form>
        </div>
    </div>
</x-adminapp>
