<!-- empty_action.php -->
<?php
//echo $_POST["name"];

$name = $_POST["name"] ?? "Geen Naam";
$email = $_POST["email"] ?? "Geen Email";
//print $name;

?>
<form method="post">
    Name: <input type="text" name="name"><br>
    E-mail: <input type="text" name="email"><br>
    <input type="submit">
</form>

<?php
    print $name ."<br/>";
    print $email
?>
