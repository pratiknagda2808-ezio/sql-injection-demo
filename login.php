<?php
$conn = mysqli_connect("localhost", "root", "Assassin123@", "login_demo");
if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }
$username = $_POST['username'];
$query = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    echo "Welcome, " . $username;
} else {
    echo "Invalid username";
}
?>
