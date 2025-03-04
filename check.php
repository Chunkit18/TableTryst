<?php
require 'connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Booking</title>
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

        .navbar-nav {
            text-align: right;
        }

        @media (max-width: 768px) {
            .navbar-nav {
                text-align: center;
            }
        }
        
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-color">
        <div class="container">
            <a class="navbar-brand" href="#">TableTryst</a>
            <div class="order-lg-last btn-group">
                <i class="fas fa-shopping-bag fa-2x"></i>
            </div>
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

    <div class="container" style="margin-top: 100px; max-width: 600px;">
    <h2 class="text-center">Check Your Booking</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="customer_name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="customer_name" name="customer_name" required>
        </div>
        <div class="mb-3">
            <label for="booking_date" class="form-label">Booking Date:</label>
            <input type="date" class="form-control" id="booking_date" name="booking_date" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Check Booking</button>
    </form>
</div>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $customer_name = $_POST['customer_name'];
            $booking_date = $_POST['booking_date'];

            $stmt = $conn->prepare("SELECT * FROM reservations WHERE customer_name = ? AND booking_date = ?");
            $stmt->bind_param("ss", $customer_name, $booking_date);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<div class='mt-4'><h4>Booking Details</h4><ul class='list-group'>";
                while ($row = $result->fetch_assoc()) {
                    echo "<li class='list-group-item'>Restaurant: " . htmlspecialchars($row['restaurant_name']) . " | Time: " . htmlspecialchars($row['booking_time']) . "</li>";
                }
                echo "</ul></div>";
            } else {
                echo "<div class='mt-4 alert alert-danger'>No booking found!</div>";
            }

            $stmt->close();
        }
        ?>
    </div>
</body>
</html>
