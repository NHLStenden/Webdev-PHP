<?php
    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    if($username === "user" && $password === "session") {
        session_start();
        $_SESSION["user_id"] = uniqid();
        header('Location: logout.php');
    }
    if($username === "user" && $password == "cookie") {
        setcookie("user_id", uniqid());
        header('Location: logout.php');
    }
?>

<form method="post">
    <input type="text" name="username">
    <input type="password" name="password">
    <button type="submit">Login</button>
</form>
