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
            $_SESSION['user_id'] = $data['id'];
            $_SESSION['first_name'] = $data['firstname'];
            $_SESSION['last_name'] = $data['lastname'];
            $_SESSION['full_name'] = $_SESSION['first_name'] . ' ' . $_SESSION['last_name'];
            $_SESSION['user_role'] = $data['_role'];

                if ($_SESSION['user_role'] === "Admin"){
                    echo json_encode("Login Successfully");
                    /*echo '<style>.popup {
                        display: block;
                        position: fixed;
                        top: 50%;
                        left: 50%;
                        transform: translate(-50%, -50%);
                        padding: 20px;
                        background-color: black;
                        background: #fff;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                        z-index: 9999;
                    }</style><div id="login-success-popup" class="popup">
                    <?php
                    // Include the PHP file to send echo to HTML
                    include "log.php";
                    ?>
                  <p id="text">nm</p>
                </div>';*/
                    //echo "<h1>Login Successfully</h1>";
                  header("Refresh:1, url=../pages/login.html");

                // should navigate to the dashboard page once created
                } else {
                    echo "<h1>Restricted Access. Go Back</h1>";
                    header("Refresh:1, url=../pages/login.html");
                } 
        } else {
            echo "<h1>Invalid Password</h1>";
            header("Refresh:1, url=../pages/login.html");
        }
    } else {
        echo "<h1>Invalid Email</h1>";
        header("Refresh:1, url=../pages/login.html");
    }
    
    //$stmt->close();
    //$conn->close();
}
?>
