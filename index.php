<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Homepage-Expense Tracker</title>
  <link rel="stylesheet" href="homepage.css">
</head>

<body>
  <div class="header">
    <div class="heads">
      <div class="logo">
        <img src="./images/a-minimal-black-and-white-logo-with-a-stylized-ima-ummsoNe7Q1e7eABCChvDoA-dD8ZRugKQgGhmayfYELtBg.jpeg" alt="logo">
      </div>
      <div class="title">Expense Tracker</div>
    </div>

    <div class="signIn">
      <?php if (isset($_SESSION['username'])): ?>
        <!-- If the user is logged in, show Sign Out button -->
        <a href="./login/logout.php"><button type="button">Sign Out</button></a>
      <?php else: ?>
        <!-- If the user is not logged in, show Sign In button -->
        <a href="./login/login.php"><button type="button">Sign In</button></a>
      <?php endif; ?>
    </div>
  </div>

  <div class="main">
    <div class="left">
      <div class="card-1">
        <img src="./images/an-animated-illustration-of-a-man-with-a-magnifyin-yGADK8EDSBe6XKQqfTxRww-1xPWkWQVQ-CTAjUi5pM37Q.jpeg" alt="">
      </div>
      <div class="left-content">
        Keep Eyes on Your Expenses!
      </div>
      <div class="startBtn">
        <?php if (isset($_SESSION['username'])): ?>
          <!-- If logged in, show Dashboard button -->
          <a href="./dashboard/dashboard.php"><button type="button">Dashboard</button></a>
        <?php else: ?>
          <!-- If not logged in, show Get Started button -->
          <a href="./register/register.php"><button type="submit">Get Started With Us!</button></a>
        <?php endif; ?>
      </div>
    </div>

    <div class="right">
      <div class="description">
        Expense Tracker, the expense manager
        that helps you to keep track of your expenses!
      </div>
      <div class="services">
         What Do You Get Here?
      </div>
      <div class="cards">
        <img src="./images/an-animated-logo-with-the-text-recording-expenses--Wq8Fe2-_T9GBfaaB6MoZ-g-DWrSq1bXT_OH-4aEiUOKiA.jpeg" alt="">
        <img src="./images/an-animated-logo-with-the-text-reports-of-expenses-3Z10jyENQiSmsJRkguqPgg-_ExMaN6CTuG1_YBMiG-2nQ.jpeg" alt="">
      </div>
    </div>
  </div>

  <div class="info-section">
    <div class="about-us">
      <h2>About Us</h2>
      <p>
        Expense Tracker is your go-to solution for managing daily expenses with ease and precision. 
        Our mission is to empower individuals and businesses to gain better control of their finances, 
        ensuring financial health and stability.
      </p>
    </div>

    <div class="contact">
      <h2>Contact Us</h2>
      <p><strong>Phone:</strong> +977 9861986616</p>
      <p><strong>Email:</strong> support@expensetracker.com</p>
      <p><strong>Address:</strong> Tarkeshwor-2, Kathmandu, Nepal</p>
    </div>
  </div>

  <footer class="footer">
    <p>&copy; 2024 Expense Tracker. All Rights Reserved.</p>
  </footer>

</body>

</html>
