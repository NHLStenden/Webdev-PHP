<?php
//todoExample.php
$host = "localhost";
$databaseName = "TodoDb";
$connectionString = "mysql:host=$host;dbname=$databaseName";
$username = "student";     //root is default in most cases
$password = "student";     //root is default in most cases

$conn = null;
try
{
    $conn = new PDO($connectionString, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT TodoId, Description, Done FROM Todos ORDER BY TodoId";

    $stmtSelect = $conn->prepare($sql);
    $stmtSelect->execute();

    $result = $stmtSelect->setFetchMode();

    $rows = $stmtSelect->fetchAll();

    $totalNumRecords = $stmtSelect->rowCount();

    //count with SQL
    $stmtCount = $conn->prepare("SELECT COUNT(1) FROM Todos WHERE Done = TRUE");
    $stmtCount->execute();
    $completedRecords = $stmtCount->fetchColumn();
} catch (PDOException $ex) {
    echo "Connection failed:  $ex";
    die();
} finally {
    if($conn != null) {
        $conn = null;
    }
}
?>

<h1>Num of Todos method1 (total): <?= $totalNumRecords ?></h1>
<h1>Num of Todos method2 (completed): <?= $completedRecords ?></h1>

<h2><a href="create.php">Click to create a new Todo Item</a></h2>

<hr>
<ul>
    <? foreach ($rows as $row) { ?>
        <li>
            <?= $row["Description"] ?> -- <?= $row["Done"] ?>
            <form method="post" action="delete.php">
                <input type="hidden" name="todoId" value="<?= $row["TodoId"] ?>">
                <button type="submit">Delete</button>
            </form>
            <form method="post" action="edit.php">
                <input type="hidden" name="todoId" value="<?= $row["TodoId"] ?>">
                <button type="submit">Edit</button>
            </form>
            <a href="edit.php?todoId=<?= $row['TodoId'] ?>">Edit</a> |
            <a href="delete.php?todoId=<?= $row['TodoId'] ?>">Delete</a>
            <hr>
        </li>

    <? } ?>
</ul>


