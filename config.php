<?php
$servername = "mysql";  // Service name defined in docker-compose.yml
$username = "root";
$password = "root";
$database = "mydb";

try {
    // Create connection
    $pdo = new PDO("mysql:host=$servername;port=3306;dbname=$database", $username, $password);

    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // 1. Check if table exists
    $tableCheck = $pdo->query("SHOW TABLES LIKE 'products'");
    if ($tableCheck->rowCount() == 0) {
        // 2. Create table
        $create = "
            CREATE TABLE products (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                description TEXT,
                price DECIMAL(10, 2) NOT NULL,
                quantity INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ";
        $pdo->exec($create);
        echo "Table 'products' created successfully.<br>";
    } else {
        echo "Table 'products' already exists.<br>";
    }

    // 3. Insert data only if table is empty
    $count = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
    if ($count == 0) {
        $products = [
            ['Laptop', '15-inch laptop with 16GB RAM', 899.99, 10],
            ['Smartphone', 'Android 5G smartphone', 499.99, 25],
            ['Headphones', 'Wireless over-ear headphones', 129.99, 50],
            ['Keyboard', 'Mechanical gaming keyboard', 79.99, 35],
            ['Mouse', 'Wireless ergonomic mouse', 39.99, 40],
            ['Monitor', '27-inch 4K UHD monitor', 299.99, 20],
            ['Webcam', 'HD webcam with microphone', 59.99, 15],
            ['USB-C Hub', '6-in-1 USB-C hub with HDMI', 49.99, 30],
            ['External HDD', '1TB portable external hard drive', 69.99, 12],
            ['Printer', 'All-in-one color printer', 149.99, 18]
        ];

        $stmt = $pdo->prepare("INSERT INTO products (name, description, price, quantity) VALUES (?, ?, ?, ?)");

        foreach ($products as $product) {
            $stmt->execute($product);
        }

        echo "10 sample products inserted successfully.<br>";
    } else {
        echo "Products already exist in the table.<br>";
    }
    // echo "Connected to MySQL successfully!";
} catch (PDOException $e) {
    echo "Connection failed: " . $e;
}
?>