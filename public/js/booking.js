document.addEventListener('DOMContentLoaded', function() {
    const quantityBtns = document.querySelectorAll('.quantity-btn');

    quantityBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input');
            const currentValue = parseInt(input.value);

            if (this.classList.contains('plus')) {
                if (currentValue < parseInt(input.max)) input.value = currentValue + 1;
            } else {
                if (currentValue > 0) input.value = currentValue - 1;
            }

            updateTotal();
        });
    });

    function updateTotal() {
        let total = 0;
        document.querySelectorAll('input[name^="quantities"]').forEach(input => {
            const ticketId = input.name.match(/\d+/)[0];
            const ticket = window.tickets.find(t => t.id == ticketId);
            total += ticket.price * parseInt(input.value);
        });
        document.getElementById('total-amount').textContent = `$${total.toFixed(2)}`;
    }
});
