<?php
$host = "localhost";
$username = "proj2_user";
$password = "groupbest1234";
$dbname = "dolphin_crm";
$options = '<option value="">-k-</option>';

$title = $_POST['title'] ?? '';
$fname = $_POST['fname'] ?? '';
$lname = $_POST['lname'] ?? '';
$email = $_POST['email'] ?? '';
$telephone = $_POST['t_phone'] ?? '';
$company = $_POST['company'] ?? '';
$type = $_POST['type'] ?? '';
$assign = $_POST['assign_user'] ?? '';


$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

$sql = "SELECT * FROM Users";
$result = $conn->query($sql);
$rows = $result->fetchAll(PDO::FETCH_ASSOC);


foreach($rows as $row ) {
    $options .= '<option value="">'. $row['firstname']. " ". $row['lastname']. '</option>';
}

echo $options

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "INSERT INTO Contacts (title, firstname, lastname, email, telephone, company, type, assigned_to, created_by, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, 1,2,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
    $push = $conn->prepare($sql);
    $push->execute();
}
?>
