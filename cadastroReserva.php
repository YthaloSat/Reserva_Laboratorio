<?php
    session_start();

    include_once('database.php');

    if(!isset($_SESSION['email']) || !isset($_SESSION['senha']) || $_SESSION['T_userType_id_userType'] !== "2") {
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        unset($_SESSION['T_userType_id_userType']);
        session_regenerate_id(true);
        header('Location: login.php');
        exit();
    }

    $theme = isset($_SESSION['theme']) ? $_SESSION['theme'] : 'light';
    $icon = isset($_SESSION['icon']) ? $_SESSION['icon'] : 'sun-fill';
    $themeClass = ($theme === 'dark') ? 'dark-theme' : 'light-theme';

    $tipo_usuario = $_SESSION['T_userType_id_userType'];
    $email = $_SESSION['email'];

    if (isset($_POST['submit'])) {
        include_once('database.php');
        
        $horario_atual = date('Y-m-d H:i:s');
        $id_laboratorio = intval($_POST['id_laboratorio']);
        $horario_de_reserva = date('Y-m-d H:i:s', strtotime($_POST['horario_de_reserva'])); 
        $horario_de_entrega = date('Y-m-d H:i:s', strtotime($_POST['horario_de_entrega']));
        
        if ($horario_de_reserva >= $horario_de_entrega) {
            $messageClass = "alert-danger";
            $message = "O horário de reserva deve ser posterior ao horário atual.";
        } else {
            $sql_check = "SELECT * FROM t_reserva WHERE t_laboratorio_id_laboratorio = '$id_laboratorio' AND
                  horario_de_reserva <= '$horario_de_entrega' AND horario_de_entrega >= '$horario_de_reserva'";
            $result_check = mysqli_query($conexao, $sql_check);

            if (mysqli_num_rows($result_check) > 0) {
                $messageClass = "alert-danger";
                $message = "O Laboratório selecionado já está Reservado no período solicitado.";
            } else {
                $sql = "SELECT cpf FROM t_usuario WHERE email = '$email'";
                $result = mysqli_query($conexao, $sql);
                $row = mysqli_fetch_assoc($result);
                $cpf = $row['cpf'];
    
                $sql_insert = "INSERT INTO t_reserva(horario_de_reserva, horario_de_entrega, t_laboratorio_id_laboratorio, t_usuario_cpf, t_usuario_t_userType_id_userType) 
                VALUES ('$horario_de_reserva', '$horario_de_entrega', '$id_laboratorio', '$cpf', '$tipo_usuario');";
    
                $result_insert = mysqli_query($conexao, $sql_insert);
    
                if ($result_insert) {
                    $message = "Reserva realizada com sucesso.";
                    $messageClass = "alert-success";
                } else {
                    $messageClass = "alert-danger";
                    $message = "Erro ao realizar a reserva.";
                }            
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="<?php echo $theme; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema do Professor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check2-circle" viewBox="0 0 16 16">
            <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"></path>
            <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"></path>
        </symbol>
        <symbol id="moon-stars-fill" viewBox="0 0 16 16">
            <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"></path>
            <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z"></path>
        </symbol>
        <symbol id="sun-fill" viewBox="0 0 16 16">
            <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"></path>
        </symbol>
    </svg>
    <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
        <button class="btn btn-primary py-2 dropdown-toggle d-flex align-items-center" id="bd-theme" type="button" onclick="toggleTheme()">
            <svg class="bi my-0 theme-icon-active" width="1em" height="1em"><use href="#<?php echo $icon; ?>"></use></svg>
            <span class="visually-hidden" id="bd-theme-text">Toggle theme to light</span>
        </button>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Eighth navbar example">
        <div class="container">
        <a class="navbar-brand" href="#">Professor</a>
        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-collapse collapse" id="navbarsExample07">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="sistemaProfessor.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="cadastroReserva.php">Cadastro</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="historicoReservaProfessor.php">Histórico</a>
                </li>
                <li class="nav-item ml-auto">
                    <a class="nav-link" href="sair.php">Sair</a>
                </li>
            </ul>
        </div>
        </div>
    </nav>

    <div class="container my-5">
        <?php if (isset($message)) : ?>
            <div id="message" class="alert <?php echo $messageClass; ?> mt-3">
            <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <div class="p-5 bg-white rounded shadow-lg">
            <?php date_default_timezone_set('America/Sao_Paulo'); ?>
            <form action="cadastroReserva.php" method="POST">
                <label class="font-500">Laboratório</label>
                <select name="id_laboratorio" class="form-control form-control-lg mb-3" required>
                    <option value="">Selecione o Laboratório</option>
                    <option value="1">Lab 01</option>
                    <option value="2">Lab 02</option>
                </select>
                <label class="font-500">Horário de Reserva</label>
                <input name="horario_de_reserva" class="form-control form-control-lg mb-3" type="datetime-local" required min="<?= date('Y-m-d\TH:i') ?>">
                <label class="font-500">Horário de Entrega</label>
                <input name="horario_de_entrega" class="form-control form-control-lg mb-3" type="datetime-local" required min="<?= date('Y-m-d\TH:i') ?>">
                <button class="btn btn-primary btn-lg w-100 shadow-lg" type="submit" name="submit">RESERVAR</button>
            </form>
        </div> 
    </div>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>