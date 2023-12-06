<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New User</title>
</head>
<body>
    <header>
        <img src="#" alt="">
        <p>Dolphin CRM</p>
    </header>
    <?php 
        include('header.php');
    ?>
    <div class="users">
        <form action="../php/new_user.php" method="post" class = "new_user">
            <label for="firstName">First Name</label>
            <input type="text" id="firstName" name="firstName">

            <label for="lastName">Last Name</label>
            <input type="text" id="lastName" name="lastName">

            <label for="email">Email</label>
            <input type="email" id="email" name="email">

            <label for="password">Password</label>
            <input type="password" id="password" name="password">

            <label for="role">Role</label>
            <select id="role" name="role">
                <option value="Member">Member</option>
                <option value="Admin">Admin</option>
            </select>
            <button type="submit">Save</button>
        </form>
    </div>
</body>
</html>
