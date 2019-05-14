<?php

session_start();

$logged_in = false;

if(isset($_POST["logout"])) {
    if(isset($_SESSION["user_id"])) {
        unset($_SESSION["user_id"]);
        echo "logged out with session";
    }
} else {
    $user_id = $_SESSION["user_id"] ?? "";
    if(!empty($user_id)) {
        echo "Logged in Session with user_id: $user_id";
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