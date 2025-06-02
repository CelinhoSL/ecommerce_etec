document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility for main password field
    const togglePassword = document.getElementById('toggleSenha');
    const passwordField = document.getElementById('password');
    const passwordIcon = document.getElementById('iconeSenha');

    togglePassword.addEventListener('click', function() {
        const fieldType = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', fieldType);
        passwordIcon.classList.toggle('bi-eye');
        passwordIcon.classList.toggle('bi-eye-slash');
    });

    // Toggle password visibility for confirmation field
    const toggleConfirmPassword = document.getElementById('toggleConfirmSenha');
    const confirmPasswordField = document.getElementById('password_confirmation');
    const confirmPasswordIcon = document.getElementById('iconeConfirmSenha');

    toggleConfirmPassword.addEventListener('click', function() {
        const fieldType = confirmPasswordField.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPasswordField.setAttribute('type', fieldType);
        confirmPasswordIcon.classList.toggle('bi-eye');
        confirmPasswordIcon.classList.toggle('bi-eye-slash');
    });

    // Phone number formatting (Brazilian format)
    const phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function(event) {
        let inputValue = event.target.value.replace(/\D/g, '');
        
        if (inputValue.length >= 11) {
            inputValue = inputValue.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
        } else if (inputValue.length >= 7) {
            inputValue = inputValue.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
        } else if (inputValue.length >= 3) {
            inputValue = inputValue.replace(/(\d{2})(\d{0,5})/, '($1) $2');
        }
        
        event.target.value = inputValue;
    });

    // Form validation
    const registrationForm = document.querySelector('form[name="register-form"]');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password_confirmation');

    // Real-time password confirmation validation
    confirmPasswordInput.addEventListener('input', function() {
        if (passwordInput.value !== confirmPasswordInput.value) {
            confirmPasswordInput.setCustomValidity('Passwords do not match');
        } else {
            confirmPasswordInput.setCustomValidity('');
        }
    });

    // Validate form before submission
    registrationForm.addEventListener('submit', function(event) {
        if (passwordInput.value !== confirmPasswordInput.value) {
            event.preventDefault();
            alert('Password and confirmation password do not match.');
            return false;
        }

        // Check if all required fields are filled
        const requiredFields = registrationForm.querySelectorAll('input[required]');
        let isValid = true;
        
        requiredFields.forEach(function(field) {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');
            } else {
                field.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            event.preventDefault();
            alert('Please fill in all required fields.');
            return false;
        }
    });
});