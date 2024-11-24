<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="register.css">
</head>

<body>
    <div class="header">
        <div class="logo">
            <img src="../images/a-minimal-black-and-white-logo-with-a-stylized-ima-ummsoNe7Q1e7eABCChvDoA-dD8ZRugKQgGhmayfYELtBg.jpeg" alt="logo">
        </div>
        <div class="title">Expense Tracker</div>
    </div>

    <div class="main">
        <div class="left">
            <div class="ellipse"></div>
        </div>
        <div class="middle">
            <div class="form-container">
                <!-- Registration Form -->
                <div class="form">
                    <form action="reg_form.php" method="post">
                        <div>
                            <label for="name">Name: </label>
                            <input type="text" name="name" id="name">
                            <span class="error" id="name-error"></span>
                        </div>
                        <div>
                            <label for="number">Phone Number: </label>
                            <input type="tel" name="number" id="number">
                            <span class="error" id="number-error"></span>
                        </div>
                        <div>
                            <label for="email">Email: </label>
                            <input type="email" name="email" id="email">
                            <span class="error" id="email-error"></span>
                        </div>
                        <div>
                            <label for="username">Username: </label>
                            <input type="text" name="username" id="username">
                            <span class="error" id="username-error"></span>
                        </div>
                        <div>
                            <label for="password">Password: </label>
                            <input type="password" name="password" id="password">
                            <span class="error" id="password-error"></span>
                        </div>
                        <div>
                            <button type="submit">Register</button>
                        </div>
                        <div class="login"><a href="../login/login.php" style=" display: flex;color: black; font-weight:bold; justify-content: center;">Login!</a></div>

                        <!-- Session Message Display -->
                        <?php if (isset($_SESSION['msg'])): ?>
                            <div class="form-message <?= strpos($_SESSION['msg'], 'Failed') !== false ? 'error' : ''; ?>" id="message">
                                <?= htmlspecialchars($_SESSION['msg']); ?>
                            </div>
                            <?php unset($_SESSION['msg']); ?>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
        <div class="right">
            <div class="ellipse-2"></div>
        </div>
    </div>

    <script src="regex.js"></script>
    <script>
        // Automatically hide the success message after 3 seconds
        const message = document.getElementById('message');
        if (message) {
            setTimeout(() => {
                message.style.display = 'none';
            }, 3000); // Hide message after 3 seconds
        }
    </script>
</body>

</html>
