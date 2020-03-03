<?php
//insertData.php
$host = "localhost";
$databaseName = "TodoDb";
$connectionString = "mysql:host=$host;dbname=$databaseName";
$username = "student";     //root is default in most cases
$password = "student";     //root is default in most cases

$description = $_POST["description"] ?? false;

if($description !== false) {
    try {
        $conn = new PDO($connectionString, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //don't do this!!! SQL INJECTION!!!!!!!!!
        $sql = "INSERT INTO Todos (Description) VALUES ('$description')";
        //don't do this!!! SQL INJECTION!!!!!!!!!
        $conn->exec($sql);

        echo "Inserted Record";
    } catch (PDOException $ex) {
        echo "PDOException:  $ex";
    } finally {
        if(isset($conn)) {
            $conn = null;
        }
    }
}
?>

<form method="post">
    <input name="description" type="text">
    <button name="AddTodo" type="submit">Add Todo</button>
</form>
