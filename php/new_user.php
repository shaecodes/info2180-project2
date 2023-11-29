<?php
$firstName = $_POST["firstName"] ?? '';
$lastName = $_POST["lastName"] ?? '';
$email = $_POST["email"] ?? '';
$password = $_POST["password"] ?? '';
$role = $_POST["role"] ?? '';

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$conn = new mysqli("localhost", "root", "", "dolphin_crm");
if ($conn->connect_error) {
    die("Failed to connect: " . $conn->connect_error);
}

$sql = "INSERT INTO users (firstname, lastname, email, password, role) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error in the SQL query: " . $conn->error);
}

if (!$stmt->bind_param("sssss", $firstName, $lastName, $email, $hashedPassword, $role)) {
    die("Error binding parameters: " . $stmt->error);
}

if ($stmt->execute()) {
    echo "<h2>User added successfully</h2>";
} else {
    echo "<h2>Error adding user: " . $stmt->error . "</h2>";
}

$stmt->close();
$conn->close();
?>
