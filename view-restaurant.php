<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Restaurant View</title>
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Restaurant View Details
                        <a href="owner.php" class="btn btn-danger float-end">BACK</a>
                    </h4>
                </div> 
                <div class="card-body">
                    <?php
                    session_start();
                    require 'connect.php'; // Ensure $conn is defined in connect.php

                    if (isset($_GET['id'])) {
                        $restaurant_id = $_GET['id'];

                        // Prepare and execute query
                        $query = 'SELECT * FROM restaurant WHERE id = :id';
                        $stmt = $conn->prepare($query);
                        $stmt->bindParam(':id', $restaurant_id, PDO::PARAM_INT);
                        $stmt->execute();

                        // Fetch the restaurant data
                        $restaurant = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($restaurant) {
                            ?>
                            <div class="mb-3">
                                <label>Restaurant Name</label>
                                <p class="form-control"><?= htmlspecialchars($restaurant['name']); ?></p>
                            </div>
                            <div class="mb-3">
                                <label>Location</label>
                                <p class="form-control"><?= htmlspecialchars($restaurant['location']); ?></p>
                            </div>
                            <div class="mb-3">
                                <label>Opening Time</label>
                                <p class="form-control"><?= htmlspecialchars($restaurant['otime']); ?></p>
                            </div>
                            <div class="mb-3">
                                <label>Closing Time</label>
                                <p class="form-control"><?= htmlspecialchars($restaurant['ctime']); ?></p>
                            </div>
                            <?php
                        } else {
                            echo "<h4>No Restaurant Found</h4>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>
