<?php
    require'connection.php';
    session_start();
    unset($_SESSION["id"]);
    unset($_SESSION["name"]);
    header("Location:front.php");
    session_end();
?>