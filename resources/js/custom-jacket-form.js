// Custom Jacket Form - Real-time Feedback and Validation
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('jacketForm');
    if (!form) return;

    // ========== CONFIGURATION ==========
    const colorHexMap = {
        'Black': '#1a1a1a',
        'Navy Blue': '#001f4d',
        'Forest Green': '#0b3d2c',
        'Burgundy': '#800020',
        'Cream': '#fffdd0',
        'Charcoal Gray': '#36454f',
    };

    const fieldLimits = {
        full_name: 255,
        email: 255,
        phone: 20,
        front_text: 50,
        custom_details: 1000,
    };

    // ========== REAL-TIME VALIDATION ==========
    const validateField = (field) => {
        const value = field.value.trim();
        const fieldName = field.name;
        let isValid = true;
        let errorMsg = '';

        // Required field check
        if (field.hasAttribute('required') && !value) {
            isValid = false;
            errorMsg = `${fieldName.replace(/_/g, ' ')} is required`;
        }

        // Email validation
        if (fieldName === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                isValid = false;
                errorMsg = 'Please enter a valid email address';
            }
        }

        // Phone validation
        if (fieldName === 'phone' && value) {
            const phoneRegex = /^\d{3}[-.]?\d{3}[-.]?\d{4}$/;
            if (!phoneRegex.test(value.replace(/[^0-9]/g, ''))) {
                isValid = false;
                errorMsg = 'Please enter a valid phone number (e.g., 555-012-0000)';
            }
        }

        // Character limit warning
        if (fieldLimits[fieldName] && value.length > fieldLimits[fieldName]) {
            isValid = false;
            errorMsg = `Max ${fieldLimits[fieldName]} characters`;
        }

        updateFieldFeedback(field, isValid, errorMsg);
        return isValid;
    };

    const updateFieldFeedback = (field, isValid, errorMsg) => {
        const wrapper = field.closest('div[class*="grid"]') || field.parentElement;
        let feedbackEl = wrapper.querySelector('.field-feedback');

        if (!feedbackEl) {
            feedbackEl = document.createElement('div');
            feedbackEl.className = 'field-feedback text-xs mt-2';
            field.parentElement.appendChild(feedbackEl);
        }

        if (isValid && field.value.trim()) {
            field.classList.remove('border-red-500', 'bg-red-50');
            field.classList.add('border-blue-500', 'bg-blue-50');
            feedbackEl.innerHTML = '<span class="text-blue-600">✓ Valid</span>';
        } else if (!isValid) {
            field.classList.remove('border-blue-500', 'bg-blue-50');
            field.classList.add('border-red-500', 'bg-red-50');
            feedbackEl.innerHTML = `<span class="text-red-600">✗ ${errorMsg}</span>`;
        } else {
            field.classList.remove('border-red-500', 'bg-red-50', 'border-blue-500', 'bg-blue-50');
            feedbackEl.innerHTML = '';
        }
    };

    // ========== CHARACTER COUNTER ==========
    const addCharacterCounter = (field) => {
        if (!fieldLimits[field.name]) return;

        const wrapper = field.parentElement;
        let counterEl = wrapper.querySelector('.char-counter');

        if (!counterEl) {
            counterEl = document.createElement('div');
            counterEl.className = 'char-counter text-xs text-stone-500 mt-1 text-right';
            wrapper.appendChild(counterEl);
        }

        const limit = fieldLimits[field.name];
        const current = field.value.length;
        const remaining = limit - current;
        const percentUsed = (current / limit) * 100;

        counterEl.textContent = `${current}/${limit}`;
        counterEl.style.color = percentUsed > 80 ? '#dc2626' : percentUsed > 60 ? '#ea580c' : '#78716c';
    };

    // ========== COLOR PREVIEW ==========
    const updateColorPreview = (selectField) => {
        const value = selectField.value;
        const hex = colorHexMap[value];

        if (!hex) return;

        let previewEl = selectField.parentElement.querySelector('.color-preview');
        if (!previewEl) {
            previewEl = document.createElement('div');
            previewEl.className = 'color-preview inline-block ml-3 rounded border-2 border-stone-300';
            previewEl.style.width = '24px';
            previewEl.style.height = '24px';
            selectField.parentElement.appendChild(previewEl);
        }

        previewEl.style.backgroundColor = hex;
        previewEl.title = `${value}: ${hex}`;
    };

    // ========== IMAGE PREVIEW ==========
    const handleImagePreview = (input) => {
        if (!input.files || !input.files[0]) return;

        const file = input.files[0];

        // Validate file
        if (!file.type.startsWith('image/')) {
            input.value = '';
            alert('Please select a valid image file');
            return;
        }

        if (file.size > 5 * 1024 * 1024) {
            input.value = '';
            alert('Image must be less than 5MB');
            return;
        }

        // Show preview
        const reader = new FileReader();
        reader.onload = function (e) {
            let previewEl = input.parentElement.querySelector('.image-preview-box');

            if (!previewEl) {
                previewEl = document.createElement('div');
                previewEl.className = 'image-preview-box mt-4 p-3 bg-stone-50 rounded border border-stone-200';
                input.parentElement.appendChild(previewEl);
            }

            previewEl.innerHTML = `
        <p class="text-xs font-bold text-stone-600 mb-2">Preview:</p>
        <img src="${e.target.result}" alt="Inspiration preview" class="max-w-sm h-auto rounded border border-stone-300">
        <p class="mt-2 text-xs text-stone-500">${file.name} (${(file.size / 1024).toFixed(1)}KB)</p>
      `;
        };
        reader.readAsDataURL(file);
    };

    // ========== FORM SUBMISSION STATUS ==========
    const showSubmitStatus = (message, isSuccess) => {
        let statusEl = document.getElementById('submitStatus');

        if (!statusEl) {
            statusEl = document.createElement('div');
            statusEl.id = 'submitStatus';
            form.insertAdjacentElement('beforebegin', statusEl);
        }

        statusEl.className = `p-4 rounded-lg mb-4 text-sm ${
            isSuccess
                ? 'bg-blue-50 border border-blue-300 text-blue-700'
                : 'bg-red-50 border border-red-300 text-red-700'
        }`;
        statusEl.textContent = message;
    };

    // ========== EVENT LISTENERS ==========
    const inputs = form.querySelectorAll('input, select, textarea');

    inputs.forEach((field) => {
        // Validation on blur
        field.addEventListener('blur', () => validateField(field));

        // Real-time feedback
        field.addEventListener('input', () => {
            addCharacterCounter(field);
            validateField(field);
        });

        // Color preview
        if (field.name === 'primary_color' || field.name === 'secondary_color') {
            field.addEventListener('change', () => updateColorPreview(field));
        }

        // Image preview
        if (field.type === 'file') {
            field.addEventListener('change', () => handleImagePreview(field));
        }
    });

    // ========== FORM SUBMISSION ==========
    form.addEventListener('submit', function (e) {
        // Validate all fields
        let allValid = true;
        inputs.forEach((field) => {
            if (!validateField(field)) {
                allValid = false;
            }
        });

        if (!allValid) {
            e.preventDefault();
            showSubmitStatus('Please fix the errors above before submitting', false);
            return;
        }

        showSubmitStatus('Submitting your custom jacket request...', true);
    });

    // ========== FORM RESET ==========
    const resetBtn = form.querySelector('button[type="reset"]');
    if (resetBtn) {
        resetBtn.addEventListener('click', function () {
            setTimeout(() => {
                inputs.forEach((field) => {
                    field.classList.remove(
                        'border-red-500',
                        'bg-red-50',
                        'border-green-500',
                        'bg-green-50'
                    );
                    const feedbackEl = field.parentElement.querySelector('.field-feedback');
                    if (feedbackEl) feedbackEl.innerHTML = '';
                    const counterEl = field.parentElement.querySelector('.char-counter');
                    if (counterEl) counterEl.innerHTML = '';
                    const previewEl = field.parentElement.querySelector('.image-preview-box');
                    if (previewEl) previewEl.remove();
                    const colorEl = field.parentElement.querySelector('.color-preview');
                    if (colorEl) colorEl.remove();
                });
            }, 0);
        });
    }

    // ========== INITIALIZE COLOR PREVIEWS ==========
    inputs.forEach((field) => {
        if ((field.name === 'primary_color' || field.name === 'secondary_color') && field.value) {
            updateColorPreview(field);
        }
        if (field.type === 'file' && field.value) {
            addCharacterCounter(field);
        }
    });
});
