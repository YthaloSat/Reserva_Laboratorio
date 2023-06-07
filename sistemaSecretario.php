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

    $email = $_SESSION['email'];
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
              <li class="nav-item"><a href="#" class="nav-link active" aria-current="page">Menu</a></li>
              <li><a href="relatorioSecretario.php" class="nav-link text-white">Relatório</a></li>
              <li><a href="historicoReservaSecretario.php" class="nav-link text-white">Histórico</a></li>
            </ul>
        </div>
        <div class="content d-flex flex-column align-items-center justify-content-center">
            <h2>Bem-vindo(a), <?php echo $email; ?>!</h2>
            <p>Aproveite sua experiência no painel de controle do Secretário.</p>
            <img src="https://img.freepik.com/fotos-premium/3d-renderizacao-de-gatinho-fofo-vestindo-uma-fantasia-de-tubarao-adoravel_685067-1030.jpg" alt="Gatinho interativo" onclick="interactWithCat()" class="mt-4">
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


