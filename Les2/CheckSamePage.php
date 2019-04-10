<?php
/**
 * Created by PhpStorm.
 * User: joris
 * Date: 2019-04-05
 * Time: 16:46
 */

echo $_SERVER['HTTP_REFERER'];
echo "<br/>";


$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")
    . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
echo $actual_link;
