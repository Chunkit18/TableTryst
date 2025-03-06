<?php
require 'vendor/autoload.php';

use Google\Cloud\Vision\V1\client\ImageAnnotatorClient;
use Google\Cloud\Vision\V1\Feature;
use Google\Cloud\Vision\V1\Image;
use Google\Cloud\Vision\V1\AnnotateImageRequest;

putenv('GOOGLE_APPLICATION_CREDENTIALS=C:\xampp\htdocs\fyp\TableTryst\service-account.json');

function detectTablesAndChairs($imagePath) {
    $imageAnnotator = new ImageAnnotatorClient();

    $imageData = file_get_contents($imagePath);

    $image = new Image();
    $image->setContent($imageData);

    $feature = new Feature();
    $feature->setType(Feature::OBJECT_LOCALIZATION); // ✅ Correct constant

    $request = new AnnotateImageRequest();
    $request->setImage($image);
    $request->setFeatures([$feature]);

    $response = $imageAnnotator->batchAnnotateImages([$request]);

    echo "<pre>";
    print_r($response);
    echo "</pre>";

    $imageAnnotator->close();
}

// Test with an image
detectTablesAndChairs('uploads/seats.png');
