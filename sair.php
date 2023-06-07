<?php
    session_start();

    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    unset($_SESSION['T_userType_id_userType']);
    session_regenerate_id(true); // Regenera o ID da sessão
    header("Location: login.php");
?>