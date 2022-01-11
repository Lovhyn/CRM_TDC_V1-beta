<?php
    session_start();
    unset($_SESSION['nameUserConnected']);    
    unset($_SESSION['surnameUserConnected']);
    unset($_SESSION['rights']);
    unset($_SESSION['role']);
    session_destroy();
    header('Location: ../index.php');
?>