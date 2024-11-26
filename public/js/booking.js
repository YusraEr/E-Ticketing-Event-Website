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
        document.getElementById('subtotal').textContent = `Rp. ${subtotal.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
        document.getElementById('fee').textContent = `Rp. ${processingFee.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
        document.getElementById('total-amount').textContent = `Rp. ${total.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;

        // Update selected tickets summary
        const selectedTicketsDiv = document.getElementById('selected-tickets');
        selectedTicketsDiv.innerHTML = Object.values(selectedTickets).map(ticket => `
            <div class="py-2">
                <div class="flex justify-between">
                    <span class="text-teal-500">${ticket.name} x ${ticket.quantity}</span>
                    <span class="text-teal-300">Rp. ${ticket.total.toFixed(2)}</span>
                </div>
            </div>
        `).join('');
    }

    // Function to show warning message
    function showWarning(message) {
        // Remove any existing warnings
        const existingWarning = document.querySelector('.warning-message');
        if (existingWarning) {
            existingWarning.remove();
        }

        const warningDiv = document.createElement('div');
        warningDiv.className = 'warning-message fixed top-4 left-1/2 transform -translate-x-1/2 z-50 animate-fade-in-down';
        warningDiv.innerHTML = `
            <div class="bg-slate-800/95 backdrop-blur-sm text-teal-400 px-6 py-3 rounded-lg shadow-lg border border-red-500/50
                        flex items-center space-x-3">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <span>${message}</span>
            </div>
        `;
        document.body.appendChild(warningDiv);

        setTimeout(() => {
            warningDiv.remove();
        }, 3000);
    }

    // Handle quantity buttons with availability check
    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const ticketId = this.dataset.ticketId;
            const input = document.querySelector(`input[data-ticket-id="${ticketId}"]`);
            const currentValue = parseInt(input.value) || 0;
            const maxValue = parseInt(input.max);
            const ticket = tickets.find(t => t.id == ticketId);

            if (this.classList.contains('plus')) {
                if (currentValue < maxValue) {
                    input.value = currentValue + 1;
                } else {
                    showWarning(`Only ${maxValue} tickets available for ${ticket.name}`);
                }
            } else if (this.classList.contains('minus') && currentValue > 0) {
                input.value = currentValue - 1;
            }

            updateTotals();
            updateSubmitButton();
        });
    });

    // Handle direct input changes with validation
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            const maxValue = parseInt(this.max);
            const currentValue = parseInt(this.value) || 0;
            const ticketId = this.dataset.ticketId;
            const ticket = tickets.find(t => t.id == ticketId);

            if (currentValue > maxValue) {
                this.value = maxValue;
                showWarning(`Only ${maxValue} tickets available for ${ticket.name}`);
            } else if (currentValue < 0) {
                this.value = 0;
            }

            updateTotals();
            updateSubmitButton();
        });
    });

    function updateSubmitButton() {
        const quantities = document.querySelectorAll('.quantity-input');
        const submitButton = document.getElementById('submit-booking');
        const errorDiv = document.getElementById('booking-error');

        let totalQuantity = 0;
        quantities.forEach(input => {
            totalQuantity += parseInt(input.value) || 0;
        });

        if (totalQuantity > 0) {
            submitButton.disabled = false;
            submitButton.classList.remove('cursor-not-allowed', 'opacity-50', 'from-teal-500/50', 'to-emerald-500/50');
            submitButton.classList.add('from-teal-500', 'to-emerald-500', 'hover:from-teal-600', 'hover:to-emerald-600', 'hover:-translate-y-0.5');
            errorDiv.classList.add('hidden');
        } else {
            submitButton.disabled = true;
            submitButton.classList.add('cursor-not-allowed', 'opacity-50', 'from-teal-500/50', 'to-emerald-500/50');
            submitButton.classList.remove('from-teal-500', 'to-emerald-500', 'hover:from-teal-600', 'hover:to-emerald-600', 'hover:-translate-y-0.5');
            errorDiv.classList.remove('hidden');
        }
    }

    // Add this line to your existing quantity change handlers
    document.querySelectorAll('.quantity-input, .quantity-btn').forEach(element => {
        element.addEventListener('change', updateSubmitButton);
        element.addEventListener('click', updateSubmitButton);
    });

    // Call on page load
    updateSubmitButton();

    // Update the CSS animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fade-in-down {
            0% {
                opacity: 0;
                transform: translate(-50%, -20px);
            }
            100% {
                opacity: 1;
                transform: translate(-50%, 0);
            }
        }
        .animate-fade-in-down {

            animation: fade-in-down 0.3s ease-out;
        }
    `;
    document.head.appendChild(style);

    // Initial calculation
    updateTotals();
});

