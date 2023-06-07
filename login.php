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
      function hideSuccessMessage() {
          var successMessage = document.getElementById('success-message');
          if (successMessage) {
              successMessage.style.display = 'none';
          }
      }
      setTimeout(hideSuccessMessage, 3000);
    </script>
</head>
<body>
    <div class="demo-container">
        <div class="container">
        <?php if (isset($_GET['success'])) : ?>
          <div id="success-message" class="alert alert-success mt-3">
              <?php echo $_GET['success']; ?>
          </div>
        <?php endif; ?>
          <div class="row">
            <div class="col-lg-6 col-12 mx-auto">
              <div class="text-center image-size-small position-relative">
              <img src="https://d1fdloi71mui9q.cloudfront.net/kH2k7XKhTLqCSC2et5jT_2jL910yNx85IilNb" class="rounded-circle p-2 bg-white">
              </div>
              <div class="p-5 bg-white rounded shadow-lg">
                <form action="acessLogin.php" method="POST"> 
                  <label class="font-500">E-mail</label>
                  <input name="email" class="form-control form-control-lg mb-3" type="email" placeholder="E-mail" required>
                  <label class="font-500">Senha</label>
                  <input name="senha" class="form-control form-control-lg mb-3" type="password" placeholder="Senha" required>
                  <button class="btn btn-primary btn-lg w-100 shadow-lg" name="submit" type="submit">ENTRAR</button>
                </form>
               <div class="text-center pt-4">
                <p class="m-0">Não possui uma conta? <a href="cadastro.php" class="text-dark font-weight-bold">Cadastrar-se</a></p>
              </div>          
              </div>        
            </div>
          </div>
        </div>
    </div>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
