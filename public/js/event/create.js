document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image-input');
    const imagePreview = document.getElementById('image-preview');
    const uploadInstructions = document.getElementById('upload-instructions');
    const previewImage = imagePreview.querySelector('img');
    const cropModal = document.getElementById('cropModal');
    const cropperImage = document.getElementById('cropperImage');
    let cropper = null;

    // Initialize Cropper
    function initCropper(imageUrl) {
        cropModal.classList.remove('hidden');
        cropperImage.src = imageUrl;

        if (cropper) {
            cropper.destroy();
        }

        cropper = new Cropper(cropperImage, {
            aspectRatio: 16 / 9,
            viewMode: 1,
            autoCropArea: 1,
            responsive: true,
            crop(event) {
                // You can log cropping details here if needed
                console.log(event.detail);
            }
        });
    }

    // Handle Image Upload
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                initCropper(e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

    // Click on preview to change image
    imagePreview.addEventListener('click', () => imageInput.click());

    // Modal Controls
    document.getElementById('closeCropModal').addEventListener('click', closeCropModal);
    document.getElementById('cancelCrop').addEventListener('click', closeCropModal);

    function closeCropModal() {
        cropModal.classList.add('hidden');
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
    }

    // Apply Crop
    document.getElementById('applyCrop').addEventListener('click', function() {
        if (!cropper) return;

        const canvas = cropper.getCroppedCanvas({
            width: 1280,
            height: 720,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        });

        const croppedImageUrl = canvas.toDataURL('image/jpeg', 0.9);

        // Update preview
        previewImage.src = croppedImageUrl;
        imagePreview.classList.remove('hidden');
        uploadInstructions.classList.add('hidden');

        // Store cropped image data
        document.getElementById('cropped_image').value = croppedImageUrl;

        // Convert to Blob and update file input
        canvas.toBlob(function(blob) {
            const file = new File([blob], 'cropped-image.jpg', { type: 'image/jpeg' });
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            imageInput.files = dataTransfer.files;
        }, 'image/jpeg', 0.9);

        closeCropModal();
    });

    // Drag and Drop functionality
    const dropZone = document.querySelector('#upload-instructions');

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
        dropZone.classList.add('border-teal-500', 'bg-slate-700/50');
    }

    function unhighlight(e) {
        dropZone.classList.remove('border-teal-500', 'bg-slate-700/50');
    }

    dropZone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const file = dt.files[0];
        if (file && file.type.startsWith('image/')) {
            imageInput.files = dt.files;
            const reader = new FileReader();
            reader.onload = function(e) {
                initCropper(e.target.result);
            }
            reader.readAsDataURL(file);
        }
    }

    // Form progress tracking
    const form = document.getElementById('event-form');
    const progressBar = document.getElementById('form-progress');
    const requiredFields = form.querySelectorAll('[required]');
    const totalFields = requiredFields.length;

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

        if (progress === 100) {
            progressBar.classList.add('from-emerald-500', 'to-teal-500');
            progressBar.classList.remove('from-teal-500', 'to-emerald-500');
        } else {
            progressBar.classList.add('from-teal-500', 'to-emerald-500');
            progressBar.classList.remove('from-emerald-500', 'to-teal-500');
        }
    }

    // Character Counter for Description
    const description = document.getElementById('description');
    const charCount = document.getElementById('char-count');

    description.addEventListener('input', function() {
        const remaining = this.value.length;
        charCount.textContent = remaining;

        if (remaining > 400) {
            charCount.classList.add('text-yellow-400');
            charCount.classList.remove('text-gray-500');
        } else {
            charCount.classList.add('text-gray-500');
            charCount.classList.remove('text-yellow-400');
        }
    });

    // Form Validation Feedback
    requiredFields.forEach(field => {
        field.addEventListener('invalid', function(e) {
            e.preventDefault();
            this.classList.add('border-red-500');

            const message = this.type === 'datetime-local'
                ? 'Please select a future date and time'
                : 'This field is required';

            const existingMessage = this.parentNode.querySelector('.error-message');
            if (existingMessage) existingMessage.remove();

            const errorMessage = document.createElement('p');
            errorMessage.className = 'error-message text-xs text-red-500 mt-1';
            errorMessage.textContent = message;
            this.parentNode.appendChild(errorMessage);
        });

        field.addEventListener('input', function() {
            this.classList.remove('border-red-500');
            const errorMessage = this.parentNode.querySelector('.error-message');
            if (errorMessage) errorMessage.remove();
            updateProgress();
        });

        field.addEventListener('change', updateProgress);
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
        removeBtn.style.display = 'flex';
        removeBtn.addEventListener('click', () => {
            template.remove();
            updateRemoveButtons();
            updateProgress();
        });

        ticketCategories.appendChild(template);
        updateRemoveButtons();
        updateProgress();
    });

    function updateRemoveButtons() {
        const categories = ticketCategories.children;
        Array.from(categories).forEach(category => {
            const removeBtn = category.querySelector('.remove-category');
            removeBtn.style.display = categories.length > 1 ? 'flex' : 'none';
        });
        addCategoryBtn.style.display = categories.length >= 3 ? 'none' : 'flex';
    }

    // Initialize
    updateRemoveButtons();
    updateProgress();
});
