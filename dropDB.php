

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
	}

?>