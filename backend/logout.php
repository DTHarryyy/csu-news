<?php
    $btn = isset($_POST['logout']) ? $_POST['logout'] : null;

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['logout'])){
            
            session_unset();
            session_destroy();
            
            header("Location: login.php");
        }
    }
?>