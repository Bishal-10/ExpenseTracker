document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const errorSection = document.getElementById('error-section'); // The new error section

    form.addEventListener('submit', function (event) {
        // Prevent submission by default
        event.preventDefault();

        // Clear previous error messages
        document.querySelectorAll('.error-message').forEach(error => error.textContent = '');

        // Input values
        const name = document.getElementById('name').value.trim();
        const phone = document.getElementById('number').value.trim();
        const email = document.getElementById('email').value.trim();
        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value.trim();

         // Regular expressions
         const namePattern = /^[A-Za-z\s]+$/; // Only alphabets and spaces

         const phonePattern = /^9\d{9}$/; // Must start with 9 and be exactly 10 digits

         const emailPattern = /^[a-z][a-z0-9]*@gmail\.com$/; // Must end with @gmail.com

         
         const usernamePattern = /^[a-z][a-z0-9_]{4,15}$/; // Username must start with a lowercase letter, can include numbers and underscores, and must be at least 6 characters long.
 
          
         const passwordPattern = /^(?=.*[A-Z])(?=.*[a-z])(?=.*[@$!%*?&])[A-Za-z0-9@$!%*?&]{6,16}$/; // Password must include at least one uppercase letter, one lowercase letter, one special character, and can include numbers.

        let isValid = true;

        // Validation
        if (!namePattern.test(name)) {
            document.getElementById('name-error').textContent = 'Name Field can only contain letter and spaces';
            isValid = false;
        }
        if (!phonePattern.test(phone)) {
            document.getElementById('number-error').textContent = 'Phone number must start with 9 and of 10 digits';
            isValid = false;
        }
        if (!emailPattern.test(email)) {
            document.getElementById('email-error').textContent = 'Email must end with @gmail.com';
            isValid = false;
        }
        if (!usernamePattern.test(username)) {
            document.getElementById('username-error').textContent = 'Username must start with lowercase and should have atleast 6 characters';
            isValid = false;
        }
        if (!passwordPattern.test(password)) {
            document.getElementById('password-error').textContent = 'Password must have one uppercase, special character';
            isValid = false;
        }

        // If valid, submit the form
        if (isValid) {
            form.submit();
        } else {
            errorSection.style.display = 'block'; // Show the error section

            // Automatically hide the error section after 5 seconds
            setTimeout(() => {
                errorSection.style.display = 'none';
            }, 5000); // Hide after 5 seconds
        }
    });
});
