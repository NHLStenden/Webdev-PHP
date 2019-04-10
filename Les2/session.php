<?php

session_start();

//read-session var count or initialize to 0
$count = (int)($_SESSION['count'] ?? 0);

$count++;


//write-session var count
$_SESSION['count'] = $count;

if($count % 5 == 0) {
    unset($_SESSION['count']);

    //to destroy all session vars use:
    //session_destroy();
}

?>

<? echo $count ?>
<hr/>

<form action="session.php">
    <button type="submit">Request page again</button>
</form>



