<?php
session_start();
require 'connect.php'; // Make sure this path is correct

// Check if a file is uploaded
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $target_dir = "uploads/"; // Make sure this folder exists!
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Allowed file types
    $allowed_types = ['jpg', 'jpeg', 'png'];

    if (!in_array($imageFileType, $allowed_types)) {
        die("❌ Error: Only JPG, JPEG, and PNG files are allowed.");
    }

    // Move the file to the uploads folder
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Store in database
        $query = "INSERT INTO images (filename, uploaded_at) VALUES (:filename, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':filename', $target_file, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $_SESSION['message'] = "✅ Image uploaded successfully!";
            header("Location: process_image.php?file=" . urlencode($target_file));
            exit();
        } else {
            die("❌ Database error: Failed to save image info.");
        }
    } else {
        die("❌ Error: Failed to upload file.");
    }
} else {
    die("❌ No file uploaded.");
}
?>
