document.addEventListener('DOMContentLoaded', function() {
    // Initialize Hero Swiper
    if (document.querySelector('.hero-swiper')) {
        const heroSwiper = new Swiper('.hero-swiper', {
            loop: true,
            autoplay: {
                delay: 5000,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    }

    // Initialize Popular Events Swiper
    if (document.querySelector('.popular-events')) {
        const popularSwiper = new Swiper('.popular-events', {
            slidesPerView: 1,
            spaceBetween: 20,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 3,
                },
                1024: {
                    slidesPerView: 4,
                },
            },
        });
    }

    // Event Filters
    const filterElements = document.querySelectorAll('#category-filter, #location-filter, #date-filter, #sort-by');

    filterElements.forEach(element => {
        element.addEventListener('change', function() {
            let category = document.getElementById('category-filter')?.value;
            let location = document.getElementById('location-filter')?.value;
            let date = document.getElementById('date-filter')?.value;
            let sortBy = document.getElementById('sort-by')?.value;

            let url = new URL(window.location.href);
            let params = url.searchParams;

            updateUrlParam(params, 'category', category);
            updateUrlParam(params, 'location', location);
            updateUrlParam(params, 'date', date);
            updateUrlParam(params, 'sort', sortBy);

            window.location.href = url.toString();
        });
    });

    function updateUrlParam(params, key, value) {
        if (value) {
            params.set(key, value);
        } else {
            params.delete(key);
        }
    }
});

// Shared utility functions for event pages


function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(amount);
}

function validateImageFile(file) {
    const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
    const maxSize = 10 * 1024 * 1024; // 10MB

    if (!validTypes.includes(file.type)) {
        return 'Please upload a valid image file (JPG, PNG, or GIF)';
    }

    if (file.size > maxSize) {
        return 'Image file size must be less than 10MB';
    }

    return null;
}

// Event Form Handler Class
class EventFormHandler {
    constructor(formId) {
        this.form = document.getElementById(formId);
        this.imageInput = document.getElementById('image-input');
        this.imagePreview = document.getElementById('image-preview');
        this.uploadInstructions = document.getElementById('upload-instructions');
        this.cropModal = document.getElementById('cropModal');
        this.cropperImage = document.getElementById('cropperImage');

        this.applyCropBtn = document.getElementById('applyCrop');
        this.cancelCropBtn = document.getElementById('cancelCrop');
        this.closeCropModalBtn = document.getElementById('closeCropModal');
        this.progressBar = document.getElementById('form-progress');
        this.progressText = document.getElementById('progress-text');
        this.cropper = null;
        this.MAX_TICKETS = 3; // Add this constant
        this.currentImage = null;
        this.originalImage = null; // Add this line

        this.initializeEventListeners();
    }

    setInitialImage(imageUrl) {
        this.currentImage = imageUrl;
        this.originalImage = imageUrl; // Save original image URL

        // Create img element if it doesn't exist
        if (!this.imagePreview.querySelector('img')) {
            const img = document.createElement('img');
            img.className = 'w-full aspect-video object-cover rounded-xl';
            img.alt = 'Preview';
            this.imagePreview.querySelector('.relative').appendChild(img);
        }
    }

    initializeEventListeners() {
        // Add category button
        document.getElementById('add-category').addEventListener('click', () => this.addCategory());

        // Remove category button
        document.getElementById('ticket-categories').addEventListener('click', (e) => {
            if (e.target.closest('.remove-category')) {
                this.removeCategory(e);
            }
        });

        // Image upload handling
        this.imageInput.addEventListener('change', (e) => this.handleImageUpload(e));
        this.imagePreview.addEventListener('click', () => this.imageInput.click());

        // Crop modal actions
        [this.cancelCropBtn, this.closeCropModalBtn].forEach(btn => {
            btn.addEventListener('click', () => this.closeCropModal());
        });
        this.applyCropBtn.addEventListener('click', () => this.applyCrop());

        // Character count for description
        const description = document.getElementById('description');
        const charCount = document.getElementById('char-count');
        if (description && charCount) {
            description.addEventListener('input', () => this.updateCharCount(description, charCount));
            // Initial character count
            this.updateCharCount(description, charCount);
        }

        // Form validation
        this.form.addEventListener('input', () => this.updateFormProgress());
        this.form.addEventListener('submit', (e) => this.validateForm(e));

        // Initialize
        this.updateRemoveButtons();
        this.updateFormProgress();
    }

