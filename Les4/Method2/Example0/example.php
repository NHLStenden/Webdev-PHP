<?php

require_once ($_SERVER['DOCUMENT_ROOT'] .'/vendor/autoload.php');

$loader = new \Twig\Loader\FilesystemLoader('Templates');
$twig = new \Twig\Environment($loader);

$template = $twig->load("example.twig");

//echo $template->render(['todos'=> $todos, 'rowToEdit' => $rowToEdit]);

echo $template->render([
    'navigation' => [
        ['href'=>"index.html", "caption"=>"home"],
        ['href'=>"contact.html", "caption"=>"contact"]
    ],
    "a_variable" => "<script>alert('test');</script>"
]);
