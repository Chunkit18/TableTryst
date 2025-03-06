<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TableTryst</title>
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

        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: center;
            background-color: #f8f8f8;
            padding-top: 80px;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        .restaurant-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
            max-width: 1000px;
            margin: auto;
        }

        .restaurant-btn {
            background-color: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex;
            flex-direction: column;
            align-items: center;
            border: none;
            width: 100%;
        }

        .restaurant-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }

        .restaurant-btn img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }

        .select-btn {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #f8aa02;
            border: none;
            color: white;
            font-weight: bold;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .select-btn:hover {
            background-color: #d48f02;
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
                <li class="nav-item">
                    <a href="Homepage.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Categories</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Meals</a>
                </li>
                <li class="nav-item">
                    <a href="Order.php" class="nav-link">Cart</a>
                </li>
                <li class="nav-item">
                    <a href="SelectRestaurant.php" class="nav-link">Booking</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="restaurant-container">
    <div class="restaurant-btn">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/05/McDonald%27s_square_2020.svg/800px-McDonald%27s_square_2020.svg.png" alt="Mcdonald">
        <button class="select-btn" onclick="alert('You selected Mcdonald!')">Select</button>
    </div>
    <div class="restaurant-btn">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSjFRn8SX1GQnEncI5qtMNe5cC3p5tN0eMymw&s" alt="KFC">
        <button class="select-btn" onclick="alert('You selected KFC!')">Select</button>
    </div>
    <div class="restaurant-btn">
        <img src="https://play-lh.googleusercontent.com/0M-kzfTCHkOXl66G35Hfvr4o9slSqmFF5LQPy07v89YdR12b3TZb57Pm_JKLFJQj4rrt" alt="Pizza Hut">
        <button class="select-btn" onclick="alert('You selected Pizza Hut!')">Select</button>
    </div>
    <div class="restaurant-btn">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3e/Domino%27s_pizza_logo.svg/1200px-Domino%27s_pizza_logo.svg.png" alt="Domino">
        <button class="select-btn" onclick="alert('You selected Domino!')">Select</button>
    </div>
    <div class="restaurant-btn">
        <img src="https://mir-s3-cdn-cf.behance.net/projects/404/34938695120473.Y3JvcCw5NTUsNzQ3LDExNSw3MA.jpg" alt="Western">
        <button class="select-btn" onclick="alert('You selected Western!')">Select</button>
    </div>
</div>
</body>
</html>