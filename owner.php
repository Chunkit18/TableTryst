<?php
session_start();
require 'connect.php';

// Error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Fetch all restaurant data
    $stmt = $conn->query("SELECT * FROM restaurant");
    $restaurant = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch all reservations
    $stmt = $conn->query('SELECT * FROM "Reservation"');
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("❌ Database error: " . $e->getMessage());
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Owner</title>
    <style>
        body{
            padding: 75px;
        }
        .bg-color {
            background: #0f0f0ffb;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            padding: 15px 0;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-color">
    <div class="container">
        <a class="navbar-brand" href="#">TableTryst</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#myNav">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="myNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="owner.php" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="login.php" class="nav-link">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h4>Restaurant Details
                <a href="add-restaurant.php" class="btn btn-primary float-end">Add Restaurant</a>
            </h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Opening Time</th>
                        <th>Closing Time</th>
                        <th>Location</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($restaurant as $res): ?>
                        <tr>
                            <td><?= htmlspecialchars($res['name']); ?></td>
                            <td><?= htmlspecialchars($res['otime']); ?></td>
                            <td><?= htmlspecialchars($res['ctime']); ?></td>
                            <td><?= htmlspecialchars($res['location']); ?></td>
                            <td>
                                <a href="view-restaurant.php?id=<?= $res['id']; ?>" class="btn btn-info btn-sm">View</a>
                                <a href="edit-restaurant.php?id=<?= $res['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                <form action="delete-restaurant.php" method="POST" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $res['id']; ?>">
                                    <button type="submit" name="delete_restaurant" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h4>Reservations
                <a href="add-reservation.php" class="btn btn-primary float-end">Add Reservation</a>
            </h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer Name</th>
                        <th>Restaurant</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>No of Guests</th>
                        <th>Status</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservations as $res): ?>
                        <tr>
                            <td><?= $res['ID']; ?></td>
                            <td><?= htmlspecialchars($res['Customer']); ?></td>
                            <td><?= htmlspecialchars($res['Restaurant']); ?></td>
                            <td><?= htmlspecialchars($res['Date']); ?></td>
                            <td><?= htmlspecialchars($res['Time']); ?></td>
                            <td><?= htmlspecialchars($res['NumberOfGuests']); ?></td>
                            <td><?= htmlspecialchars($res['Status']); ?></td>
                            <td><?= htmlspecialchars($res['Phone']); ?></td>
                            <td>
                                <a href="view-reservation.php?id=<?= $res['ID']; ?>" class="btn btn-info btn-sm">View</a>
                                <a href="edit-reservation.php?id=<?= $res['ID']; ?>" class="btn btn-success btn-sm">Edit</a>
                                <form action="delete-reservation.php" method="POST" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $res['ID']; ?>">
                                    <button type="submit" name="delete_reservation" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
