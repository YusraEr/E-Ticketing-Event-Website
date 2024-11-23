document.addEventListener('DOMContentLoaded', function() {
    const PROCESSING_FEE_RATE = 0.05; // 5% processing fee

    function updateTotals() {
        let subtotal = 0;
        const selectedTickets = {};

        document.querySelectorAll('.quantity-input').forEach(input => {
            const quantity = parseInt(input.value) || 0;
            const ticketId = input.dataset.ticketId;
            const ticket = tickets.find(t => t.id == ticketId);

            if (quantity > 0) {
                subtotal += ticket.price * quantity;
                selectedTickets[ticketId] = {
                    name: ticket.name,
                    quantity: quantity,
                    price: ticket.price,
                    total: ticket.price * quantity
                };
            }
        });

        const processingFee = subtotal * PROCESSING_FEE_RATE;
        const total = subtotal + processingFee;

        // Update summary display
        document.getElementById('subtotal').textContent = `$${subtotal.toFixed(2)}`;
        document.getElementById('fee').textContent = `$${processingFee.toFixed(2)}`;
        document.getElementById('total-amount').textContent = `$${total.toFixed(2)}`;

        // Update selected tickets summary
        const selectedTicketsDiv = document.getElementById('selected-tickets');
        selectedTicketsDiv.innerHTML = Object.values(selectedTickets).map(ticket => `
            <div class="py-2">
                <div class="flex justify-between">
                    <span class="text-gray-700">${ticket.name} x ${ticket.quantity}</span>
                    <span class="text-gray-900">$${ticket.total.toFixed(2)}</span>
                </div>
            </div>
        `).join('');
    }

    // Handle quantity buttons
    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const ticketId = this.dataset.ticketId;
            const input = document.querySelector(`input[data-ticket-id="${ticketId}"]`);
            const currentValue = parseInt(input.value) || 0;
            const maxValue = parseInt(input.max) || 999;

            if (this.classList.contains('plus') && currentValue < maxValue) {
                input.value = currentValue + 1;
            } else if (this.classList.contains('minus') && currentValue > 0) {
                input.value = currentValue - 1;
            }

            updateTotals();
        });
    });

    // Handle direct input changes
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', updateTotals);
    });

    // Initial calculation
    updateTotals();
});
