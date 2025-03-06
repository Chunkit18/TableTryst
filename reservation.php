<?php
session_start();
require 'connect.php';

// Error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ensure database connection is established
if (!isset($conn) && !isset($pdo)) {
    die("❌ Database connection error.");
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Owner</title>
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
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#myNav">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="myNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="owner.php" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="reservation.php" class="nav-link">Reservations</a></li>
                <li class="nav-item"><a href="login.php" class="nav-link">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Reservations
                            <a href="user-create.php" class="btn btn-primary float-end">Add Reservations</a>
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
                                <?php
                                $query = 'SELECT * FROM "Reservation"';
                                $query_run = $conn->query($query);

                                if (!$query_run) {
                                    die("Query Failed: " . mysqli_error($conn));
                                }

                                if ($query_run->rowCount() > 0) {
                                    while ($reservation = $query_run->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                        <tr>
                                            <td><?= $reservation['ID']; ?></td>
                                            <td><?= $reservation['Customer']; ?></td>
                                            <td><?= $reservation['Restaurant']; ?></td>
                                            <td><?= $reservation['Date']; ?></td>
                                            <td><?= $reservation['Time']; ?></td>
                                            <td><?= $reservation['NumberOfGuests']; ?></td>
                                            <td><?= $reservation['Status']; ?></td>
                                            <td><?= $reservation['Phone']; ?></td>
                                            <td>
                                                <a href="user-view.php?id=<?= $reservation['ID']; ?>" class="btn btn-info btn-sm">View</a>
                                                <a href="user-edit.php?id=<?= $reservation['ID']; ?>" class="btn btn-success btn-sm">Edit</a>
                                                <form action="user-action.php" method="POST" class="d-inline">
                                                    <input type="hidden" name="id" value="<?= $reservation['ID']; ?>">
                                                    <button type="submit" name="delete_user" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>No Record Found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </div>
</html>