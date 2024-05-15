// userlist

document.addEventListener('DOMContentLoaded', function () {
    const premiumStatusCells = document.querySelectorAll('.premium-status');

    premiumStatusCells.forEach(cell => {
        cell.addEventListener('click', function () {
            const userId = this.dataset.userId;
            fetch(`/admin/update-premium/${userId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({}),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.newStatus) {
                        this.innerHTML = 'Oui';
                    } else {
                        this.innerHTML = 'Non';
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });
});
