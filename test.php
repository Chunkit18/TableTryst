<?php
require 'connect.php'; // ✅ Include the database connection

$stmt = $pdo->query("SELECT * FROM customer");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<pre>";
print_r($users);
echo "</pre>";
?>
