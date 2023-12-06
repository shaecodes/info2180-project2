<?php
$host = 'localhost';
$username = 'proj2_user';
$password = 'groupbest1234';
$dbname = 'dolphin_crm';

$firstName = $_POST["firstName"] ?? '';
$lastName = $_POST["lastName"] ?? '';
$email = $_POST["email"] ?? '';
$password_get = $_POST["password"] ?? '';
$role = $_POST["role"] ?? '';

$firstName_filter = filter_var($firstName, FILTER_SANITIZE_STRING);
$lastName_filter = filter_var($lastName, FILTER_SANITIZE_STRING);
$email_filter = filter_var($email, FILTER_SANITIZE_STRING);
$password_filter = filter_var($password_get, FILTER_SANITIZE_STRING);
$role_filter = filter_var($role, FILTER_SANITIZE_STRING);

$hashedPassword = password_hash($password_get, PASSWORD_DEFAULT);

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Failed to connect: " . $conn->connect_error);
}

$sql = "INSERT INTO Users (firstname, lastname, email, pwd, _role) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error in the SQL query: " . $conn->error);
}

if (!$stmt->bind_param("sssss", $firstName_filter, $lastName_filter, $email_filter, $hashedPassword, $role_filter)) {
    die("Error binding parameters: " . $stmt->error);
}

if ($stmt->execute()) {
    echo "<script>alert('User added successfully')</script>";
    header("Refresh:1, url=../pages/users.html");
} else {
    echo "<script>alert('Error adding user: " . $stmt->error . "')</script>";
    header("Refresh:1, url=../pages/new_user.html");
}

$stmt->close();
$conn->close();
?>
