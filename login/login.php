<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    <style>
        /* Inline styling for the error message (to supplement existing CSS) */
        .error-msg {
            color: red;
            font-size: 18px;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo"><img src="../images/a-minimal-black-and-white-logo-with-a-stylized-ima-ummsoNe7Q1e7eABCChvDoA-dD8ZRugKQgGhmayfYELtBg.jpeg" alt="logo"></div>
        <div class="title">Expense Tracker</div>
    </div>
    <div class="main">
        <div class="left">
            <div class="ellipse"></div>
        </div>
        <div class="middle">
            <div class="form">
                <form action="login_form.php" method="post">
                    <div class="log">
                        <div>
                            <label for="username">Username: </label>
                            <input type="text" name="username" id="username" required>
                        </div>
                        <div>
                            <label for="password">Password: </label>
                            <input type="password" name="password" id="password" required>
                        </div>
                    </div>
                    <div>
                        <button type="submit">Login</button>
                    </div>

                    <!-- Display error message -->
                    <?php
                    if (isset($_SESSION['msg'])) {
                        echo '<div id="error-message" class="error-msg">' . htmlspecialchars($_SESSION['msg']) . '</div>';
                        unset($_SESSION['msg']); // Clear the message after displaying it
                    }
                    ?>

                    <div class="extra">
                        <div class="don't">Don't have an account?</div>
                        <div class="register"><a href="../register/register.php" style="color: black; font-weight:bold;">Register!</a></div>
                    </div>
                </form>
            </div>
        </div>
        <div class="right">
            <div class="ellipse-2"></div>
        </div>
    </div>

    <!-- JavaScript to hide the error message -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const errorMessage = document.getElementById("error-message");
            if (errorMessage) {
                setTimeout(() => {
                    errorMessage.style.display = "none";
                }, 3000); // 3000 milliseconds = 3 seconds
            }
        });
    </script>
</body>

</html>
