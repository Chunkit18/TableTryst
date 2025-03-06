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
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>TableTryst</title>
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Users Details
                            <a href="user-create.php" class="btn btn-primary float-end">Add Users</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Phone Number</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM userdata";
                                $query_run = $conn->query($query);

                                if (!$query_run) {
                                    die("Query Failed: " . mysqli_error($conn));
                                }

                                if ($query_run->rowCount() > 0) {
                                    while ($user = $query_run->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                        <tr>
                                            <td><?= $user['userID']; ?></td>
                                            <td><?= $user['phoneNum']; ?></td>
                                            <td><?= $user['email']; ?></td>
                                            <td><?= $user['password']; ?></td>
                                            <td>
                                                <a href="user-view.php?id=<?= $user['userID']; ?>" class="btn btn-info btn-sm">View</a>
                                                <a href="user-edit.php?id=<?= $user['userID']; ?>" class="btn btn-success btn-sm">Edit</a>
                                                <form action="user-action.php" method="POST" class="d-inline">
                                                    <input type="hidden" name="user_id" value="<?= $user['userID']; ?>">
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

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>