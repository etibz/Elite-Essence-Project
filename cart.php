<?php
include 'navbar.php';
include 'DBconnect.php';
session_start();

$db = new PDO('mysql:host=localhost;dbname=perfumeDB;charset=utf8', 'root', '');
$stmt = $db->prepare('SELECT p.product_id, p.product_name, p.img, p.price, SUM(c.quantity) as quantity FROM tblProducts p LEFT JOIN tblCart c ON p.product_id = c.product_id WHERE c.username = :username GROUP BY p.product_id');
$stmt->execute(array(':username' => $_SESSION['username']));
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);


if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

function addToCart($productId) {
    global $db;
    $stmt = $db->prepare('SELECT * FROM tblProducts WHERE product_id = :id');
    $stmt->execute(array(':id' => $productId));
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($product && $product['quantity'] > 0) {
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$productId] = $product;
            $_SESSION['cart'][$productId]['quantity'] = 1;
        }    
        $stmt = $db->prepare('INSERT INTO tblCart (product_id, username, quantity) VALUES (:product_id, :username, :num) ON DUPLICATE KEY UPDATE quantity = quantity + 1');
        $stmt->execute(array(':product_id' => $productId, ':username' => $_SESSION['username'], ':num' => 1));
    } else {
        echo "<script>alert('אנחנו מצטערים, אך המוצר אינו זמין במלאי ברגע זה.');</script>";
    }
}

function removeFromCart($productId) {
    global $db;
        $stmt = $db->prepare('DELETE FROM tblCart WHERE username = :username AND product_id = :product_id');
        $stmt->execute(array(':username' => $_SESSION['username'], ':product_id' => $productId));
    header("Refresh:0");
}

function checkout() {
    global $db;
    global $products;

    foreach ($products as $product) {
        $stmt = $db->prepare('UPDATE tblProducts SET quantity = quantity - :quantity WHERE product_id = :id');
        $stmt->execute(array(':quantity' => $product['quantity'], ':id' => $product['product_id'])); // Use $product['product_id'] instead of $productId
    }

    $_SESSION['cart'] = array();

    $stmt = $db->prepare('DELETE FROM tblCart WHERE username = :username');
    $stmt->execute(array(':username' => $_SESSION['username']));

    header("Refresh:0");
}

if (isset($_POST['checkout'])) {
    checkout();
}

if (isset($_POST['remove'])) {
    removeFromCart($_POST['remove']);
}

if (isset($_POST['add'])) {
    addToCart($_POST['add']);
}

function calculateTotal($products) {
    $total = 0;
    foreach ($products as $product) {
        $total += $product['price'] * $product['quantity'];
    }
    return $total;
}
?>
<html>
<head>
    <title>CartPage</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f1f1f1;
        }
        .container {
            width: 80%;
            margin: 0 auto;
        }
        .product-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .product-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .product-name {
            font-size: 20px;
            font-weight: bold;
        }
        .product-price {
            color: #888;
        }
        .product-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            color: #fff;
        }
        .btn-add {
            background-color: #007bff;
        }
        .product-img {
            width: 100px;
            height: 100px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Shopping Cart</h1>
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <div class="product-info">
                    <span class="product-name"><?php echo $product['product_name']; ?></span>
                    <img class="product-img" src="<?php echo $product['img']; ?>">
                    <span class="product-price"><?php echo $product['price']; ?>$</span>
                    <span class="product-quantity">quantity:  <?php echo " ".$product['quantity']; ?></span>
                </div>
                <div class="product-actions">
                    <form method="post">
                        <input type="hidden" name="remove" value="<?php echo $product['product_id']; ?>">
                        <button type="submit" name="remove_item_<?php echo $product['product_id']; ?>" class="btn btn-add">Remove</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
        <h2>סה"כ: <?php echo calculateTotal($products); ?>$</h2>
        <form method="post">
            <button type="submit" name="checkout" class="btn btn-add">Checkout</button>
        </form>
    </div>
</body>
</html>