    // Add all the methods from create.js here
    addCategory() {
        const categories = document.querySelectorAll('.ticket-category');
        if (categories.length >= this.MAX_TICKETS) {
            alert('Maximum of 3 ticket categories allowed');
            return;
        }
        const template = document.querySelector('.ticket-category').cloneNode(true);
        const inputs = template.querySelectorAll('input');
        inputs.forEach(input => input.value = '');
        document.getElementById('ticket-categories').appendChild(template);
        this.updateRemoveButtons();

        // Disable add button if max reached
        const addButton = document.getElementById('add-category');
        if (categories.length + 1 >= this.MAX_TICKETS) {
            addButton.classList.add('opacity-50', 'cursor-not-allowed');
            addButton.disabled = true;
        }
    }

    removeCategory(e) {
        const categories = document.querySelectorAll('.ticket-category');
        if (categories.length > 1) {
            e.target.closest('.ticket-category').remove();
            // Re-enable add button if below max
            const addButton = document.getElementById('add-category');
            if (categories.length <= this.MAX_TICKETS) {
                addButton.classList.remove('opacity-50', 'cursor-not-allowed');
                addButton.disabled = false;
            }
        }
        this.updateRemoveButtons();
    }

    updateRemoveButtons() {
        const categories = document.querySelectorAll('.ticket-category');
        categories.forEach(category => {
            const removeBtn = category.querySelector('.remove-category');
            if (removeBtn) {

                removeBtn.style.display = categories.length > 1 ? 'flex' : 'none';
            }
        });
    }

    handleImageUpload(e) {
        console.log('Image upload triggered'); // Tambahkan log
        if (e.target.files && e.target.files[0]) {
            const file = e.target.files[0];
            console.log('File selected:', file); // Tambahkan log
            const error = validateImageFile(file);

            if (error) {
                alert(error);
                e.target.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = (e) => {
                console.log('File loaded'); // Tambahkan log
                this.cropperImage.src = e.target.result;
                this.cropModal.classList.remove('hidden');
                if (this.cropper) {
                    this.cropper.destroy();
                }
                this.cropper = new Cropper(this.cropperImage, {
                    aspectRatio: 16 / 9,
                    viewMode: 2,
                    autoCropArea: 1
                });
            };
            reader.readAsDataURL(file);
        }
    }

    closeCropModal() {
        this.cropModal.classList.add('hidden');
        this.imageInput.value = '';
        if (this.cropper) {
            this.cropper.destroy();
            this.cropper = null;
        }

        // Restore either current image or original image
        const preview = this.imagePreview.querySelector('img');
        if (preview) {
            preview.src = this.currentImage || this.originalImage;
        }
    }

    applyCrop() {
        if (!this.cropper) return;

        const croppedCanvas = this.cropper.getCroppedCanvas();

        croppedCanvas.toBlob((blob) => {
            const croppedFile = new File([blob], 'cropped_image.jpg', { type: 'image/jpeg' });

            // Create DataTransfer object
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(croppedFile);

            // Update file input
            this.imageInput.files = dataTransfer.files;

            // Update preview and hidden input
            const preview = this.imagePreview.querySelector('img');
            const croppedImageUrl = croppedCanvas.toDataURL('image/jpeg', 0.9);

            if (preview) {
                preview.src = croppedImageUrl;
            }

            document.getElementById('cropped_image').value = croppedImageUrl;
            this.currentImage = croppedImageUrl;

            // Show preview
            this.imagePreview.classList.remove('hidden');
            this.uploadInstructions.classList.add('hidden');

            // Close modal and cleanup
            this.cropModal.classList.add('hidden');
            this.cropper.destroy();
            this.cropper = null;

            this.updateFormProgress();
        }, 'image/jpeg', 0.9);
    }

    updateCharCount(description, charCount) {
        const count = description.value.length;
        charCount.textContent = count;
        charCount.classList.toggle('text-red-500', count > 1500);
    }

    updateFormProgress() {
        const requiredFields = this.form.querySelectorAll('input[required], select[required], textarea[required]');
        let filledFields = 0;

        requiredFields.forEach(field => {
            if (field.type === 'file') {
                if (this.imagePreview && !this.imagePreview.classList.contains('hidden')) {
                    filledFields++;
                }
            } else if (field.value.trim() !== '') {
                filledFields++;
            }
        });

        const progress = (filledFields / requiredFields.length) * 100;
        this.progressBar.style.width = `${progress}%`;
        this.progressText.textContent = `${Math.round(progress)}% Complete`;
    }

    validateForm(e) {
        const requiredFields = this.form.querySelectorAll('input[required], select[required], textarea[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (field.type === 'file') {
                if (this.imagePreview.classList.contains('hidden')) {
                    isValid = false;
                    field.classList.add('border-red-500');
                }
            } else if (!field.value.trim()) {
                isValid = false;
                field.classList.add('border-red-500');
            } else {
                field.classList.remove('border-red-500');
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Please fill in all required fields');
        }
    }
}

// Export functions if using modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        formatCurrency,
        validateImageFile
    };
}



