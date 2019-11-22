<?php

include "TodoDb.php";

require_once ($_SERVER['DOCUMENT_ROOT'] .'/vendor/autoload.php');

$loader = new \Twig\Loader\FilesystemLoader('Templates');
$twig = new \Twig\Environment($loader);

$template = $twig->load('todo.twig');

echo $template->render();