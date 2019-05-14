<?php
    class MyUser
    {
        public $name;
        public $password;
    }


    session_start();


    if(!isset($_SESSION['user'])) {
        $user = new MyUser();
        $user->name = "Joris";
        $user->password = "Geheim";

        $_SESSION["user"] = $user;

        echo "Session Created, refresh/reload page!";
    } else {
        $user = $_SESSION["user"];

        echo "Username: " .$user->name;
        echo "Password: " .$user->password;
    }
?>

