document.addEventListener('DOMContentLoaded', function() {
    const carousel = new bootstrap.Carousel(document.getElementById('jeuCarousel'), {
        wrap: false
    });

    const selectElements = document.querySelectorAll('select');

    selectElements.forEach(select => {
        select.addEventListener('change', () => {
            carousel.next();
        });
    });
});
