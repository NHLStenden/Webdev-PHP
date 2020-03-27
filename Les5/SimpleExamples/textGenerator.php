<?php

if (isset($_POST["action"])) {
    $action = $_POST["action"];

    // You don't "need" to use a switch statement and separate functions
    // This is just one way, but it makes your code look extremely clean and readable:

    switch ($action) {
        case "load": sendFood();
        break;
        case "calculateSum": calculateSum();
        break;
        case "sendPersonInfo": sendPersonInfo();
        break;
    }
}

function sendFood() {
    $food = $_POST["food"];
    // You need to echo what gets returned. For example: echo $food;
    // Or you can escape php in order to echo HTML,
    // and inside the HTML you can even include PHP variables again (useful if you echo a big block of HTML):
    ?>
    <b><i>My favorite food is <?= $food ?></i></b>
    <?php
}

function calculateSum() {
    $number1 = $_POST["number1"];
    $number2 = $_POST["number2"];
    $sum = $number1 + $number2;

    echo $sum;
}

function sendPersonInfo() {
    $jsonData["name"] = "Bob";
    $jsonData["age"] = "30";
    $jsonData["country"] = "Netherlands";
    // This converts your array into json format which can be sent and read
    echo json_encode($jsonData);
}