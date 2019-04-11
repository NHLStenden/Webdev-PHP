<?php

session_start();


$logged_in = false;

if(isset($_POST["logout"])) {
    if(isset($_SESSION["user_id"])) {
        unset($_SESSION["user_id"]);
        echo "logged out with session";
    }
    if(isset($_COOKIE["user_id"])) {
        setcookie("user_id", 0, time()-60);
        echo "logged out with cookie";
    }
} else {
    $user_id = $_SESSION["user_id"] ?? "";
    if(!empty($user_id)) {
        echo "Logged in Session with user_id: $user_id";
        $logged_in = true;
    }

    $user_id = $_COOKIE["user_id"] ?? "";
    if(!empty($user_id)) {
        echo "Logged in Cookie with user_id: $user_id";
        $logged_in = true;
    }

    if(!$logged_in) {
        echo "Not logged in";
    }
}
?>

<? if($logged_in) { ?>
<form method="post">
    <button name="logout" type="submit">Logout</button>
</form>
<? } else { ?>
<form action="login.php">
    <button type="submit">Login</button>
</form>
<? } ?>