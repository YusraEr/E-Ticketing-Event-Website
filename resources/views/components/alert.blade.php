<div class="fixed top-20 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-xl mx-auto pointer-events-none">
    @if(session('success'))
        <div class="p-4 mb-4 text-sm text-green-400 bg-gray-800/90 border border-green-600 rounded-lg backdrop-blur-sm alert-dismiss pointer-events-auto" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 mb-4 text-sm text-red-400 bg-gray-800/90 border border-red-600 rounded-lg backdrop-blur-sm alert-dismiss pointer-events-auto" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @if(session('warning'))
        <div class="p-4 mb-4 text-sm text-yellow-400 bg-gray-800/90 border border-yellow-600 rounded-lg backdrop-blur-sm alert-dismiss pointer-events-auto" role="alert">
            {{ session('warning') }}
        </div>
    @endif

    @if(session('info'))
        <div class="p-4 mb-4 text-sm text-blue-400 bg-gray-800/90 border border-blue-600 rounded-lg backdrop-blur-sm alert-dismiss pointer-events-auto" role="alert">
            {{ session('info') }}
        </div>
    @endif

    <div class="alert-container"></div>
</div>

<script>
    function showAlert(message, type) {
        const alertContainer = document.querySelector('.alert-container');
        const alertHTML = `
            <div class="p-4 mb-4 text-sm bg-gray-800/90 backdrop-blur-sm alert-dismiss rounded-lg border pointer-events-auto
                ${type === 'success' ? 'text-green-400 border-green-600' : ''}
                ${type === 'error' ? 'text-red-400 border-red-600' : ''}
                ${type === 'warning' ? 'text-yellow-400 border-yellow-600' : ''}
                ${type === 'info' ? 'text-blue-400 border-blue-600' : ''}"
                role="alert">
                ${message}
            </div>
        `;

        alertContainer.innerHTML = alertHTML;
        const newAlert = alertContainer.querySelector('.alert-dismiss');

        // Apply fade in/out effect
        newAlert.style.opacity = '0';
        setTimeout(() => {
            newAlert.style.transition = 'opacity 0.5s ease-in-out';
            newAlert.style.opacity = '1';

            setTimeout(() => {
                newAlert.style.opacity = '0';

                setTimeout(() => {
                    newAlert.remove();
                }, 500);
            }, 3000);
        }, 100);
    }

    // Original alert handling
    document.addEventListener('DOMContentLoaded', function() {

        const alerts = document.querySelectorAll('.alert-dismiss');
        alerts.forEach(alert => {
            // Add fade in effect
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s ease-in-out';
                alert.style.opacity = '1';
            }, 100);

            // Auto dismiss after 3 seconds
            setTimeout(() => {
                alert.style.opacity = '0';
                setTimeout(() => {
                    alert.remove();
                }, 500);
            }, 3000);
        });
    });
</script>



