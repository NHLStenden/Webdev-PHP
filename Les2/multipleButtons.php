<?php
    $operation = $_POST['operation'] ?? "";

    if($operation === "add") {
        echo "Add Button Clicked";
    } else if ($operation === "sub") {
        echo "Sub Button Clicked";
    }
?>

<form method="post">
    <button name="operation" value="add" type="submit">+</button>
    <button name="operation" value="sub" type="submit">-</button>
</form>
