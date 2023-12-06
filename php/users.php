<?php
$host = 'localhost';
$username = 'proj2_user';
$password = 'groupbest1234';
$dbname = 'dolphin_crm';
$name = "";

$link = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
$search = $link->query("SELECT * FROM Users u join Contacts c on u.id = c.id");
$users = $search->fetchAll(PDO::FETCH_ASSOC);
?>

<table>
    <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Role</th>
            <th scope="col">Created</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <?php $name.= $user['title'].= " ";
            $name.= $user['firstname'].= " ";
            $name.= $user['lastname'];?>
            <tr>
                <td><?= $name ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= $user['role'] ?></td>
                <td><?= $user['created_at'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>