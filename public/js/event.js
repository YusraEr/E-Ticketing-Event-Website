document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image-input');
    const imagePreview = document.getElementById('image-preview');
    const uploadInstructions = document.getElementById('upload-instructions');
    const previewImage = imagePreview.querySelector('img');
    const dropZone = imageInput.closest('div.border-2');
    const cropModal = document.getElementById('cropModal');
    const cropperImage = document.getElementById('cropperImage');
    let cropper = null;

    // Form progress tracking
    const form = document.getElementById('event-form');
    const progressBar = document.getElementById('form-progress');
    const requiredFields = form.querySelectorAll('[required]');
    const totalFields = requiredFields.length;

    // Enhanced Progress Tracking
    function updateProgress() {
        const filledFields = Array.from(requiredFields).filter(field => {
            if (field.type === 'file') {
                return imagePreview.classList.contains('hidden') === false;
            }
            return field.value.trim() !== '';
        }).length;

        const progress = Math.round((filledFields / totalFields) * 100);
        progressBar.style.width = `${progress}%`;
        document.getElementById('progress-text').textContent = `${progress}% Complete`;

        // Add visual feedback
        if (progress === 100) {
            progressBar.classList.add('bg-green-600');
            progressBar.classList.remove('bg-blue-600');
        } else {
            progressBar.classList.add('bg-blue-600');
            progressBar.classList.remove('bg-green-600');
        }
    }

    // Character Counter for Description
    const description = document.getElementById('description');
    const charCount = document.getElementById('char-count');

    description.addEventListener('input', function() {
        const remaining = this.value.length;
        charCount.textContent = remaining;

        if (remaining > 400) {
            charCount.classList.add('text-yellow-600');
        } else {
            charCount.classList.remove('text-yellow-600');
        }
    });

    // Enhanced Form Validation Feedback
    requiredFields.forEach(field => {
        field.addEventListener('invalid', function(e) {
            e.preventDefault();
            this.classList.add('border-red-300');

            // Add custom validation message
            let message = 'This field is required';
            if (this.type === 'datetime-local') {
                message = 'Please select a future date and time';
            }

            // Remove existing messages
            const existingMessage = this.parentNode.querySelector('.error-message');
            if (existingMessage) existingMessage.remove();

            // Add new message
            const errorMessage = document.createElement('p');
            errorMessage.className = 'error-message text-xs text-red-600 mt-1';
            errorMessage.textContent = message;
            this.parentNode.appendChild(errorMessage);
        });

        field.addEventListener('input', function() {
            this.classList.remove('border-red-300');
            const errorMessage = this.parentNode.querySelector('.error-message');
            if (errorMessage) errorMessage.remove();
        });
    });

    requiredFields.forEach(field => {
        field.addEventListener('input', updateProgress);
        field.addEventListener('change', updateProgress);
    });

    // Form submission handling
    form.addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submit-btn');
        submitBtn.classList.add('loading');
    });

    function initCropper(imageUrl) {
        cropModal.classList.remove('hidden');
        cropperImage.src = imageUrl;

        cropper = new Cropper(cropperImage, {
            aspectRatio: 16 / 9,
            viewMode: 1,
            minContainerHeight: 300,
            maxContainerHeight: window.innerHeight * 0.7,
            minContainerWidth: Math.min(600, window.innerWidth * 0.9),
            responsive: true,
            restore: true,
            center: true,
            autoCropArea: 0.8,
            guides: true
        });
    }

    function handleImageDisplay(file) {
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                initCropper(e.target.result);
            }
            reader.readAsDataURL(file);
        }
    }

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        handleImageDisplay(file);
    });

    // Click on preview to change image
    imagePreview.addEventListener('click', () => {
        imageInput.click();
    });

    // Drag and drop functionality
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropZone.classList.add('border-blue-500', 'bg-blue-50');
    }

    function unhighlight(e) {
        dropZone.classList.remove('border-blue-500', 'bg-blue-50');
    }

    dropZone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const file = dt.files[0];
        if (file) {
            imageInput.files = dt.files;
            handleImageDisplay(file);
        }
    }

    // Modal controls
    document.getElementById('closeCropModal').addEventListener('click', () => {
        cropModal.classList.add('hidden');
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
    });

    document.getElementById('cancelCrop').addEventListener('click', () => {
        cropModal.classList.add('hidden');
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
    });

    document.getElementById('applyCrop').addEventListener('click', () => {
        if (cropper) {
            const croppedCanvas = cropper.getCroppedCanvas({
                width: 1280,
                height: 720,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high'
            });

            // Update preview
            const previewUrl = croppedCanvas.toDataURL('image/jpeg', 1.0);
            previewImage.src = previewUrl;
            imagePreview.classList.remove('hidden');
            uploadInstructions.classList.add('hidden');

            // Convert canvas to blob and create file
            croppedCanvas.toBlob((blob) => {
                const file = new File([blob], 'event-image.jpg', { type: 'image/jpeg' });

                // Create a new FileList-like object
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);

                // Update the original file input
                imageInput.files = dataTransfer.files;

                // Also store base64 in hidden input as backup
                document.getElementById('cropped_image').value = previewUrl;
            }, 'image/jpeg', 0.9);

            cropModal.classList.add('hidden');
            cropper.destroy();
            cropper = null;
        }
    });

    // Ticket Categories Management
    const ticketCategories = document.getElementById('ticket-categories');
    const addCategoryBtn = document.getElementById('add-category');

    addCategoryBtn.addEventListener('click', () => {
        if (ticketCategories.children.length >= 3) {
            alert('Maximum of 3 ticket categories allowed');
            return;
        }

        const template = ticketCategories.children[0].cloneNode(true);
        const inputs = template.querySelectorAll('input');
        inputs.forEach(input => input.value = '');

        const removeBtn = template.querySelector('.remove-category');
        removeBtn.style.display = 'block';
        removeBtn.addEventListener('click', () => {
            template.remove();
            updateRemoveButtons();
        });

        ticketCategories.appendChild(template);
        updateRemoveButtons();
    });

    // Show remove button if there's more than one category
    const updateRemoveButtons = () => {
        const categories = ticketCategories.children;
        Array.from(categories).forEach((category, index) => {
            const removeBtn = category.querySelector('.remove-category');
            removeBtn.style.display = categories.length > 1 ? 'block' : 'none';
        });

        // Update add button visibility
        addCategoryBtn.style.display = categories.length >= 3 ? 'none' : 'block';
    };

    // Initial setup
    updateRemoveButtons();
});
