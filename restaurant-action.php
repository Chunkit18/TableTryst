<?php
session_start();
require 'connect.php';

echo "<pre>";
print_r($_POST); // ✅ This will display everything sent via the form
echo "</pre>";

// Enable Full Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h3>Debugging Start</h3>"; // ✅ This ensures script execution reaches this point

// ✅ Update Restaurant
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_restaurant'])) {
    require 'connect.php';

    $restaurant_id = $_POST['id'] ?? null;
    $name = $_POST['name'] ?? null;
    $location = $_POST['location'] ?? null;
    $otime = $_POST['otime'] ?? null;
    $ctime = $_POST['ctime'] ?? null;

    if (!$restaurant_id) {
        die("❌ Error: Restaurant ID is missing.");
    }

    try {
        $query = "UPDATE restaurant SET name = :name, location = :location, otime = :otime, ctime = :ctime WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':location', $location, PDO::PARAM_STR);
        $stmt->bindParam(':otime', $otime, PDO::PARAM_STR);
        $stmt->bindParam(':ctime', $ctime, PDO::PARAM_STR);
        $stmt->bindParam(':id', $restaurant_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $_SESSION['message'] = "✅ Restaurant Updated Successfully!";
            header("Location: owner.php");
            exit();
        } else {
            print_r($stmt->errorInfo());
            exit();
        }
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}

// ✅ Delete Restaurant
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_restaurant'])) {
    echo "Processing Delete Request...<br>";

    $restaurant_id = $_POST['restaurant_id'] ?? null;

    if (!$restaurant_id) {
        die("❌ Error: Restaurant ID is missing.");
    }

    try {
        $query = "DELETE FROM restaurant WHERE id = :id";
        $stmt = $conn->prepare($query);

        echo "Query: $query<br>";

        $stmt->bindParam(':id', $restaurant_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "✅ Deletion successful! Redirecting...";
            $_SESSION['message'] = "✅ Restaurant Deleted Successfully!";
            header("Location: owner.php");
            exit();
        } else {
            echo "<br><b>❌ SQL Execution Failed:</b> ";
            print_r($stmt->errorInfo());
            exit();
        }
    } catch (PDOException $e) {
        die("❌ Database Error: " . $e->getMessage());
    }
}

// ✅ Add New Restaurant
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_restaurant'])) {
    echo "Processing Add Request...<br>";

    $name = $_POST['name'] ?? null;
    $location = $_POST['location'] ?? null;
    $otime = $_POST['otime'] ?? null;
    $ctime = $_POST['ctime'] ?? null;

    if (!$name || !$location || !$otime || !$ctime) {
        die("❌ Error: All fields are required.");
    }

    try {
        $query = "INSERT INTO restaurant (name, location, otime, ctime) VALUES (:name, :location, :otime, :ctime)";
        $stmt = $conn->prepare($query);

        echo "Query: $query<br>";

        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':location', $location, PDO::PARAM_STR);
        $stmt->bindParam(':otime', $otime, PDO::PARAM_STR);
        $stmt->bindParam(':ctime', $ctime, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "✅ Insertion successful! Redirecting...";
            $_SESSION['message'] = "✅ Restaurant Created Successfully!";
            header("Location: owner.php");
            exit();
        } else {
            echo "<br><b>❌ SQL Execution Failed:</b> ";
            print_r($stmt->errorInfo());
            exit();
        }
    } catch (PDOException $e) {
        die("❌ Database Error: " . $e->getMessage());
    }
}

echo "<h3>End of Debugging</h3>";
?>
