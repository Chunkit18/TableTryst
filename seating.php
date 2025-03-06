<?php
require 'connect.php';
$stmt = $conn->query("SELECT * FROM tables");
$tables = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Seating Layout</title>
    <style>
        .seating-container {
            position: relative;
            width: 500px;
            height: 500px;
            background-color: lightgray;
        }
        .table {
            position: absolute;
            width: 50px;
            height: 50px;
            background-color: red;
            text-align: center;
            line-height: 50px;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
    <script>
        function selectSeat(id) {
            alert("Table " + id + " selected!");
        }
    </script>
</head>
<body>
    <h2>Interactive Seating Layout</h2>
    <div class="seating-container">
        <?php foreach ($tables as $table) {
            $coords = json_decode($table['position'], true);
            $x = $coords[0]['x'] * 500;
            $y = $coords[0]['y'] * 500;
        ?>
            <div class="table" onclick="selectSeat(<?= $table['id']; ?>)" 
                 style="left: <?= $x; ?>px; top: <?= $y; ?>px;">
                <?= $table['id']; ?>
            </div>
        <?php } ?>
    </div>
</body>
</html>
