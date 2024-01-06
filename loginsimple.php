<!DOCTYPE HTML>
<html>
<head>
    <title>Login for New Customer</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style/style.css" title="style" />
    <script type="text/javascript">
        function validateForm() {
            return true; 
        }
    </script>
</head>
<body>

<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include "config.php";
include "checksession.php"; // include the file for session management

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $db_connection = new mysqli(DBHOST, DBUSER, DBPASSWORD, 'motueka');

    if ($db_connection->connect_error) {
        die("Error adding new user: " . $db_connection->connect_error);}

    $firstname = $db_connection->real_escape_string($_POST['firstname']);
    $lastname = $db_connection->real_escape_string($_POST['lastname']);
    $email = $db_connection->real_escape_string($_POST['email']);
    $password = $db_connection->real_escape_string($_POST['password']);

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Request to add a new user
    $query = "INSERT INTO customers (firstname, lastname, email, password) VALUES ('$firstname', '$lastname', '$email', '$password_hash')";

    if ($db_connection->query($query) === TRUE) {
        echo "New user added successfully.";
    } else {
        echo "Error: " . $query . "<br>" . $db_connection->error;
    }

    // Closing a database connection
    $db_connection->close();}
?>

<h1>Welcome!!!</h1>
<h1>Login for New Customer</h1>
<h2>
    <a href="index.php" class="button-style">Return to main page</a>
</h2>
<form action="loginsimple.php" method="post" onsubmit="return validateForm();">
    <table border="1">
        <tr>
            <th>Detail</th>
            <th>Information</th>
        </tr>
        <tr>
            <td>First Name</td>
            <td><input type="text" id="firstname" name="firstname" required></td>
        </tr>
        <tr>
            <td>Last Name</td>
            <td><input type="text" id="lastname" name="lastname" required></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type="email" id="email" name="email" required></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type="password" id="password" name="password" required></td>
        </tr>
    </table>
    <h2>
        <!-- need to change CSS
    Sorry, I have not time! Merry X-mas and Happy New Year! -->
        <input type="submit" value="Register">
    </h2>

</form>

</body>
</html>
