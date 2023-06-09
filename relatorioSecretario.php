<?php
    session_start();

    include_once('database.php');

    if(!isset($_SESSION['email']) || !isset($_SESSION['senha']) || $_SESSION['T_userType_id_userType'] !== "1") {
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

    date_default_timezone_set('America/Sao_Paulo');
    $currentDate = date('Y-m-d H:i:s');

    $sql = "SELECT t_reserva.*, t_laboratorio.nome_laboratorio AS nome_laboratorio, t_usuario.nome_usuario AS nome_usuario FROM t_reserva
            INNER JOIN t_usuario ON t_reserva.t_usuario_cpf = t_usuario.cpf
            INNER JOIN t_laboratorio ON t_reserva.t_laboratorio_id_laboratorio = t_laboratorio.id_laboratorio
            WHERE t_reserva.horario_de_entrega > '$currentDate'
            ORDER BY t_reserva.horario_de_entrega ASC";
    $result = mysqli_query($conexao, $sql);

    function atualizarHorarioEntrega($reservaId) {
        global $conexao;

        date_default_timezone_set('America/Sao_Paulo');
        $horarioEntrega = date('Y-m-d H:i:s');
        $sql = "UPDATE t_reserva SET horario_de_entrega = '$horarioEntrega' WHERE idT_reserva = '$reservaId' AND horario_de_reserva < '$horarioEntrega';";
        mysqli_query($conexao, $sql);
    }

    if (isset($_POST['recebido'])) {
        $reservaId = intval($_POST['reservaId']);
        atualizarHorarioEntrega($reservaId);
        header('Location: relatorioSecretario.php');
        exit();
    }

    if (isset($_POST['excluir'])) {
        $reservaId = intval($_POST['reservaId']);
        $sql = "DELETE FROM t_reserva WHERE idT_reserva = '$reservaId'";
        mysqli_query($conexao, $sql);

        if ($result) {
            header('Location: relatorioSecretario.php');
            exit();
        } else {
            $messageClass = "alert-danger";
            $message = "Ocorreu um erro ao excluir a reserva. Tente novamente.";
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="<?php echo $theme; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema do Secretário</title>
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
        <a class="navbar-brand" href="#">Secretário</a>
        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-collapse collapse" id="navbarsExample07">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="sistemaSecretario.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="relatorioSecretario.php">Relatório</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="historicoReservaSecretario.php">Histórico</a>
                </li>
                <li class="nav-item ml-auto">
                    <a class="nav-link" href="sair.php">Sair</a>
                </li>
            </ul>
        </div>
        </div>
    </nav>

    <div class="container my-5">
        <h1 class="h2">Relatório de Reservas</h1> <hr>
        <div class="table-responsive small">
            <?php if (mysqli_num_rows($result) > 0) : ?>
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th scope="col">Laboratório</th>
                        <th scope="col">Usuário</th>
                        <th scope="col">Reserva</th>
                        <th scope="col">Entrega</th>
                        <th scope="col">Status</th>
                        <th scope="col">Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                            <?php date_default_timezone_set('America/Sao_Paulo'); ?>
                            <tr>
                                <td><?php echo $row['nome_laboratorio']; ?></td>
                                <td><?php echo $row['nome_usuario']; ?></td>
                                <td><?php echo $row['horario_de_reserva']; ?></td>
                                <td><?php echo $row['horario_de_entrega']; ?></td>
                                <?php if ($row['horario_de_reserva'] > date('Y-m-d H:i:s')) : ?>
                                    <td><button type="button" class="btn btn-warning me-2" disabled>Pendente</button></td>
                                    <td>
                                        <form action="relatorioSecretario.php" method="POST">
                                            <input type="hidden" name="reservaId" value="<?php echo $row['idT_reserva']; ?>">
                                            <button type="submit" name="excluir" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja cancelar esta reserva?')">Cancelar</button>
                                        </form>
                                    </td>
                                <?php else : ?>
                                    <td><button type="button" class="btn btn-info me-2" disabled>Aberto</button></td>
                                    <td>
                                        <form action="relatorioSecretario.php" method="POST">
                                            <input type="hidden" name="reservaId" value="<?php echo $row['idT_reserva']; ?>">
                                            <button type="submit" name="recebido" class="btn btn-primary">Receber</button>
                                        </form>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th scope="col">Laboratório</th>
                        <th scope="col">Usuário</th>
                        <th scope="col">Reserva</th>
                        <th scope="col">Entrega</th>
                        <th scope="col">Status</th>
                        <th scope="col">Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                        </tr>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>