<!DOCTYPE HTML>
<html>
<head>
    <title>Admin Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style/style.css" title="style" />
</head>
<body>

<?php
session_start();

// Простая проверка на администратора
function isAdmin($user_id) {
    $admins = [1, 2, 3]; // Здесь перечисляются ID администраторов
    return in_array($user_id, $admins);
}

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isAdmin($_SESSION['userid'])) {
    header('Location: login.php');
    exit;
}
?>

<h1>Welcome, Admin <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
<p>This is the admin dashboard.</p>

<nav>
    <ul>
        <li><a href="browsebookings.php">Browse Bookings</a></li>
        <li><a href="viewsinglebooking.php">View Single Booking</a></li>
        <li><a href="editbooking.php">Edit Booking</a></li>
        <li><a href="deletebooking.php">Delete Booking</a></li>
    </ul>
</nav>

</body>
</html>
