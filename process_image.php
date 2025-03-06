<?php
require __DIR__ . '/vendor/autoload.php';

use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Google\Cloud\Vision\V1\Image;
use Google\Cloud\Vision\V1\Feature;
use Google\Cloud\Vision\V1\Feature_Type;

$googleCredentials = realpath(__DIR__ . '/config/google-cloud-key.json');
if (!$googleCredentials) {
    die("❌ Error: Google Cloud credentials file not found!");
}
putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $googleCredentials);

$client = new ImageAnnotatorClient();

require 'connect.php'; // Database connection   

if (!isset($_GET['file'])) {
    die("❌ Error: No image specified.");
}

$imagePath = $_GET['file'];

if (!file_exists($imagePath)) {
    die("❌ Error: Image file does not exist.");
}

// Initialize Google Cloud Vision API
$imageData = file_get_contents($imagePath);
$imageObject = (new Image())->setContent($imageData);

$response = $client->annotateImage($imageObject, [
    new Feature(['type' => Feature_Type::OBJECT_LOCALIZATION])
]);

$tableData = [];

foreach ($response->getLocalizedObjectAnnotations() as $object) {
    if ($object->getName() === "Table" && $object->hasBoundingPoly()) {
        $vertices = $object->getBoundingPoly()->getNormalizedVertices();

        if (count($vertices) >= 3) { // Ensure we have enough points
            $tableData[] = [
                'x' => $vertices[0]->getX(), 
                'y' => $vertices[0]->getY(),
                'width' => abs($vertices[2]->getX() - $vertices[0]->getX()), 
                'height' => abs($vertices[2]->getY() - $vertices[0]->getY())
            ];
        }
    }
}

// Store table data in the database
$query = "INSERT INTO tables (image_path, table_data) VALUES (:image, :data)";
$stmt = $conn->prepare($query);
$stmt->bindParam(':image', $imagePath, PDO::PARAM_STR);
$stmt->bindParam(':data', json_encode($tableData), PDO::PARAM_STR);

if ($stmt->execute()) {
    echo "✅ Table data saved successfully!";
} else {
    die("❌ Failed to save table data.");
}
?>
