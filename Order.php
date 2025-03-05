<div class="food-container">
    <?php
    require 'connect.php'; // Database connection

    $stmt = $pdo->query('SELECT "ID", "Name", "Price", "Image" FROM "MenuItem"');
    $menuItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($menuItems as $item) {
        echo '<div class="food-item">';
        if (!empty($item['Image'])) {
            echo '<img src="' . htmlspecialchars($item['Image']) . '" alt="Food Image">';
        }
        echo '<h3>' . htmlspecialchars($item['Name']) . '</h3>';
        echo '<p>$' . number_format(htmlspecialchars($item['Price']), 2) . '</p>';
        echo '<button class="add-to-cart" data-name="' . htmlspecialchars($item['Name']) . '" data-price="' . htmlspecialchars($item['Price']) . '">Add to Cart</button>';
        echo '</div>';
    }
    ?>
</div>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TableTryst - Food Menu</title>
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

        .food-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); /* Responsive Grid */
            gap: 20px;
            padding: 40px 20px;
            max-width: 1200px;
            margin: 80px auto 0; /* Adjusted margin-top to push below navbar */
        }

        .food-item {
            background: #ffffff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
            overflow: hidden;
        }

        .food-item:hover {
            transform: scale(1.05);
            box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.3);
        }

        .food-item img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 10px;
        }

        .food-item h3 {
            font-size: 20px;
            margin-top: 15px;
            color: #333;
            font-weight: bold;
        }

        .food-item p {
            font-size: 18px;
            color: #ff7700;
            font-weight: bold;
            margin: 10px 0;
        }

        .food-item .add-to-cart {
            background: #ff7700;
            color: white;
            font-weight: bold;
            padding: 10px 15px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
            position: absolute;
            bottom: 15px;
            left: 50%;
            transform: translateX(-50%);
        }

        .food-item .add-to-cart:hover {
            background: #ff9900;
        }
        .cart-sidebar {
            position: fixed;
            top: 70px; /* Positioned right below the navbar */
            right: -300px; /* Initially hidden */
            width: 300px;
            height: calc(100% - 70px); /* Ensures it doesn't overlap the navbar */
            background: #fff;
            box-shadow: -2px 0px 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            overflow-y: auto; /* Allows scrolling when items overflow */
            transition: right 0.3s ease-in-out;
            z-index: 999;
}

        .cart-sidebar.open {
            right: 0;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        #viewCartBtn {
            display: block;
            margin: 100px auto 20px; /* Adjusted margin to appear below navbar */
            text-align: center;
            width: 200px;
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

    <div class="text-center">
    <button id="viewCartBtn" class="btn btn-primary">View Cart</button>
        </div>
        <div class="food-container">
</div>

<div id="cartSidebar" class="cart-sidebar">
    <h3>Cart (<span id="cartCount">0</span> items)</h3>
    <div id="cartItems"></div>
    <hr>
    <p><strong>Subtotal:</strong> $<span id="cartTotal">0.00</span></p>
    <button class="btn btn-danger" id="checkoutBtn">Checkout</button>
    <button class="btn btn-secondary" id="closeCartBtn">Close</button>
</div>   
<<script>
        document.addEventListener("DOMContentLoaded", function () {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    function updateCartDisplay() {
        let cartItems = document.getElementById("cartItems");
        let cartCount = document.getElementById("cartCount");
        let cartTotal = document.getElementById("cartTotal");

        cartItems.innerHTML = "";
        let total = 0;
        let itemCount = 0;

        cart.forEach((item, index) => {
            total += item.price * item.quantity;
            itemCount += item.quantity;
            cartItems.innerHTML += `
                <div class="cart-item">
                    <span>${item.name} (${item.quantity})</span>
                    <span>$${(item.price * item.quantity).toFixed(2)}</span>
                    <button class="btn btn-sm btn-danger" onclick="changeQuantity(${index}, -1)">-</button>
                    <button class="btn btn-sm btn-success" onclick="changeQuantity(${index}, 1)">+</button>
                </div>
            `;
        });

        cartCount.innerText = itemCount;
        cartTotal.innerText = total.toFixed(2);
        localStorage.setItem("cart", JSON.stringify(cart));
    }

    window.changeQuantity = function (index, amount) {
        if (cart[index]) {
            cart[index].quantity += amount;
            if (cart[index].quantity <= 0) {
                cart.splice(index, 1);
            }
        }
        updateCartDisplay();
    };

    function addToCart(name, price) {
        let existingItem = cart.find(item => item.name === name);
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            cart.push({ name, price, quantity: 1 });
        }
        updateCartDisplay();
    }

    function attachAddToCartListeners() {
        document.querySelectorAll(".add-to-cart").forEach(button => {
            button.addEventListener("click", function () {
                let name = this.getAttribute("data-name");
                let price = parseFloat(this.getAttribute("data-price"));
                addToCart(name, price);
            });
        });
    }

    document.getElementById("viewCartBtn").addEventListener("click", function () {
        document.getElementById("cartSidebar").classList.add("open");
        updateCartDisplay();
    });

    document.getElementById("closeCartBtn").addEventListener("click", function () {
        document.getElementById("cartSidebar").classList.remove("open");
    });

    document.getElementById("checkoutBtn").addEventListener("click", function () {
        window.location.href = "customer_form.php";
    });

    function fetchMenu() {
        fetch("menu.php")
            .then(response => response.text())
            .then(data => {
                document.querySelector(".food-container").innerHTML = data;
                attachAddToCartListeners();
            })
            .catch(error => console.error("Error fetching menu:", error));
    }

    attachAddToCartListeners();
    updateCartDisplay();
});

</script>
</body>
</html>
