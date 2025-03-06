<?php
session_start();
require 'connect.php'; // Ensure this file connects to the database properly

// Error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    // Retrieve form data
    $rname = trim($_POST['rname']);
    $otime = $_POST['otime'];
    $ctime = $_POST['ctime'];
    $location = $_POST['location'];
    $desc = trim($_POST['desc']);
    
    // Validate input
    if (empty($rname) || empty($location)) {
        die("❌ Restaurant Name and Location are required.");
    }
    
    try {
        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO restaurant (name, otime, ctime, location) VALUES (:rname, :otime, :ctime, :location)");
        
        // Bind parameters
        $stmt->bindParam(':rname', $rname);
        $stmt->bindParam(':otime', $otime);
        $stmt->bindParam(':ctime', $ctime);
        $stmt->bindParam(':location', $location);
        
        // Execute the query
        if ($stmt->execute()) {
            header("Location: owner.php");
        } else {
            echo "❌ Error adding restaurant.";
        }
    } catch (PDOException $e) {
        die("❌ Database error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<style>
	* {
    margin: 0;
    padding: 0;
    box-sizing: border-box; 
    font-family: sans-serif;
}

body {
    background: white;
    height: 100vh;
    margin: 0;
    margin-top: -50px;
}

.container {
	gap: 40px;
}

.item {
}

.box {
    width: 100%;
    height: auto; 
    position: relative;
    padding: 20px; 
}

form {
    background-color: white;
    padding: 15px 30px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    max-width: 700px;
    width: 100%;
	margin: 100px auto;
}

form h2 {
    margin-bottom: 20px;
    text-align: center;
    color: #333;
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #333;
}

input[type="checkbox"] {
    accent-color:red;
}

input[type="text"], input[type="number"], input[type="date"], select, input[type="radio"], input[type="time"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    outline: none;
    transition: border 0.3s;
}

input[type="text"]:focus, input[type="number"]:focus, input[type="date"]:focus, select:focus, input[type="time"]:focus {
    border-color: #009688;
}

button {
    width: 100%;
    padding: 10px;
    background-color: #009688;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    margin-top: 10px;
}

button.clear {
    background-color: #f44336;
}

button:hover {
    opacity: 0.9;
}

button:active {
    transform: scale(0.98);
}

input::placeholder {
    color: #888;
}

.buttons {
    display: flex;
	gap: 40px;
    justify-content: space-between;
}

a{
    text-decoration: none;
}

.radio-container { 
			display:flex;
			align-items:center;
		}

</style>

<head><title>TableTryst</title></head>
<body>
		<div class="box">
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
		<h2>Restaurant</h2>
		<!--Name Input-->
        <label for="name">Restaurant Name:</label>
        <input type="text" size="25" id="rname" name="rname" 
		maxlength="30" placeholder="Restaurant Name" required><br><br>

        <label for="otime">Opening Time:</label>
        <input type="time" size="25" id="otime" name="otime"><br><br>

        <label for="ctime">Closing Time:</label>
        <input type="time" size="25" id="ctime" name="ctime"><br><br>

		<div class="container">
			<div class="item">
            <label for="location">Location:</label>
		        <select name="location" id="type">
                    <option value="">- - -</option>
				    <option value="sunwayp">Sunway Pyramid</option>
				    <option value="sunwaym">Sunway Mentari</option>
				    <option value="subang">Subang Jaya</option>
		        </select>
			</div>

			<div class="item">
                <label for="desc">Description</label>
                <textarea id="desc" name="desc" rows="4" cols="93"></textarea>
			</div>
		</div>
			<div class="buttons">
				<button type="submit" id="submit" name="submit">Add</button>
				<button type="reset" value="Clear" id="reset" name="reset" class="clear">Clear</button>	
			</div>
	</form>
</div>
</body>
</html>