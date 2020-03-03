<?php
//queryData.php
$host = "localhost";
$databaseName = "TodoDb";
$connectionString = "mysql:host=$host;dbname=$databaseName";
$username = "student";     //root is default in most cases
$password = "student";     //root is default in most cases

$conn = null;
try {
    $conn = new PDO($connectionString, $username, $password);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT TodoId, Description, Done FROM Todos";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $rows = $stmt->fetchAll();
//    var_dump($rows);
    foreach ($rows as $row) {
        echo $row["Description"]
            ."&nbsp; --- "
            .($row["Done"] ? "completed" : "not completed") ."<br/>";
    }
} catch (PDOException $ex) {
    echo "PDOException:  $ex";
} finally {
    $conn = null;
}
?>