<?php
session_start();
// echo $_SESSION['user_id'];

$contactId = isset($_GET['id']) ? $_GET['id'] : null;
$contactDetails = fetchcontactDetails($contactId);
$current_user = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newNote = isset($_POST['new_note']) ? $_POST['new_note'] : '';

    if (!empty($newNote)) {
        addNoteToDatabase($contactId, $newNote, $current_user);
    }
}

function addNoteToDatabase($contactId, $newNote, $current_user) {
    $query = "INSERT INTO Notes (contact_id, comment, created_by, created_at) VALUES (?, ?, ?, CURRENT_TIMESTAMP)";
    $conn = connectToDatabase();
    $statement = $conn->prepare($query);

    if (!$statement) {
        die("Error in SQL query: " . $conn->error);
    }

    $statement->bind_param('iss', $contactId, $newNote, $current_user);

    if (!$statement) {
        die("Error binding parameters: " . $conn->error);
    }

    $statement->execute();

    $statement->close();
    $conn->close();
}


function fetchNotesForContact($contactId) {
    $query = "
        SELECT notes.*, users.firstname AS creator_firstname, users.lastname AS creator_lastname
        FROM Notes
        JOIN Users ON notes.created_by = users.id
        WHERE notes.contact_id = ?
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
    $notes = $result->fetch_all(MYSQLI_ASSOC);

    return $notes;
}

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

function formatDateTime($dateTimeString, $created_dateTimeString) {
    $dateTime = new DateTime($dateTimeString);
    $created_dateTime = new DateTime($created_dateTimeString);
    if ($dateTime->format('Y') < 0) {
        return "Updated on " . $created_dateTime->format('F j, Y');
    }
    return $dateTime->format('F j, Y');
}

function switchRoleText($currentRole) {
    switch ($currentRole) {
        case 'Sales Lead':
            return 'Support';
        case 'Support':
            return 'Sales Lead';
        default:
            return 'Unknown Role';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $contactDetails['title'] . ' ' . $contactDetails['firstname'] . ' ' . $contactDetails['lastname']; ?></title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="../css/contact_details.css">
    <script>
        function switchRole() {
            $.ajax({
                type: 'POST',
                url: 'switchRole.php',
                data: { contactId: <?php echo $contactDetails['id']; ?> },
                success: function(response) {
                    $('#switchRoleBtn').text(' Switch to ' + response);
                },
                error: function(error) {
                    console.error('Error switching role: ' + error.responseText);
                }
            });
        }
    </script>
</head>
<header>
    <?php include('header.php');?>
    </header>
<body>
    <div class = "">
        <img src = "" alt= "person icon">
        <h2><?php echo $contactDetails['title'] . ' ' . $contactDetails['firstname'] . ' ' . $contactDetails['lastname']; ?></h2>
        <button> Assign To Me</button>
        <button id="switchRoleBtn" onclick="switchRole()"> Switch to <?php echo switchRoleText($contactDetails['_type']); ?></button>
        <p> Created on <?php echo (new DateTime($contactDetails['created_at']))->format('F j, Y'); ?></p>
        <p> Updated on <?php echo formatDateTime($contactDetails['updated_at'], $contactDetails['created_at']); ?></p>
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

    <div class="notes">
    <img src="" alt="notes icon">
    <h2>Notes</h2>
    <?php
    $contactNotes = fetchNotesForContact($contactId);
    foreach ($contactNotes as $note) {
        echo '<div class="note">';
        echo '<p>' . $note['creator_firstname'] . ' ' . $note['creator_lastname'] . '</p>';
        echo '<p>' . $note['comment'] . '</p>';
        $createdTime = new DateTime($note['created_at']);
        echo '<p>' . $createdTime->format('F j, Y ga') . '</p>'; // 'F j, Y ga' format includes month, day, year, and time
        echo '</div>';
    }
    ?>


    <div class="note">
        <h3>Add a note about <?php echo $contactDetails['firstname'] ?></h3>
        <form action="contact_details.php?id=<?php echo $contactId; ?>" method="post">
            <label for="new_note">Enter a new note:</label>
            <textarea id="new_note" name="new_note" required></textarea><br>
            <button type="submit">Save Note</button>
        </form>
    </div> 
</div>
</body>
</html>