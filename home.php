 <?php include 'navbar.php'; ?>
<html>
<head>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        body {
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
       
        .content {
            margin: 20px;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            text-align: center;
            width: 80%;
            animation: fadeInUp 1s ease;
        }
        .logout {
            display: flex;
            justify-content: center;
            margin: 10px;
        }
        .logout button {
            padding: 15px 30px; 
            font-size: 18px;
            background-color: #333;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .logout button:hover {
            background-color: #555;
        }
        h2, h3 {
            color: #333;
            font-size: 2em;
        }
        p {
            line-height: 1.6;
            font-size: 1.2em;
        }
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
		video {
    width: 100%;
    height: auto;
    object-fit: cover;
}
    </style>
</head>
<body>
    <center><div class="content">
        <h2>Welcome to Elite Essence</h2>
        <p>We, Eti Ben Zour and Adir Amar, have created a site for selling luxury perfumes. Our site is suitable for people who want to smell like luxury. We believe the right perfume can upgrade any event or a regular workday, giving you a sense of confidence and elegance.</p>
        <h3>About Us</h3>
        <p>We created this site to share our love for luxury perfumes with the world. We believe everyone deserves to feel and smell good, and we are here to help you find the perfect fragrance for you.</p>
    <video autoplay loop muted>
  <source src="Perfume.mp4" type="video/mp4">
  Your browser does not support the video tag.
</video>
	</div>
    <div class="logout">
        <form action="logout.php" method="post">
            <button type="submit">Log Out</button>
        </form>
    </div>
    <a href="products.php">Browse Products</a>
</body>
</html>