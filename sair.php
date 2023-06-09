<?php
    session_start();

    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    unset($_SESSION['T_userType_id_userType']);
    session_regenerate_id(true);
    header("Location: login.php");
?>