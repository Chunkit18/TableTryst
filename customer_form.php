<?php
require 'connect.php';
$conn = $pdo;

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $name = $_POST['name'];
        $price = $_POST['price'];

        // Image upload
        $imagePath = null;
        if (!empty($_FILES['image']['name'])) {
            $targetDir = "uploads/";
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
            $imagePath = $targetDir . uniqid() . "." . $imageFileType;

            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
                die("❌ Image upload failed.");
            }
        }

        // Insert into database
        $stmt = $conn->prepare('INSERT INTO "MenuItem" (Name, Price, Image) VALUES (:name, :price, :image)');
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':price', $price, PDO::PARAM_STR);
        $stmt->bindValue(':image', $imagePath, PDO::PARAM_STR);
        $stmt->execute();
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['delete_id'];

        // Delete menu item
        $stmt = $conn->prepare('DELETE FROM "MenuItem" WHERE ID = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}

// Fetch menu items
$result = $conn->query('SELECT * FROM "MenuItem"');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Menu</title>
    <style>
        body {
            padding-top: 80px; /* Ensure content starts below navbar */
            background-color: #f8f9fa;
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

            .nav-item {
                margin: 10px 0;
            }
        }

        .container {
            max-width: 900px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .menu-image {
            max-width: 100px;
            height: auto;
            border-radius: 5px;
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
                <li class="nav-item"><a href="Homepage.php" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="Order.php" class="nav-link">Cart</a></li>
                <li class="nav-item"><a href="SelectRestaurant.php" class="nav-link">Booking</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h2 class="text-center">Manage Menu</h2>
    <form method="POST" enctype="multipart/form-data" class="mb-4">
        <div class="mb-3">
            <label for="name" class="form-label">Food Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price:</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Food Image:</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
        </div>
        <button type="submit" name="add" class="btn btn-primary w-100">Add Food</button>
    </form>

    <h3 class="text-center">Menu Items</h3>
    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['ID']) ?></td>
                    <td>
                        <?php if (!empty($row['Image'])): ?>
                            <img src="<?= htmlspecialchars($row['Image']) ?>" class="menu-image">
                        <?php else: ?>
                            <span>No Image</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($row['Name']) ?></td>
                    <td>$<?= htmlspecialchars($row['Price']) ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="delete_id" value="<?= $row['ID'] ?>">
                            <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
