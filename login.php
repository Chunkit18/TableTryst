<?php
session_start();
require 'connect.php'; // This file now uses PDO (PostgreSQL)

// If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Prepare SQL statement using PDO
        $stmt = $conn->prepare('SELECT "userID", "is_admin", "password" FROM userdata WHERE email = :email');
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $hashed_password = $user['password'];

            // Verify the password
            if (password_verify($password, $hashed_password)) {
                $_SESSION['userID'] = $user['userID'];
                $_SESSION['email'] = $email;
                $_SESSION['logged_in'] = true;

                // Redirect based on role
                if ($user['is_admin'] == 1) {
                    header("Location: admin.php");
                } else {
                    header("Location: owner.php");
                }
                exit();
            } else {
                echo "<script>alert('Invalid password or email! Try again'); window.location.href='login.php';</script>";
            }
        } else {
            ;echo "<script>alert('No user found with this email!'); window.location.href='login.php';</script>";
        }
    } catch (PDOException $e) {
        die("❌ Database error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

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
    background: -webkit-linear-gradient(left, #a445b2, #fa4299);
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
    color: #009688;
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
    background: #009688;
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
            <div class="title signup">Login</div>
        </div>
        <div class="form-container">
            <div class="form-inner">
                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" class="signup">
                    <div class="field">
                        <input type="text" name="email" placeholder="Email Address" required>
                    </div>
                    <div class="field">
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="field">
                        <input type="submit" value="Login" required>
                    </div>
                    <p style="margin-top: 10%;text-align: center;">Don't have an account? <a href="register.php">Signup now</a></p>
                </form>
            </div>
        </div>
    </div>  
</div>
</body>
<html>