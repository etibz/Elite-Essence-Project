<?php
include 'DBconnect.php';


?>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        fieldset {
            border-radius: 10px;
            border: 2px solid #000;
            padding: 20px;
            margin: 20px auto;
            max-width: 300px;
            background-color: #fff;
        }

        header {
            background-color: black;
            color: white;
            padding: 10px;
            text-align: center;
        }

        legend {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        button {
            background-color: #000;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #333;
        }

        p {
            color: red;
        }
		header {
            background-color: black;
            color: white;
            padding: 10px;
            text-align: center;
            font-family:Cambria Math;
            font-size:20px;
        }
    </style>
</head>
<body>
<header>
    <img src="LogoNew.png" style="width:200;height:170">
</header>
<?php
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (!empty($_POST["user_id"]) && !empty($_POST["username"]) && !empty($_POST["email"]) && !empty($_POST["password"])) {
			$user_id = $_POST["user_id"];
			$username = $_POST["username"];
			$email = $_POST["email"];
			$password = $_POST["password"];
			$type = 'user';

			$sql = "SELECT * FROM tblUsers WHERE username = '$username'";
			$result = $conn->query($sql);

			if ($result && $result->num_rows > 0) {
				echo "<center><p>This username is already exist!</p></center>";
			} else {
				$sql = "INSERT INTO tblUsers (user_id, username, email, password, type)
				VALUES ('$user_id', '$username', '$email', '$password', '$type')";

				if ($conn->query($sql) === TRUE) {
					header("Location: index.php");
					exit;
				} else {
					echo "Error: " . $sql . "<br>" . $conn->error;
				}
			}
		} else {
			echo "<center><p>One or more fields were not filled.</p></center>";
		}
	}
?>
<fieldset style="border-radius:10px;">
    <legend>SignUp</legend>
    <form action="signupPage.php" method="post">
        <label for="user_id">Id:</label>
        <input type="text" id="user_id" name="user_id">
        <br>
        <label for="username">username:</label>
        <input type="text" id="username" name="username">
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email">
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password">
        <br>
        <button type="submit">SignUp</button>
    </form>
</fieldset>
</body>
</html>
