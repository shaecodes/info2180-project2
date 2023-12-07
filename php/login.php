<?php
session_start(); // Start the session

$host = 'localhost';
$username = 'proj2_user';
$password = 'groupbest1234';
$dbname = 'dolphin_crm';

$email = $_POST["email"];
$password_get = $_POST["password"];

$email_filter = filter_var($email, FILTER_SANITIZE_STRING);
$password_filter = filter_var($password_get, FILTER_SANITIZE_STRING);

// Database connection here
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error){
    die("Failed to connect: " . $conn->connect_error);
} else {
    $stmt = $conn->prepare("SELECT * FROM Users WHERE email = ?");
    $stmt->bind_param("s", $email_filter);
    $stmt->execute();
    $stmt_result = $stmt->get_result();

    if ($stmt_result->num_rows > 0){
        $data = $stmt_result->fetch_assoc();
        
        // Check if the entered password matches the hashed password in the database
        if (password_verify($password_filter, $data['pwd'])) {
            // Set session variables
            $_SESSION['user_id'] = $data['user_id'];
            $_SESSION['user_email'] = $data['email'];
            $_SESSION['user_role'] = $data['_role'];

            if ($_SESSION['user_role'] === "Admin"){
                echo "<script>alert('Login Successfully')</script>";
                header("Refresh:1, url=../pages/users.html");

                // should navigate to the dashboard page once created
            } else {
                echo "<script>alert('Restricted Access. Go Back')</script>";
                header("Refresh:1, url=../pages/login.html");
            } 
        } else {
            echo "<script>alert('Invalid Password')</script>";
            header("Refresh:1, url=../pages/login.html");
        }
    } else {
        echo "<script>alert('Invalid Email')</script>";
        header("Refresh:1, url=../pages/login.html");
    }
    
    $stmt->close();
    $conn->close();
}
?>
