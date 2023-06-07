<?php
session_start();

if (isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha'])) {
    include_once('database.php');

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM t_usuario WHERE email = '$email' AND senha = '$senha'";

    $result = $conexao->query($sql);

    if (mysqli_num_rows($result) < 1) {
        header('Location: login.php');
    } else {
        $row = mysqli_fetch_assoc($result);
        $tipoUsuario = $row['T_userType_id_userType'];

        $_SESSION['email'] = $email;
        $_SESSION['senha'] = $senha;
        $_SESSION['T_userType_id_userType'] = $tipoUsuario;

        session_regenerate_id(true);

        if ($tipoUsuario == "2") {
            header('Location: sistemaProfessor.php');
        } elseif ($tipoUsuario == "1") {
            header('Location: sistemaSecretario.php');
        } else {
            unset($_SESSION['email']);
            unset($_SESSION['senha']);
            unset($_SESSION['T_userType_id_userType']);
            session_regenerate_id(true);
            header('Location: login.php');
        }
    }
} else {
    header('Location: login.php');
}

?>
