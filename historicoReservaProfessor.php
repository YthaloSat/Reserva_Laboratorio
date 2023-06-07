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

    $email = $_SESSION['email'];
    $sql = "SELECT * FROM t_usuario WHERE email = '$email'";
    $result = mysqli_query($conexao, $sql);
    $row = mysqli_fetch_assoc($result);
    $cpf = $row['cpf'];
    $nome = $row['nome'];

    $sql = "SELECT t_reserva.*, t_laboratorio.nome AS nome FROM t_reserva
        INNER JOIN t_laboratorio ON t_reserva.t_laboratorio_id_laboratorio = t_laboratorio.id_laboratorio
        WHERE t_reserva.t_usuario_cpf = '$cpf'
        ORDER BY t_reserva.horario_de_entrega DESC";
    $result = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br" >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema do Secretário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="navbar navbar-dark bg-primary">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <button class="navbar-toggler logout-btn" type="button" onclick="window.location.href = 'sair.php'">
            Sair
        </button>
    </header>
    <main class="d-flex flex-nowrap">
    <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark sidebar" id="sidebarCollapse">
        <ul class="nav nav-pills flex-column mb-auto justify-content-center">
            <li class="nav-item"><a href="sistemaProfessor.php" class="nav-link text-white">Menu</a></li>
            <li><a href="cadastroReserva.php" class="nav-link text-white">Reservar</a></li>
            <li><a href="historicoReservaProfessor.php" class="nav-link active" aria-current="page">Histórico</a></li>
        </ul>
    </div>
    <div class="content d-flex flex-column align-items-center justify-content-center">
        <div class="p-5 bg-white rounded shadow-lg">
            <?php if (mysqli_num_rows($result) > 0) : ?>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Laboratório</th>
                            <th>Usuário</th>
                            <th>Reserva</th>
                            <th>Entrega</th>
                            <th>Ação</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                <?php date_default_timezone_set('America/Sao_Paulo'); ?>
                                    <tr>
                                    <td><?php echo $row['nome']; ?></td>
                                    <td><?php echo $nome; ?></td>
                                    <td><?php echo $row['horario_de_reserva']; ?></td>
                                    <td><?php echo $row['horario_de_entrega']; ?></td>
                                    <td>
                                        <?php if ($row['horario_de_entrega'] < date('Y-m-d H:i:s')) : ?>
                                            <button type="button" class="btn btn-success" disabled>Concluído</button>
                                        <?php else : ?>
                                            <button type="button" class="btn btn-secondary" disabled>Pendente</button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <p>Nenhum dado disponível.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelector('.navbar-toggler').addEventListener('click', function() {
            document.getElementById('sidebarCollapse').classList.toggle('hidden');
        });
    </script>
</body>
</html>


