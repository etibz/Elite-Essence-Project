<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "perfumeDB";
	$conn = new mysqli($servername, $username, $password, $dbname);

	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}else{
			echo "Connected successfully";
			
			$tblUsers = "CREATE TABLE tblUsers(
			user_id INT(9) NOT NULL ,
			username VARCHAR(30) NOT NULL PRIMARY KEY,
			email VARCHAR(255) NOT NULL,
			password VARCHAR(30) NOT NULL,
			type VARCHAR(5) NOT NULL		)";
			if ($conn->query($tblUsers) === TRUE) {
				echo "Table tblUsers created successfully";
			}else{
				echo "Error creating tblUsers table: " . $conn->error;
			}
			
			$tblProducts = "CREATE TABLE tblProducts(
			product_id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			product_name VARCHAR(30) NOT NULL,
			quantity INT(9) NOT NULL,
			ml INT(9) NOT NULL,
			price INT(9) NOT NULL,
			img VARCHAR(255) NOT NULL		)";
			if ($conn->query($tblProducts) === TRUE) {
				echo "Table tblProducts created successfully";
			}
			else{
				echo "Error creating tblProducts table: " . $conn->error;
			}
			
			$tblCart = "CREATE TABLE tblCart(
			cart_id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			product_id INT(9) NOT NULL,
			username VARCHAR(30) NOT NULL,
			quantity INT(9) NOT NULL,
			FOREIGN KEY (username) REFERENCES tblUsers(username),
			FOREIGN KEY (product_id) REFERENCES tblProducts(product_id)  )";
			if($conn->query($tblCart) === TRUE){
				echo "Table tblCart created successfully";
			}else{
				echo "Error creating tblCart table: ".$conn->error;
			}
			
			
			$conn->query("INSERT INTO tblUsers(user_id, username, email, password, type) VALUES (232323232,'admin','admin@gmail.com','12345','admin'), (123456789,'user1','user1@gmail.com','11111','user'),(987654321,'user2','user2@gmail.com','22222','user')");
			
			$conn->query("INSERT INTO tblProducts(product_name, quantity, ml, price, img) VALUES ('Viktor & Rolf Flowerbomb Haute Couture', 10, 100, 2700,'Viktor&Rolf Perfume.jpg'), ('Ammafi Power For Women', 10, 100,7700 ,'Ammafi Power Perfume.png'),('Shalini Amorem Rose Crystal Flacon', 10, 100, 3100,'Shalini Perfume.jpg'),('Roja Parfums Roja Haute Luxe', 10, 100, 3500,'Roja Parfum.jpg'),('CREED Les Royales Exclusives Jardin', 10, 100, 1125,'CREED Les Royales.jpg')");
			
			$conn->close();
			
		}
?>
