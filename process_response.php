<?php
require 'connect.php';

$file = $_GET['file'];
$jsonData = file_get_contents('../output.json');
$response = json_decode($jsonData, true);

if (isset($response['responses'][0]['localizedObjectAnnotations'])) {
    foreach ($response['responses'][0]['localizedObjectAnnotations'] as $object) {
        if ($object['name'] == 'Table') {
            $vertices = json_encode($object['boundingPoly']['normalizedVertices']);
            $query = "INSERT INTO tables (image, position) VALUES (:image, :position)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':image', $file);
            $stmt->bindParam(':position', $vertices);
            $stmt->execute();
        }
    }
}

header("Location: seating.php");
exit();
?>
