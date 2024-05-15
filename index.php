<?php
session_start(); 

include 'DBconnect.php';
$sql = "SELECT * FROM tblusers WHERE username = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $_POST["username"], $_POST["password"]);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$_SESSION['type'] = 'user';

if ($user) {
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['type'] = $user['type']; 
    echo "<p>Connected successfully!</p>";
}

?>

<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            align-items: center;
        }
        fieldset {
            border-radius: 10px;
            background-color: #fff;
            padding: 20px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px auto;
            max-width: 300px;
        }
        header {
            background-color: black;
            color: white;
            padding: 10px;
            text-align: center;
            font-family:Cambria Math;
            font-size:20px;
        }
        legend {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin: 10px 0;
        }
        input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }
        button {
            background-color: #000;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button a {
            color: #fff;
            text-decoration: none;
        }
        button:hover {
            background-color: #333;
        }
        p {
            color: red;
        }
    </style>
</head>
<body>
<header>
    <img src="LogoNew.png" style="width:200;height:170">
</header>
<fieldset>
    <legend>Login</legend>
    <form action="index.php" method="post">
        <label for="username">Username:</label>
        <br>
        <input type="text" id="username" name="username">
        <br>
        <label for="password">Password:</label>
        <br>
        <input type="password" id="password" name="password">
        <br><br>
        <button type="submit">Login</button>
        <button type="submit"><a href="signupPage.php">SignUp</a></button>
    </form>
    <?php
       if ($user) {
            echo "<p>Connected successfully!</p>";
            if($user['type']=='admin') {
                header("Location: admin.php");
                exit;
            } else {
                header("Location: home.php");
                exit;
            }
        } else if (!empty($_POST["username"]) || !empty($_POST["password"])) {
            echo "<p>One or more of the details entered are incorrect!</p>";
        }
    ?>
</fieldset>
</body>
</html>
