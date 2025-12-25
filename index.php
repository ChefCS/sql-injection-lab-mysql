<?php
// Connect to MySQL (using Docker service name 'db')
$conn = new mysqli("db", "root", "rootpassword", "vulnerable_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Easy: Union-based SQLi in product search
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT id, name, price FROM products WHERE name LIKE '%$search%'";  // INTENTIONAL VULN: No sanitization
    $result = $conn->query($sql);
    echo "<h2>Search Results:</h2>";
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "ID: " . $row["id"] . " - Name: " . $row["name"] . " - Price: $" . $row["price"] . "<br>";
        }
    } else {
        echo "No products found.<br>";
    }
}

// Medium: Error-based SQLi in product details
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT name, description, price FROM products WHERE id = $id";  // INTENTIONAL VULN: Direct concatenation
    $result = $conn->query($sql);
    echo "<h2>Product Details:</h2>";
    if ($result && $row = $result->fetch_assoc()) {
        echo "Name: " . $row["name"] . "<br>Description: " . $row["description"] . "<br>Price: $" . $row["price"] . "<br>";
    } else {
        echo "Product not found or error in query.<br>";
    }
}

// Hard: Blind SQLi in login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";  // INTENTIONAL VULN
    $result = $conn->query($sql);
    echo "<h2>Login Attempt:</h2>";
    if ($result && $result->num_rows > 0) {
        echo "<strong style='color:green;'>Login successful! Welcome, $username.</strong><br>";
    } else {
        echo "<strong style='color:red;'>Invalid credentials.</strong><br>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vulnerable SQLi Lab</title>
</head>
<body>
    <h1>SQL Injection Practice Lab</h1>
    
    <h3>Search Products (Easy - Union SQLi)</h3>
    <form method="GET">
        <input type="text" name="search" placeholder="Enter product name">
        <input type="submit" value="Search">
    </form>
    
    <h3>View Product by ID (Medium - Error-based SQLi)</h3>
    <form method="GET">
        <input type="text" name="id" placeholder="Enter product ID (e.g., 1)">
        <input type="submit" value="View">
    </form>
    
    <h3>Login (Hard - Blind SQLi)</h3>
    <form method="POST">
        Username: <input type="text" name="username"><br><br>
        Password: <input type="text" name="password"><br><br>
        <input type="submit" name="login" value="Login">
    </form>
</body>
</html>