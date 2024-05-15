function selectTime(selectedId) {
    const buttons = document.querySelectorAll('.temps-button');
    buttons.forEach(button => {
        const id = button.getAttribute('data-id');
        if (parseInt(id) === selectedId) {
            button.classList.add('active');
        } else {
            button.classList.remove('active');
        }
    });
}
