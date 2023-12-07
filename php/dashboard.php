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

function fetchContacts()
{
    $conn = connectToDatabase();

    $contacts = [];

    // Fetch data from the "Contacts" table
    $sql = "SELECT title, firstname, lastname, email, company, _type FROM Contacts";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            $contacts[] = $row;
        }
    }

    $conn->close();

    return $contacts;
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dolphin CRM Dashboard</title>

    <script>
        function addContact() {
            // Redirect to contact.html
            window.location.href = '../pages/contacts.html';
        }

        const contacts = [
            { title: 'Mr', fullName: 'John Doe', email: 'john.doe@example.com', company: 'ABC Inc.', type: 'Sales Lead' },
            // List for Contacts
        ];


    </script>
</head>

<body>
    <header>
    <?php include('header.php');?>
        <h1>Dashboard</h1>
        <button class="add-contact-btn" onclick="addContact()">&#43; Add Contact</button>
    </header>


    <div id="contacts" action="">
        <table>
            <thead>
                <th>Name</th>
                <th>Email</th>
                <th>Company</th>
                <th>Type</th>
            </thead>
            <tbody>
                <?php $contacts = fetchContacts(); ?>
                <?php foreach ($contacts as $contact): ?>
                    <tr>
                        <td>
                            <?php echo $contact['title'] . ' ' . $contact['firstname'] . ' ' . $contact['lastname']; ?>
                        </td>
                        <td>
                            <?php echo $contact['email']; ?>
                        </td>
                        <td>
                            <?php echo $contact['company']; ?>
                        </td>
                        <td>
                            <?php echo $contact['_type']; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>


</body>

</html>