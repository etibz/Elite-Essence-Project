<?php
include 'navbar.php';
include 'DBconnect.php'; 

session_start();
if (isset($_SESSION['type'])&&$_SESSION['type'] == 'admin') {
    function add_stock($id, $quantity) {
    global $conn;
    $sql = "UPDATE tblProducts SET quantity = quantity + ? WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $quantity, $id);
    $stmt->execute();
}

function remove_stock($id, $quantity) {
    global $conn;
    $sql = "SELECT quantity FROM tblProducts WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if ($row['quantity'] >= $quantity) {
        $sql = "UPDATE tblProducts SET quantity = quantity - ? WHERE product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $quantity, $id);
        $stmt->execute();
    } else {
        echo "Cannot remove more than available in stock.";
    }
}

    function edit_product($id, $name, $price) {
        global $conn;
        $sql = "UPDATE tblProducts SET product_name = COALESCE(NULLIF(?, ''), product_name), price = COALESCE(NULLIF(?, ''), price) WHERE product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdi", $name, $price, $id);
        $stmt->execute();
    }

    function add_product($name, $price, $quantity, $ml, $img) {
        global $conn;
        $sql = "INSERT INTO tblProducts (product_name, price, quantity, ml, img) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdiss", $name, $price, $quantity, $ml, $img);
        $stmt->execute();
    }

    function delete_product($id) {
        global $conn;
        $sql = "DELETE FROM tblProducts WHERE product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['add'])) {
            add_stock($_POST['id'], $_POST['quantity']);
        } elseif (isset($_POST['remove'])) {
            remove_stock($_POST['id'], $_POST['quantity']);
        } elseif (isset($_POST['edit'])) {
            edit_product($_POST['id'], $_POST['name'], $_POST['price']);
        } elseif (isset($_POST['add_product'])) {
            add_product($_POST['name'], $_POST['price'], $_POST['quantity'], $_POST['ml'], $_POST['img']);
        } elseif (isset($_POST['delete_product'])) {
            delete_product($_POST['id']);
        }
    }

    $sql = "SELECT * FROM tblProducts";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Name</th><th>Quantity</th><th>Price</th><th>ml</th><th>Image</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["product_id"]. "</td><td>" . $row["product_name"]. "</td><td>" . $row["quantity"]. "</td><td>" . $row["price"]."$". "</td><td>" . $row["ml"]. "</td><td><img src='" . $row["img"]. "' width='50' height='50'></td></tr>";
        }
        echo "</table>";
    } else {
        echo "No products found";
    }


$conn->close();

?>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        header {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
            margin-bottom: 20px;
        }
        fieldset {
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 10px;
            background-color: #f9f9f9;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
        legend {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        label {
            font-size: 18px;
            margin-bottom: 5px;
        }
        input, button {
            margin: 5px 0;
            padding: 10px;
            font-size: 16px;
        }
        button {
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <fieldset>
        <legend>Welcome <?php echo $_SESSION['username'] ?> </legend>
        <form action="" method="post">
            <h2>Add stock</h2>
            <label for="id">Product ID:</label>
            <input type="number" id="id" name="id">
            <label for="quantity">Quantity to add:</label>
            <input type="number" id="quantity" name="quantity">
            <button type="submit" name="add">Add stock</button>
        </form>
        <form action="" method="post">
            <h2>Remove stock</h2>
            <label for="id">Product ID:</label>
            <input type="number" id="id" name="id">
            <label for="quantity">Quantity to remove:</label>
            <input type="number" id="quantity" name="quantity">
            <button type="submit" name="remove">Remove stock</button>
        </form>
        <form action="" method="post">
            <h2>Edit product</h2>
            <label for="id">Product ID:</label>
            <input type="number" id="id" name="id">
            <label for="name">New product name (leave blank to keep current):</label>
            <input type="text" id="name" name="name">
            <label for="price">New price (leave blank to keep current):</label>
            <input type="number" id="price" name="price">
            <button type="submit" name="edit">Edit product</button>
        </form>
        <form action="" method="post">
            <h2>Add product</h2>
            <label for="name">Product name:</label>
            <input type="text" id="name" name="name">
            <label for="price">Price:</label>
            <input type="number" id="price" name="price">
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity">
            <label for="ml">ml:</label>
            <input type="number" id="ml" name="ml">
            <label for="img">Image URL:</label>
            <input type="text" id="img" name="img">
            <button type="submit" name="add_product">Add product</button>
        </form>
        <form action="" method="post">
            <h2>Delete product</h2>
            <label for="id">Product ID:</label>
            <input type="number" id="id" name="id">
            <button type="submit" name="delete_product">Delete product</button>
        </form>
    </fieldset>
</body>
</html>
<?php
} else {
    echo "<center><p style='font-size: 34px; font-weight: bold; color: red;'>You are not an admin!</p></center>";
}
?>
