<?php
//method1/htmlHelpers.html

function displayHeader($title)
{
?>
    <html>
    <head>
        <title><?= $title ?></title>
    </head>
    <body>
<?
}
?>

<?
function displayFooter($title) {
?>
    <h1><?= $title ?></h1>

    </body>
    </html>
<?
}
?>


<?php

  displayHeader("My Title");


  displayFooter("End of Page")
?>


