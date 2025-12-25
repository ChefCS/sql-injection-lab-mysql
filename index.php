<?php
// Connect to MySQL
$conn = new mysqli("db", "root", "rootpassword", "vulnerable_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Easy: Fixed Union-based with prepared statement
if (isset($_GET['search'])) {
    $search = '%' . $_GET['search'] . '%';  // Safe wildcard
    $sql = "SELECT id, name, price FROM products WHERE name LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();
    echo "<h2>Search Results:</h2>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "ID: " . $row["id"] . " - Name: " . $row["name"] . " - Price: $" . $row["price"] . "<br>";
        }
    } else {
        echo "No products found.<br>";
    }
    $stmt->close();
}

// Medium: Fixed Error-based with prepared statement + integer binding
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (!is_numeric($id)) {
        echo "Invalid product ID.<br>";
    } else {
        $sql = "SELECT name, description, price FROM products WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        echo "<h2>Product Details:</h2>";
        if ($row = $result->fetch_assoc()) {
            echo "Name: " . $row["name"] . "<br>Description: " . $row["description"] . "<br>Price: $" . $row["price"] . "<br>";
        } else {
            echo "Product not found.<br>";
        }
        $stmt->close();
    }
}

// Hard: Fixed Blind with prepared statement
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    echo "<h2>Login Attempt:</h2>";
    if ($result->num_rows > 0) {
        echo "<strong style='color:green;'>Login successful! Welcome, $username.</strong><br>";
    } else {
        echo "<strong style='color:red;'>Invalid credentials.</strong><br>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Secure SQLi Lab (Fixed)</title>
</head>
<body>
    <h1>SQL Injection Lab – Secure Version</h1>
    <p>All vulnerabilities fixed with prepared statements and input validation.</p>
    
    <h3>Search Products</h3>
    <form method="GET">
        <input type="text" name="search" placeholder="Enter product name">
        <input type="submit" value="Search">
    </form>
    
    <h3>View Product by ID</h3>
    <form method="GET">
        <input type="text" name="id" placeholder="Enter product ID">
        <input type="submit" value="View">
    </form>
    
    <h3>Login</h3>
    <form method="POST">
        Username: <input type="text" name="username"><br><br>
        Password: <input type="text" name="password"><br><br>
        <input type="submit" name="login" value="Login">
    </form>
</body>
</html>