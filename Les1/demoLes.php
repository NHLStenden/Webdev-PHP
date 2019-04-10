<!-- empty_action.php -->
<?php
//echo $_POST["name"];

$name = $_POST["name"] ?? "Leeg";
//print $name;

echo $_GET['test'];

?>
<form method="post">
    Name: <input type="text" name="name"><br>
    E-mail: <input type="text" name="email"><br>
    <input type="submit">
</form>
