<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

html, body{
    display: grid;
    height: 100%;
    width: 100%;
    place-items: center;
}

.wrapper{
    max-width: 500px;
    background-color: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 15px 20px rgba(0, 0, 0, .1);
    overflow: hidden;
}

.wrapper .title-text{
    display: flex;
    width: 200%;
}

.wrapper .title-text .title{
    width: 50%;
    font-size: 35px;
    font-weight: 600;
    text-align: center;
    transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    color: #555;
}

.wrapper .form-container{
    width: 100%;
    overflow: hidden;
}

.form-container .slide-controls{
    display: flex;
    justify-content: space-between;
    height: 50px;
    width: 100%;
    border: 1px solid lightgrey;
    overflow: hidden;
    margin: 30px 0 10px 0;
    border-radius: 10px;
    position: relative;
}

.slide-controls .slide{
    width: 100%;
    height: 100%;
    font-size: 18px;
    font-weight: 500;
    line-height: 48px;
    text-align: center;
    cursor: pointer;
    color: #fff;
    z-index: 1;
    transition: all .6s ease;        
}

.slide-controls .signup{
    color: #212121;
}

.slide-controls .slide-tab{
    position: absolute;
    height: 100%;
    width: 50%;
    top: 0;
    left: 0;
    z-index: 0;
    background: style="background-color: #009688";
    transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

input[type="radio"]{
    display: none;
}

#signup:checked ~ .slide-tab{
    left: 50%;
}

#signup:checked ~ .signup{
    color: #fff;
}

#signup:checked ~ .login{
    color: #212121;
}

.form-container .form-inner{
    display: flex;
    width: 200%;
}

.form-container{
    width: 200%;
}

.form-inner form .field{
    height: 50px;
    width: 100%;
    width: 330px;
    margin-top: 20px;
}

.form-inner form .field input{
    width: 100%;
    height: 100%;
    outline: none;
    font-size: 17px;
    padding-left: 15px;
    border-radius: 10px;
    border: 1px solid lightgray;
    border-bottom-width: 2px;
    transition: all 0.4s ease;
}

.form-inner form .field input:focus{
    border-color: #fc83bb;
}

.form-inner form .pass-link{
    margin-top: 5px;
}

.form-inner form .pass-link a,
a{
    color: #fa4299;
    text-decoration: none;
}

.form-inner form .signup-link{
    color: #212121;
    text-align: center;
    margin-top: 30px;
}

.form-inner form .pass-link a:hover,
.form-inner form .signup-link a:hover{
    text-decoration: underline;
}

form .field input[type="submit"]{
    background: style="background-color: #009688";
    color: #fff;
    font-size: 20px;
    font-weight: 500;
    padding-left: 0;
    border: none;
    cursor: pointer;
}

.form-inner form .field select {
    width: 100%;
    height: 100%;
    outline: none;
    font-size: 17px;
    padding-left: 15px;
    border-radius: 10px;
    border: 1px solid lightgray;
    border-bottom-width: 2px;
    transition: all 0.4s ease;
}

.form-inner form .field select:focus {
    border-color: #fc83bb;
}

.container {
    width: 100%;
    height: 100vh;
    background-color: white;
    background-size: cover;
    padding-left: 8%;
    padding-right: 8%;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
</style>
<body>
    <div class="container">
    <div class="wrapper">
        <div class="title-text">
            <div class="title sign up">Sign up</div>
        </div>
        <div class="form-container">
            <div class="form-inner">
                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" class="signup">
                    <div class="field">
                        <input type="text" name="name" placeholder="Restaurant Name">
                    </div>
                    <div class="field">
                        <input type="email" name="email" placeholder="Email Address" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                    </div>
                    <div class="field">
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="field">
                        <input type="number" name="phone_number" placeholder="Phone Number" required>
                    </div>
                    <div class="field" >
                        <input type="submit" value="Sign up" style="background-color: #009688" required>
                    </div>
                    <p style="margin-top: 10%;text-align: center;">Already have an account? <a href="login.php" style="color: #009688">Login now</a></p>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
<html>
<?php
require 'connect.php'; // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Get form data and sanitize input
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $phone_number = trim($_POST['phone_number']);

        // Debugging: Check if form data is received correctly
        echo "Received data: Name = $name, Email = $email, Phone = $phone_number <br>";

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die("❌ Invalid email format.");
        }

        // Set is_admin to 0 (default)
        $is_admin = 0;

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Debugging: Check hashed password
        echo "Hashed Password: $hashed_password <br>";

        // **USE $pdo INSTEAD OF $conn**
        $stmt = $conn->prepare('INSERT INTO userdata ("name", "phoneNum", "email", "password", "is_admin") VALUES (:name, :phoneNum, :email, :password, :is_admin)');

        // Bind parameters
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":phoneNum", $phone_number);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $hashed_password);
        $stmt->bindParam(":is_admin", $is_admin, PDO::PARAM_INT);

        // Execute the query
        if ($stmt->execute()) {
            echo "<script>alert('Sign up successful!'); window.location.href='login.php';</script>";
        } else {
            echo "❌ Sign up failed.";
        }

    } catch (PDOException $e) {
        die("❌ Database error: " . $e->getMessage());
    }
}
?>


