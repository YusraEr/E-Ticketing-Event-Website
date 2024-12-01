document.addEventListener('DOMContentLoaded', function() {
    console.log('Edit page loaded'); // Tambahkan log
    const handler = new EventFormHandler('event-form');

    // Log elements untuk debugging
    console.log('Image input:', handler.imageInput);
    console.log('Crop modal:', handler.cropModal);
    console.log('Preview:', handler.imagePreview);

    if (document.querySelector('#image-preview img')) {
        const currentImageUrl = document.querySelector('#image-preview img').src;
        handler.setInitialImage(currentImageUrl);
        document.getElementById('image-input').removeAttribute('required');
    }

    // Init char count
    const description = document.getElementById('description');
    const charCount = document.getElementById('char-count');
    if (description && charCount) {
        const initialCount = description.value.length;
        charCount.textContent = initialCount;
        if (initialCount > 1500) {
            charCount.classList.add('text-red-500');
        }
    }
});


