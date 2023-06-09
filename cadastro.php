<?php

  if (isset($_POST['submit'])) {
      include_once('database.php');

      $nome = $_POST['nome'];
      $email = $_POST['email'];
      $senha = $_POST['senha'];
      $acessKey = $_POST['acessKey'];
      $cpf = $_POST['cpf'];
      $tipo_usuario = intval($_POST['T_userType_id_userType']);

      $sql_key = "SELECT * FROM t_acessKeys WHERE acessKey = '$acessKey'";
      $result_key = mysqli_query($conexao, $sql_key);

      if (mysqli_num_rows($result_key) == 0) {
        $error_message = "Chave de acesso inválida. Por favor, insira uma chave válida.";
      } else {
        $sql = "SELECT cpf FROM t_usuario WHERE cpf = '$cpf'";
        $result = mysqli_query($conexao, $sql);
  
        if (mysqli_num_rows($result) > 0) {
            $error_message = "CPF já cadastrado. Por favor, insira um CPF válido.";
        } else {
            $sql = "SELECT email FROM t_usuario WHERE email = '$email'";
            $result = mysqli_query($conexao, $sql);
  
            if (mysqli_num_rows($result) > 0) {
                $error_message = "Email já cadastrado. Por favor, insira um email válido.";
            } else {
                $sql = "INSERT INTO t_usuario(nome_usuario, email, cpf, senha, T_userType_id_userType) 
                VALUES ('$nome', '$email', '$cpf', '$senha', '$tipo_usuario');";
                $result = mysqli_query($conexao, $sql);
  
                header('Location: login.php');
                header('Location: login.php?success=Cadastro realizado com sucesso.');
            }
        }
      }
  }
?>

<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Sistema</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body class="d-flex align-items-center py-4 bg-body-tertiary">
      <main class="form-signin w-100 m-auto">
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="moon-stars-fill" viewBox="0 0 16 16">
                <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"></path>
                <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z"></path>
            </symbol>
            <symbol id="sun-fill" viewBox="0 0 16 16">
                <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"></path>
            </symbol>
        </svg>
        <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
            <button class="btn btn-primary py-2 dropdown-toggle d-flex align-items-center" id="bd-theme" type="button" onclick="toggleThemeLogin()">
                <svg class="bi my-0 theme-icon-active" width="1em" height="1em"><use href="#moon-stars-fill"></use></svg>
                <span class="visually-hidden" id="bd-theme-text">Toggle theme to light</span>
            </button>
        </div>

        <?php if (isset($error_message)) : ?>
            <div id="error-message" class="alert alert-danger mt-3 text-center error-message">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form action="cadastro.php" method="POST">
            <h1 class="h3 mb-3 fw-normal">Cadastro</h1>
            <br>
            <input name="nome" class="form-control form-control-lg mb-3" type="text" placeholder="Nome" required>
            <input name="email" class="form-control form-control-lg mb-3" type="email" placeholder="E-mail" required>
            <input name="senha" class="form-control form-control-lg mb-3" type="password" placeholder="Senha" required>
            <input name="acessKey" class="form-control form-control-lg mb-3" type="password" placeholder="Chave de Acesso" required>
            <input name="cpf" class="form-control form-control-lg mb-3" type="text" placeholder="CPF" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" required>
            <select name="T_userType_id_userType" class="form-control form-control-lg mb-3" required>
                <option value="">Selecione o tipo de usuário</option>
                <option value="1">Secretário</option>
                <option value="2">Professor</option>
            </select>
            <br>
            <button class="btn btn-primary w-100 py-2" name="submit" type="submit">Cadastrar</button>
            <p class="mt-5 mb-3 text-body-secondary">Já possui uma conta? <a href="login.php">Entrar</a></p>
        </form>
    </main>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="script.js"></script>
</body>
</html>

