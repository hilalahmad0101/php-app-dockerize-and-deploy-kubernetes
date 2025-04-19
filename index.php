<?php

require 'config.php';


// 4. List all products
echo "<h2>Product List</h2><table border='1' cellpadding='8'>";
echo "<tr><th>ID</th><th>Name</th><th>Description</th><th>Price</th><th>Qty</th><th>Created At</th></tr>";
$rows = $pdo->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $row) {
    echo "<tr>";
    foreach ($row as $col) {
        echo "<td>" . htmlspecialchars($col) . "</td>";
    }
    echo "</tr>";
}
echo "</table>";


echo "<h1>Our first dockerize php app</h1>";