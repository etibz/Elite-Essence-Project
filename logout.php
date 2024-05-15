<?php session_start(); ?>
<html>
<head>
    <title>Logout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        .container {
            text-align: center;
            margin-top: 20vh;
        }
        .error-message {
            color: red;
            font-size: 3em;
            margin-bottom: 20px;
        }
        .login-button a {
            padding: 10px 20px;
            font-size: 1.7em;
            background-color: #333;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .login-button a:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        if(isset($_SESSION['username'])) {
            session_destroy();
            echo "<div class='error-message'>You have been successfully logged out.</div>";
        } else {
            echo "<div class='error-message'>You are not logged in!</div>";
        }
        ?>
        <div class="login-button">
            <a href="index.php">Login</a>
        </div>
    </div>
</body>
</html>
