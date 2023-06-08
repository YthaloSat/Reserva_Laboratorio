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

    $tipo_usuario = $_SESSION['T_userType_id_userType'];
    $email = $_SESSION['email'];

    if (isset($_POST['submit'])) {
        include_once('database.php');
        
        $id_laboratorio = intval($_POST['id_laboratorio']);
        $horario_de_reserva = date('Y-m-d H:i:s', strtotime($_POST['horario_de_reserva']));
        $horario_de_entrega = date('Y-m-d H:i:s', strtotime($_POST['horario_de_entrega']));

        // Alterar a verificação para consulta....

        $sql_check = "SELECT * FROM t_reserva WHERE t_laboratorio_id_laboratorio = '$id_laboratorio' AND 
                    (horario_de_entrega <= '$horario_de_reserva' OR horario_de_reserva >= '$horario_de_entrega')";
        $result_check = mysqli_query($conexao, $sql_check);

        if (mysqli_num_rows($result_check) > 0) {
            $messageClass = "alert-danger";
            $message = "O Laboratório selecionado já está Reservado.";
        } else {
            if ($horario_de_reserva > $horario_de_entrega) {
                $messageClass = "alert-danger";
                $message = "Data Inválida.";
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
<html lang="pt-br" >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema do Secretário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <script>
      function hideMessage() {
          var Message = document.getElementById('message');
          if (Message) {
              Message.style.display = 'none';
          }
      }
      setTimeout(hideMessage, 3000);
    </script>
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
              <li><a href="cadastroReserva.php" class="nav-link active" aria-current="page">Reservar</a></li>
              <li><a href="historicoReservaProfessor.php" class="nav-link text-white">Histórico</a></li>
            </ul>
        </div>
        <div class="content d-flex flex-column align-items-center justify-content-center">
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
        
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        document.querySelector('.navbar-toggler').addEventListener('click', function() {
            document.getElementById('sidebarCollapse').classList.toggle('hidden');
        });
    </script>
</body>
</html>


