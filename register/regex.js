document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');

    form.addEventListener('submit', function (event) {
        // Prevent submission by default
        event.preventDefault();

        // Clear previous error messages
        document.querySelectorAll('.error').forEach(error => error.textContent = '');

        // Input values
        const name = document.getElementById('name').value.trim();
        const phone = document.getElementById('number').value.trim();
        const email = document.getElementById('email').value.trim();
        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value.trim();

        // Regular expressions
        const namePattern = /^[A-Za-z\s]+$/; // Only alphabets and spaces
        const phonePattern = /^9\d{9}$/; // Must start with 9 and be exactly 10 digits
        const emailPattern = /^[a-zA-Z0-9._%+-]+@gmail\.com$/; // Must end with @gmail.com
        const usernamePattern = /^[a-zA-Z0-9_]+$/; // Alphanumeric characters and underscores, no spaces
        const passwordPattern = /^[A-Za-z0-9@$!%*?&]+$/; // Can include letters, numbers, and special characters, in any order

        // Validation status
        let isValid = true;

        // Name validation
        if (!namePattern.test(name)) {
            document.getElementById('name-error').textContent = 'Invalid Name: Only alphabets and spaces are allowed.';
            isValid = false;
        }

        // Phone validation
        if (!phonePattern.test(phone)) {
            document.getElementById('number-error').textContent = 'Invalid Phone Number: Must start with 9 and be exactly 10 digits.';
            isValid = false;
        }

        // Email validation
        if (!emailPattern.test(email)) {
            document.getElementById('email-error').textContent = 'Invalid Email: Must end with @gmail.com.';
            isValid = false;
        }

        // Username validation
        if (!usernamePattern.test(username)) {
            document.getElementById('username-error').textContent = 'Invalid Username: Only alphanumeric & underscores are allowed';
            isValid = false;
        }

        // Password validation
        if (!passwordPattern.test(password)) {
            document.getElementById('password-error').textContent = 'Invalid Password: Can include letters, numbers & sp.chars';
            isValid = false;
        }

        // If all validations pass, allow form submission
        if (isValid) {
            form.submit();
        }
    });
});
