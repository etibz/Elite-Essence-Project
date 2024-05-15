<?php
    include 'navbar.php';
    include 'DBconnect.php';
    $sql = "SELECT * FROM tblproducts ORDER BY price ASC";
    $result = $conn->query($sql);
?>
<html>
<head>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        header {
            background-color: black;
            color: white;
            padding: 10px;
            text-align: center;
        }
        main {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            padding: 20px;
        }	
		.card {
			width: 300px;
			margin: 20px;
			padding: 15px;
			background-color: white;
			border-radius: 8px;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
			transition: transform 0.3s ease;
		}
		.card:hover {
			transform: scale(1.05);
			box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
		}
        .card img {
            max-width: 100%;
            height: auto;
            border-radius: 6px;
            margin-bottom: 10px;
        }
        .card h2 {
            font-size: 1.5em;
            margin-bottom: 10px;
        }
        .card p {
            color: #555;
        }
		button {
			background-color: black;
			color: white;
			border: none;
			padding: 10px 15px;
			font-size: 1em;
			cursor: pointer;
			border-radius: 4px;
			transition: background-color 0.3s ease;
		}
		button:hover {
			background-color: #333;
		}
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function(){
        $(".add-to-cart").click(function(e){
            e.preventDefault();
            var product_id = $(this).data("productid");
            $.post("cart.php", { add: product_id }, function(data){
                alert("Product added to cart");
            });
        });
    });
    </script>
</head>
<body>

<main>
    <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="card">';
                echo '<img src="'.$row["img"].'">';
                echo '<center><h2>'.$row["product_name"].'</h2></center>';
                echo '<center><p>'.$row["ml"].' ml</p></center>';
                echo '<center><b><p>'.$row["price"].'$</p></b></center>';
                echo '<center><button class="add-to-cart" data-productid="'.$row["product_id"].'">Add to cart</button></center>';
                echo '</div>';
            }
        } else {
            echo "No products found";
        }
    ?>
</main>
<?php
    $conn->close();
?>
</body>
</html>
