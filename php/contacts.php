<?php
$host = "localhost";
$username = "proj2_user";
$password = "groupbest1234";
$dbname = "dolphin_crm";
$options = '<option value="">Select a User</option>';


$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

$sql = "SELECT * FROM Users";
$result = $conn->query($sql);
$rows = $result->fetchAll(PDO::FETCH_ASSOC);


foreach($rows as $row ) {
    $options .= '<option value="">'. $row['firstname']. " ". $row['lastname']. '</option>';
}

echo $options
?>
