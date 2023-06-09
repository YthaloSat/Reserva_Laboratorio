<?php
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['theme'])) {
        $theme = $_POST['theme'];
        $_SESSION['theme'] = $theme;
        $icon = ($theme === 'dark') ? 'moon-stars-fill' : 'sun-fill';
        $_SESSION['icon'] = $icon;
    }
?>

