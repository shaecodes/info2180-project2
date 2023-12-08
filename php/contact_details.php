<?php
session_start();

$contactId = isset($_GET['id']) ? $_GET['id'] : null;
$contactDetails = fetchcontactDetails($contactId);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Details</title>
</head>
<header>
    <?php include('header.php');?>
    </header>
<body>
    <div class = "">
        <img src = "" alt= "person icon">
        <h2><?php echo $contactDetails['title'] . ' ' . $contactDetails['firstname'] . ' ' . $contactDetails['lastname']; ?></h2>
        <p> Created on <?php echo (new DateTime($contactDetails['created_at']))->format('F j, Y'); ?></p>
        <p> Updated on <?php echo (new DateTime($contactDetails['updated_at']))->format('F j, Y'); ?></p>
    </div>
    

    <div class = "basic_info">
        <p> Email </p>
        <p><?php echo $contactDetails['email']; ?></p>

        <p> Telephone </p>
        <p><?php echo $contactDetails['telephone']; ?></p>

        <p> Company </p>
        <p><?php echo $contactDetails['company']; ?></p>

        <p> Assigned To </p>
        <p><?php echo $contactDetails['assigned_firstname'] . ' ' . $contactDetails['assigned_lastname']; ?></p>

    </div>
    <div class = "notes">
        <img src = "" alt = "notes icon">
    </div>
</body>
</html>

<?php

function connectToDatabase()
{
    $servername = "localhost";
    $username = "proj2_user";
    $password = "groupbest1234";
    $dbname = "dolphin_crm";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

function fetchcontactDetails($contactId) {
    $query = "
        SELECT contacts.*, assignedUser.firstname AS assigned_firstname, assignedUser.lastname AS assigned_lastname
        FROM Contacts
        LEFT JOIN Users AS assignedUser ON contacts.assigned_to = assignedUser.id
        WHERE contacts.id = ?
    ";

    $conn = connectToDatabase();
    $statement = $conn->prepare($query);

    if (!$statement) {
        die("Error in SQL query: " . $conn->error);
    }

    $statement->bind_param('i', $contactId);

    if (!$statement) {
        die("Error binding parameters: " . $conn->error);
    }

    $statement->execute();
    $result = $statement->get_result();
    $contactDetails = $result->fetch_assoc();

    return $contactDetails;
}


?>
