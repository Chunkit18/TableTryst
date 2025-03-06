<?php
require 'connect.php'; // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Validate input
    if (!empty($name) && !empty($email) && preg_match('/^\d{8}$/', $phone)) {
        $query = 'INSERT INTO "customer" ("Name", "Email", "Phone") VALUES (:name, :email, :phone)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);

        if ($stmt->execute()) {
            echo "<script>alert('Registration Successful!'); window.location.href='customer_form.php';</script>";
        } else {
            echo "<script>alert('Error in registration. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('All fields are required and phone must be exactly 8 digits.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TableTryst</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function validatePhone() {
            var phone = document.getElementById("phone").value;
            if (!/^\d{8}$/.test(phone)) {
                alert("Phone number must be exactly 8 digits.");
                return false;
            }
            return true;
        }
    </script>
</head>
<style>
    .bg-color {
        background: #0f0f0ffb;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
        padding: 15px 0;
    }

    .navbar-brand {
        color: #f8aa02;
        font-weight: bold;
        font-size: 35px !important;
    }

    .nav-link {
        font-weight: bold;
        color: #f8aa02 !important;
        font-size: 20px;
        padding: 12px 18px;
        transition: color 0.3s ease, transform 0.2s;
    }

    .nav-link:hover {
        color: white !important;
        transform: scale(1.1);
    }

    .nav-link.active {
        color: white !important;
    }

    .navbar-toggler i {
        color: #f8aa02;
    }

    .navbar-toggler:hover i {
        color: #fff;
    }

    .collapse.navbar-collapse {
        transition: all 0.3s ease-in-out;
    }

    @media (max-width: 768px) {
        .navbar-nav {
            text-align: center;
        }
    }
</style>
<body>
    <nav class="navbar navbar-expand-lg bg-color">
        <div class="container">
            <a class="navbar-brand" href="#">TableTryst</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#myNav" aria-controls="myNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="myNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a href="Homepage.php" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Categories</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Meals</a></li>
                    <li class="nav-item"><a href="Order.php" class="nav-link">Cart</a></li>
                    <li class="nav-item"><a href="SelectRestaurant.php" class="nav-link">Booking</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 pt-5">
        <h2 class="text-center">Customer Registration</h2>
        <form method="POST" onsubmit="return validatePhone()">
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
</body>
</html>