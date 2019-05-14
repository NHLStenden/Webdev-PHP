<?php
/**
 * Created by PhpStorm.
 * User: joris
 * Date: 2019-05-04
 * Time: 13:09
 */

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-sm bg-light navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item <?= $_title === 'Page 1' ? 'active' : '' ?> ">
            <a class="nav-link" href="page1.php">Page 1</a>
        </li>
        <li class="nav-item <?= $_title === 'Page 2' ? 'active' : '' ?>">
            <a class="nav-link" href="page2.php">Page 2</a>
        </li>
    </ul>
</nav>

<div class="jumbotron text-center">
    <h1>Company Logo & Text</h1>
    <p><?= $_title ?></p>
</div>

<div class="container">

