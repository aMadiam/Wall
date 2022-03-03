<?php 
    session_start();
?>
<html>
<head>
    <title>Authentication</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php 
        if (isset($_SESSION['errors'])) {
            foreach ($_SESSION['errors'] as $error) {
                echo "<p class='error'>{$error} </p>";
            }
            unset($_SESSION['errors']);
        }
        if (isset($_SESSION['success_message'])) {
            echo "<p class='success'>{$_SESSION['success_message']} </p>";
            unset($_SESSION['success_message']);
        }
    ?>
    <!-- <p class='success'> User successfuly created! </p> -->
    <form action='process.php' method='post' class='container'>
        <h2>Register</h2>
        <input type='hidden' name='action' value='register'>
        <p>First name: </p><input type='text' name='first_name' placeholder="Firstname...">
        <p>Last name: </p><input type='text' name='last_name' placeholder="Lastname...">
        <p>Email address: </p><input type='text' name='email' placeholder="Email...">
        <p>Contact number: </p><input type='text' name='contact' placeholder="Phone number...">
        <p>Password: </p><input type='password' name='password' placeholder="Password...">
        <p>Confirm Password: </p><input type='password' name='confirm_password'><br>
        <input type='submit' value='REGISTER' class="register">
    </form>
    <form action='process.php' method='post' class="container-2">
    <h2>Login</h2>
    <input type='hidden' name='action' value='login'>
        <p>Email address: </p><input type='text' name='email' placeholder="Email..." value="anthony@yahoo.com">
        <p>Password: </p><input type='password' name='password' placeholder="Phone number..." value="admin123"><br>
        <input type='submit' value='LOGIN' class="login">
    </form>
</body>