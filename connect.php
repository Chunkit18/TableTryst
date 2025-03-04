<?php
// Database connection
$host = "aws-0-ap-southeast-1.pooler.supabase.com"; // Supabase host
$port = "6543"; // Supabase port
$dbname = "postgres"; // Database name
$user = "postgres.erqiyueurwqczifhpxid"; // Supabase username
$pass = "tabletryst123"; // Supabase password

try {
    // Establish connection
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    die("❌ Connection failed: " . $e->getMessage());
}

/* // ✅ Now, fetch data from the Customer table
$stmt = $pdo->query("SELECT * FROM Customer");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ✅ Display data
echo "<pre>";
var_dump($users);
echo "</pre>";-->*/
?>