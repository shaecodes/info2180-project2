<?php
//
$host = "localhost";
$username = "proj2_user";
$password = "groupbest1234";
$dbname = "dolphin_crm";
$options = '<option value="">---</option>';

$title = $_POST['title'] ?? '';
$fname = $_POST['fname'] ?? '';
$lname = $_POST['lname'] ?? '';
$email = $_POST['email'] ?? '';
$telephone = $_POST['t_phone'] ?? '';
$company = $_POST['company'] ?? '';
$type = $_POST['type'] ?? '';
echo $title;
$assign = $_POST['assign_user'] ?? '';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

$sql = "SELECT * FROM Users";
$result = $conn->query($sql);
$rows = $result->fetchAll(PDO::FETCH_ASSOC);

foreach($rows as $row ) {
    $options .= '<option value="">'. $row['firstname']. " ". $row['lastname']. '</option>';
}

echo $options;

/*$sql1 = "INSERT INTO Contacts (title, firstname, lastname, email, telephone, company, type, assigned_to, created_by, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, 1,2,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
$push = $conn->prepare($sql1);
$push->execute();*///

function submit(){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        global $conn, $title, $fname, $lname, $email, $telephone, $company, $type, $host, $dbname, $username, $password;
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $sql1 = "INSERT INTO Contacts (title,firstname, lastname, email, telephone, company,types, assigned_to) VALUES ('$title', '$fname', '$lname', '$email', $telephone, '$company', '$type', 1)";
        if ($conn->query($sql1) === TRUE) {
            echo "Record inserted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        //$push = $conn->prepare($sql1);
        $push->execute();
        echo "Yes";
    }else{
        echo "No";
    }
}

submit();

?>
