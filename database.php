<?php
    if (!isset($_SESSION['theme'])) {
        $_SESSION['theme'] = 'light';
    }

    $dbHost = 'reservalaboratorio.c4jjygdniibq.us-east-2.rds.amazonaws.com';
    $dbUsername = 'admin';
    $dbPassword = 'adminadmin';
    $dbName = 'reservaLaboratorio';

    $conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
?>
