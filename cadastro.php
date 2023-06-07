<?php

  if (isset($_POST['submit'])) {
      include_once('database.php');

      $nome = $_POST['nome'];
      $email = $_POST['email'];
      $senha = $_POST['senha'];
      $cpf = $_POST['cpf'];
      $tipo_usuario = intval($_POST['T_userType_id_userType']);

      // Verifica se o CPF já existe no banco de dados
      $sql = "SELECT cpf FROM t_usuario WHERE cpf = '$cpf'";
      $result = mysqli_query($conexao, $sql);

      if (mysqli_num_rows($result) > 0) {
          // CPF já existe, exibe mensagem de erro
          $error_message = "CPF já cadastrado. Por favor, insira um CPF válido.";
      } else {
          // Verifica se o email já existe no banco de dados
          $sql = "SELECT email FROM t_usuario WHERE email = '$email'";
          $result = mysqli_query($conexao, $sql);

          if (mysqli_num_rows($result) > 0) {
              // Email já existe, exibe mensagem de erro
              $error_message = "Email já cadastrado. Por favor, insira um email válido.";
          } else {
            // Insere os dados do novo usuário no banco de dados
              $sql = "INSERT INTO t_usuario(nome, email, cpf, senha, T_userType_id_userType) 
              VALUES ('$nome', '$email', '$cpf', '$senha', '$tipo_usuario');";
              $result = mysqli_query($conexao, $sql);

              header('Location: login.php');
              header('Location: login.php?success=Cadastro realizado com sucesso.');
          }
      }
  }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.lineicons.com/2.0/LineIcons.css">
    <title>AberturaLab</title>
    <link rel="stylesheet" href="style.css">

    <script>
      function hideErrorMessage() {
          var errorMessage = document.getElementById('error-message');
          if (errorMessage) {
              errorMessage.style.display = 'none';
          }
      }
      setTimeout(hideErrorMessage, 3000);
    </script>
</head>
<body>
    
    <div class="demo-container">
        <div class="container">
        <?php if (isset($error_message)) : ?>
            <div id="error-message" class="alert alert-danger mt-3">
              <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
          <div class="row">
            <div class="col-lg-6 col-12 mx-auto">
              <div class="p-5 bg-white rounded shadow-lg">
                <form action="cadastro.php" method="POST">
                  <label class="font-500">Nome</label>
                  <input name="nome" class="form-control form-control-lg mb-3" type="text" placeholder="Nome" required>
                  <label class="font-500">E-mail</label>
                  <input name="email" class="form-control form-control-lg mb-3" type="email" placeholder="E-mail" required>
                  <label class="font-500">Senha</label>
                  <input name="senha" class="form-control form-control-lg mb-3" type="password" placeholder="Senha" required>
                  <label class="font-500">CPF</label>
                  <input name="cpf" class="form-control form-control-lg mb-3" type="text" placeholder="CPF" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" required>
                  <label class="font-500">Tipo de Usuário</label>
                  <select name="T_userType_id_userType" class="form-control form-control-lg mb-3" required>
                    <option value="">Selecione o tipo de usuário</option>
                    <option value="1">Secretário</option>
                    <option value="2">Professor</option>
                  </select>
                  <button class="btn btn-primary btn-lg w-100 shadow-lg" type="submit" name="submit">CADASTRAR</button>
                </form>
               <div class="text-center pt-4">
                <p class="m-0">Já possui uma conta? <a href="login.php" class="text-dark font-weight-bold">Entrar</a></p>
              </div>          
              </div>        
            </div>
          </div>
        </div>
    </div>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
      $(document).ready(function() {
        $('input[name="cpf"]').mask('000.000.000-00', {reverse: true});
      
        $('input[name="email"]').on('input', function() {
          var email = $(this).val();
          var pattern = /^[a-zA-Z0-9._%+-]+@+[a-zA-Z0-9._%+-]+.+[a-zA-Z0-9._%+-]$/i;
      
          if (pattern.test(email)) {
            $(this).removeClass('is-invalid');
          } else {
            $(this).addClass('is-invalid');
          }
        });
      });
    </script>
</body>
</html>
