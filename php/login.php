<?php
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Database connection here
    $conn = new mysqli("localhost", "root", "", "dolphin_crm");
    if ($conn->connect_error){
        die("Failed to connect: " . $conn->connect_error);
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt_result = $stmt->get_result();

        if ($stmt_result->num_rows > 0){
            $data = $stmt_result->fetch_assoc();
            if ($data['password'] === $password) {
                if ($data['role'] === "Admin"){
                    echo "<h2>Login Successfully</h2>";
                } else{
                    echo "<h2>Restricted Access. Go Back</h2>";
                } 
            } else {
                echo "<h2>Invalid Email or Password</h2>";
            }
        } else {
            echo "<h2>Invalid Email or Password</h2>";
        }
        $stmt->close();
        $conn->close();
    }
?>
