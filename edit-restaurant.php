<?php
session_start();
require 'connect.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Restaurant Edit</title>
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Restaurant Edit
                        <a href="owner.php" class="btn btn-danger float-end">BACK</a>
                    </h4>
                </div>
                <div class="card-body">
                    <?php
                    if (isset($_GET['id'])) {
                        require 'connect.php'; // Ensure PDO connection is included

                        $restaurant_id = $_GET['id']; // No need for escaping when using prepared statements

                        // Fetch restaurant details
                        $query = 'SELECT * FROM restaurant WHERE id = :id';
                        $stmt = $conn->prepare($query);
                        $stmt->bindParam(':id', $restaurant_id, PDO::PARAM_INT);
                        $stmt->execute();

                        $restaurant = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($restaurant) {
                            ?>
                            <form action="restaurant-action.php" method="POST">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($restaurant['id'] ?? ''); ?>">
                                <div class="mb-3">
                                    <label>Restaurant Name</label>
                                    <input type="text" name="name" value="<?= htmlspecialchars($restaurant['name'] ?? ''); ?>" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label>Location</label>
                                    <input type="text" name="location" value="<?= htmlspecialchars($restaurant['location'] ?? ''); ?>" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label>Opening Time</label>
                                    <input type="time" name="otime" value="<?= htmlspecialchars($restaurant['otime'] ?? ''); ?>" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label>Closing Time</label>
                                    <input type="time" name="ctime" value="<?= htmlspecialchars($restaurant['ctime'] ?? ''); ?>" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                <button type="submit" name="update_restaurant" class="btn btn-primary">Update Restaurant</button>
                                </div>
                            </form>
                            <?php
                        } else {
                            echo "<h4>No Restaurant Found</h4>";
                        }
                    } else {
                        echo "<h4>No ID Provided</h4>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
