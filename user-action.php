<?php
session_start();
require 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Update_user'])) {
    require 'connect.php';

    // Get form data safely
    $user_id = $_POST['user_id'] ?? null;
    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $phone = $_POST['phone'] ?? null;

    // Check if user ID is valid
    if (!$user_id) {
        die("Error: User ID is missing.");
    }

    // Debugging: Print received POST data
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    try {
        // 🔥 FIXED: Ensure correct table & column names
        $query = "UPDATE userdata SET name = :name, email = :email, \"phoneNum\" = :phone WHERE \"userID\" = :id";
        $stmt = $conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);

        // Execute query
        if ($stmt->execute()) {
            $_SESSION['message'] = "User Updated Successfully";
            header("Location: admin.php");
            exit();
        } else {
            // 🔥 DEBUG: Print SQL errors if the query fails
            print_r($stmt->errorInfo());
            exit();
        }
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_user'])) {
    require 'connect.php'; // Ensure connection

    $user_id = $_POST['user_id'] ?? null;

    if (!$user_id) {
        $_SESSION['message'] = "❌ User ID is missing.";
        header("Location: admin.php");
        exit();
    }

    try {
        // ✅ FIX: Ensure correct column name (check database schema)
        $query = "DELETE FROM userdata WHERE \"userID\" = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $_SESSION['message'] = "✅ User Deleted Successfully!";
        } else {
            $_SESSION['message'] = "❌ Failed to Delete User!";
        }

        header("Location: admin.php");
        exit();
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_user'])) {
    require 'connect.php';

    // ✅ Get input values
    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $phone = $_POST['phone'] ?? null;
    $password = $_POST['password'] ?? null;

    // ✅ Validate Inputs
    if (!$name || !$email || !$phone || !$password) {
        $_SESSION['message'] = "❌ All fields are required.";
        header("Location: user-create.php");
        exit();
    }

    try {
        // ✅ Securely hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // ✅ Correct SQL query (match column names)
        $query = "INSERT INTO userdata (name, email, \"phoneNum\", password) 
                  VALUES (:name, :email, :phone, :password)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $_SESSION['message'] = "✅ User Created Successfully!";
            header("Location: admin.php");
            exit();
        } else {
            $_SESSION['message'] = "❌ Failed to Create User!";
            header("Location: user-create.php");
            exit();
        }
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}
?>
