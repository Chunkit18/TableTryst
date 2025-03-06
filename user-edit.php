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

    <title>User Edit</title>
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>User Edit
                        <a href="admin.php" class="btn btn-danger float-end">BACK</a>
                    </h4>
                </div>
                <div class="card-body">
                    <?php
                    if (isset($_GET['id'])) {
                        require 'connect.php'; // Ensure PDO connection is included

                        $user_id = $_GET['id']; // No need for escaping when using prepared statements

                        // 🔥 Fixed SQL Query - Removed Quotes around Column Name
                        $query = 'SELECT * FROM userdata WHERE "userID" = :id';
                        $stmt = $conn->prepare($query);
                        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
                        $stmt->execute();

                        // Fetch user data
                        $user = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($user) {
                            ?>
                            <form action="user-action.php" method="POST">
                                <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['userID'] ?? ''); ?>">

                                <div class="mb-3">
                                    <label>User Name</label>
                                    <input type="text" name="name" value="<?= htmlspecialchars($user['name'] ?? ''); ?>" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label>User Email</label>
                                    <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? ''); ?>" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label>User Phone</label>
                                    <input type="text" name="phone" value="<?= htmlspecialchars($user['phoneNum'] ?? ''); ?>" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <button type="submit" name="Update_user" class="btn btn-primary">Update User</button>
                                </div>
                            </form>
                            <?php
                        } else {
                            echo "<h4>No User Found</h4>";
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
