<html>
<head>
<style>
a {
    color: #333;
    text-decoration: none;
    font-size: 1.2em;
    display: block;
    text-align: center;
	margin: 20px 0;
    padding: 10px;
    border: 2px solid #333;
    width: 200px;
    margin-left: auto;
    margin-right: auto;
}
 a:hover {
	color: #555;           
}
body {
    margin: 0;
    padding: 0;
    font-family: 'Arial', sans-serif;
    background-color: #f0f0f0;
}

.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #333;
    color: white;
    padding: 10px 20px; 
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

.navbar a {
    color: white;
    text-decoration: none;
    font-size: 18px;
    padding: 10px 20px;
    transition: background-color 0.3s ease;
}

.navbar a:hover {
    color: #ddd; 
}

.navbar img {
    width: auto; 
    height: 80px;
    margin-right: 20px;
}

</style>
</head>
<body>
	<div class="navbar">
	 <img src="LogoNew.png">
	  <a href="home.php">Home</a>
	  <a href="products.php">Products</a>
	  <a href="cart.php">Cart</a>
	  <a href="admin.php">Admin</a>
	</div>
</body>
</html>
