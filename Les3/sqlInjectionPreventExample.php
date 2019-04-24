<?php
/**
 * Created by PhpStorm.
 * User: joris
 * Date: 2019-04-23
 * Time: 14:21
 */


function validate($str) {
    return trim(htmlspecialchars($str));
}


if(isset($_GET["searchDescription"]) && $_GET["searchDescription"])
{
    $searchDescription = validate($_GET["searchDescription"]);

    $host = "localhost";
    $databaseName = "TodoDb";
    $dns = "mysql:host=$host;dbname=$databaseName";
    $username = "root";     //for mamp
    $password = "root";     //for mamp

    //default username, password for wamp is root, empty/blank

    try {
        $conn = new PDO($dns, $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //Add the following string to the querystring searchDescription:    "' OR 1 = 1; --"
        //Or something like this: "'; DROP TABLE Todos; --"
        $sql = "SELECT TodoId, Description, Done FROM Todos WHERE Description = :searchDescription";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue("searchDescription", $searchDescription, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

        foreach ($stmt->fetchAll() as $row) {
            echo $row["Description"]
                ."&nbsp;"
                .($row["Done"] ? "completed" : "")
                ."<br/>";
        }

    } catch (PDOException $ex) {
        echo "Connection failed:  $ex";
    }
} else {
    echo "invalid input!";
}
?>

<form method="get">
    <input name="searchDescription" type="text">
    <button type="submit">Search</button>
</form>
