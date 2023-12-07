<?php
session_start();
echo $_SESSION['full_name'];

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

function fetchContacts($filter = "")
{
    $conn = connectToDatabase();

    $contacts = [];

    // Fetch data from the "Contacts" table
    $sql = "SELECT title, firstname, lastname, email, company, _type FROM Contacts";
    $result = $conn->query($sql);

    if ($filter) {
        switch ($filter) {
            case 'Sales Leads':
                $sql .= " WHERE _type = 'Sales Lead'";
                break;
            case 'Support':
                $sql .= " WHERE _type = 'Support'";
                break;
            case 'Assigned to me':
                // Assuming you have a logged-in user, replace 'username' with the actual column name
                $sql .= " WHERE assigned_user = 'username'";
                break;
        }
    }

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

// Check if a filter is selected
$filter = isset($_GET['filter']) ? $_GET['filter'] : "";
$contacts = fetchContacts($filter);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dolphin CRM Dashboard</title>

    <script>
        function addContact() {
        // Navigate to the contact page (contacts.html)
        window.location.assign('../pages/contacts.html');
        }


        const contacts = [
            { title: 'Mr', fullName: 'John Doe', email: 'john.doe@example.com', company: 'ABC Inc.', type: 'Sales Lead' },
            // List for Contacts
        ];

        function applyFilter() {
            var filter = document.getElementById('contactFilter').value;
            var url = 'dashboard.php?filter=' + filter;
            window.location.href = url;
        }

    </script>
</head>

<body>
    <header>
    <?php include('header.php');?>
        <h1>Dashboard</h1>
    </header>

    <?php
    // Check if the session variable 'full_name' is set
    $fullName = isset($_SESSION['full_name']) ? $_SESSION['full_name'] : null;
    ?>

    <?php if ($fullName): ?>
        <button class="add-contact-btn" onclick="addContact()">&#43; Add Contact</button>
    <?php endif; ?>

    <div id="contacts" action="">
    <header>
            <form method="post" action="">
                <label for="filter">Filter:</label>
                <select id="filter" name="filter" onchange="this.form.submit()">
                    <option value="All Contacts">All Contacts</option>
                    <option value="Sales Leads">Sales Leads</option>
                    <option value="Support">Support</option>
                    <option value="Assigned to me">Assigned to me</option>
                </select>
            </form>
        </header>


        <table>
            <thead>
                <th>Name</th>
                <th>Email</th>
                <th>Company</th>
                <th>Type</th>
            </thead>
            <tbody>

                <?php $filter = isset($_POST['filter']) ? $_POST['filter'] : null; ?>
                <?php $contacts = fetchContacts($filter); ?>
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