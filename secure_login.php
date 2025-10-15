<?php
$conn = new mysqli("localhost", "root", "Assassin123@", "login_demo");
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
$stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
$stmt->bind_param("s", $_POST['username']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    echo "Welcome!";
} else {
    echo "Invalid username";
}
?>
