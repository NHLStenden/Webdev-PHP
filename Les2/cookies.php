<?php

$expires_time = 5; //5 seconds

$count = 0;
if(!isset($_COOKIE["count"])) {
    $_COOKIE["count"] = 0;
} else {
    $count = (int)$_COOKIE["count"];
}

$count++;

if($count % 5 == 0) {
    setcookie("count", $count, time() - 3600*24);
} else {
    setcookie("count", $count, time() + $expires_time);
}


?>

<?= $count ?>

<hr>

<a href="cookies.php">Inc</a>
