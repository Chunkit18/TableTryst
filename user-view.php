<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>User View</title>
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>User View Details
                        <a href="admin.php" class="btn btn-danger float-end">BACK</a>
                    </h4>
                </div> 
                <div class="card-body">
                    <?php
                    session_start();
                    require 'connect.php'; // Ensure $pdo is defined in connect.php

                    if (isset($_GET['id'])) {
                        $user_id = $_GET['id'];

                        // Prepare and execute query
                        $query = 'SELECT * FROM userdata WHERE "userID" = :id';
                        $stmt = $conn->prepare($query);
                        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
                        $stmt->execute();

                        // Fetch the user data
                        $user = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($user) {
                            ?>
                            <div class="mb-3">
                                <label>User Name</label>
                                <p class="form-control"><?= htmlspecialchars($user['name']); ?></p>
                            </div>
                            <div class="mb-3">
                                <label>User Email</label>
                                <p class="form-control"><?= htmlspecialchars($user['email']); ?></p>
                            </div>
                            <div class="mb-3">
                                <label>User Phone</label>
                                <p class="form-control"><?= htmlspecialchars($user['phoneNum']); ?></p>
                            </div>
                            <?php
                        } else {
                            echo "<h4>No User Found</h4>";
                        }
                    }
                    ?>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>
