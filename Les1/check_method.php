<!-- check_method -->
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST["name"])) {
        var_dump($_POST["name"]);
    }
    if(isset($_POST["email"])) {
        var_dump(isset($_POST["email"]));
    }
} else { // else if ($_SERVER['REQUEST_METHOD'] === 'GET')
?>
    <form method="post">
        Name: <input type="text" name="name"><br>
        E-mail: <input type="text" name="email"><br>
        <input type="submit">
    </form>
<?php
}
?>

