<?php
require 'connect.php';

// Get last uploaded image with tables
$query = "SELECT * FROM tables ORDER BY id DESC LIMIT 1";
$stmt = $conn->query($query);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    die("❌ No table data found.");
}

$imagePath = $result['image_path'];
$tableData = json_decode($result['table_data'], true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Seating</title>
    <style>
        .container { position: relative; width: 600px; }
        img { width: 100%; }
        .table { position: absolute; background: rgba(0,255,0,0.5); cursor: pointer; }
    </style>
</head>
<body>

<h2>Interactive Seating Layout</h2>

<div class="container">
    <img src="<?= $imagePath ?>" alt="Seating Layout">
    <?php foreach ($tableData as $index => $table): ?>
        <div class="table" 
            style="left: <?= $table['x'] * 100 ?>%; 
                   top: <?= $table['y'] * 100 ?>%;
                   width: <?= $table['width'] * 100 ?>%;
                   height: <?= $table['height'] * 100 ?>%;">
            Table <?= $index + 1 ?>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
