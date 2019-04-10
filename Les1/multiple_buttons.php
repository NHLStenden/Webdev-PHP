<?php
    if(isset($_POST["add"])) {
        echo "Add";
    }
    if(isset($_POST["delete"])) {
        echo "Delete";
    }

    if(isset($_POST["operation"])) {
        $operation = $_POST["operation"];
        switch ($operation) {
            case "add": echo "Add"; break;
            case "delete": echo "Delete"; break;
        }
    }
?>


<form method="post">
    <button name="add">Add</button>
    <button name="delete">Delete</button>
</form>

<form method="post">
    <input type="submit" name="add" value="Add">
    <input type="submit" name="delete" value="Delete">
</form>

<!-- multiple forms -->
<form method="post">
    <input type="hidden" name="operation" value="add">
    <button type="submit">Add</button>
</form>


<form method="post">
    <input type="hidden" name="operation" value="delete">
    <button type="submit">Delete</button>
</form>

