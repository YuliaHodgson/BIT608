<!DOCTYPE HTML>
<html>
<head>
    <title>Login for Admin</title>
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

session_start(); 
include "config.php";

// Функция для определения, является ли пользователь администратором
function isAdmin($user_id) {
    // Список ID администраторов
    $admins = [1, 2, 3]; // ID администраторов
    return in_array($user_id, $admins);
}

// Функция для входа пользователя
function loginUser($email, $password) {
    global $db_connection; // Используем глобальное соединение с БД

    $query = $db_connection->prepare("SELECT id, password FROM customers WHERE email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['userid'] = $user['id'];
            $_SESSION['username'] = $email;
            header('Location: client_page.php');
            exit;
        } else {
            echo "Неверный пароль!";
        }
    } else {
        echo "Пользователь не найден!";
    }
}

// Функция для выхода пользователя
function logoutUser() {
    // Очищаем все данные сессии
    $_SESSION = array();

    // Если используются cookie для сессии, удаляем их
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Наконец, уничтожаем сессию
    session_destroy();

    // Перенаправляем на страницу входа без параметра action
    header('Location: login.php');
    exit;
}

// Проверка, не является ли пользователь уже вошедшим в систему
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    header('Location: ' . (isAdmin($_SESSION['userid']) ? 'admin_page.php' : 'client_page.php'));
    exit;
}

// Обработка запроса на вход
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email']) && isset($_POST['password'])) {
    $db_connection = new mysqli(DBHOST, DBUSER, DBPASSWORD, 'motueka');
    if ($db_connection->connect_error) {
        die("Ошибка подключения к базе данных: " . $db_connection->connect_error);
    }

    loginUser($_POST['email'], $_POST['password']); // Функция входа

    $db_connection->close();
}

// Обработка запроса на выход
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    logoutUser(); // Функция выхода
}
?>

<h1>Login for Admin</h1>
<h2>
    <a href="index.php" class="button-style">Return to main page</a>
</h2>
<form action="login.php" method="post" onsubmit="return validateForm();">
    <table border="1">

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
        <!-- need to change CSS -->
        <input type="submit" value="Login">
        
        <a href="login.php?action=logout">Logout</a>
    </h2>

</form>

</body>
</html>
