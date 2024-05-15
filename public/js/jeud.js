document.addEventListener('DOMContentLoaded', function() {
    const themeSelect = document.getElementById('theme_id');
    const sousThemeSelect = document.getElementById('sous_theme_id');
    const categorieSelect = document.getElementById('categorie_id');
    const sousCategorieSelect = document.getElementById('sous_categorie_id');

    // Fonction pour mettre à jour les options des sélecteurs
    function updateSelectOptions(selectElement, options, defaultText = "Choisissez une option") {
        selectElement.innerHTML = `<option value="">${defaultText}</option>`; // Réinitialiser
        options.forEach(option => {
            const optionElement = new Option(option.nom || option.name, option.id);
            selectElement.add(optionElement);
        });
    }

    themeSelect.addEventListener('change', function() {
        const themeId = parseInt(this.value);
        // Filtre pour sous-thèmes basé sur parent_id
        const filteredSousThemes = window.sousThemes.filter(st => st.parent_id === themeId);
        updateSelectOptions(sousThemeSelect, filteredSousThemes, 'Choisissez un sous-thème');

        // Filtre pour catégories basé sur theme_id
        const filteredCategories = window.categories.filter(c => c.theme_id === themeId);
        updateSelectOptions(categorieSelect, filteredCategories, 'Choisissez une catégorie');
        sousCategorieSelect.innerHTML = `<option value="">Choisissez une sous-catégorie</option>`; // Réinitialiser sous-catégories
    });

    sousThemeSelect.addEventListener('change', function() {
        const sousThemeId = parseInt(this.value);
        // Filtre pour catégories basé également sur theme_id (sous-thèmes ont un theme_id)
        const filteredCategories = window.categories.filter(c => c.theme_id === sousThemeId);
        updateSelectOptions(categorieSelect, filteredCategories, 'Choisissez une catégorie');
        sousCategorieSelect.innerHTML = `<option value="">Choisissez une sous-catégorie</option>`; // Réinitialiser sous-catégories
    });

    categorieSelect.addEventListener('change', function() {
        const categorieId = parseInt(this.value);
        // Filtre pour sous-catégories basé sur categorie_theme_id
        const filteredSousCategories = window.sousCategories.filter(sc => sc.categorie_theme_id === categorieId);
        updateSelectOptions(sousCategorieSelect, filteredSousCategories, 'Choisissez une sous-catégorie');
    });
});
