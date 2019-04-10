<?php
    if(isset($_POST["name"])) {
        var_dump($_POST["name"]);
    }
    if(!empty($_POST["email"])) {
        var_dump(isset($_POST["email"]));
    }
?>
<form method="post">
    Name: <input type="text" name="name"><br>
    E-mail: <input type="text" name="email"><br>
    <input type="submit">
</form>
