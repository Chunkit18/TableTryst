<?php
// Database connection
$host = "aws-0-ap-southeast-1.pooler.supabase.com"; // Supabase host
$port = "6543"; // Supabase PostgreSQL port
$dbname = "postgres"; // Database name
$user = "postgres.erqiyueurwqczifhpxid"; // Supabase username
$pass = "tabletryst123"; // Supabase password

try {
    // Establish PDO connection to PostgreSQL
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $conn = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // ✅ Connection successful
    // echo "✅ Connected to PostgreSQL successfully!";

} catch (PDOException $e) {
    die("❌ Connection failed: " . $e->getMessage());
}
?>
