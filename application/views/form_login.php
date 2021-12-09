<!DOCTYPE html>
<html>

<head>
  <title>CustomTN | Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="asset/images/logo.png">
  <link rel="stylesheet" type="text/css" href="template/vendor/bootstrap/css/bootstrap.css">
  <link href="template/signin/signin.css" rel="stylesheet">
</head>

<body class="text-center">
  <!-- <form class="form-signin"> -->
  <?php echo form_open('login/auth', array('class' => 'form-signin')); ?>
  <img class="mb-4" src="asset/images/logo.png" alt="" width="72">
  <h2 style="margin-bottom: 0px"><strong>Custom TN</strong></h2>
  <p><strong>(Aplikasi Data Pelanggan Tirtanadi)</strong></p>
  <br>
  <label for="inputEmail" class="sr-only">NIPP</label>
  <input type="text" name="nipp" id="inputEmail" class="form-control" placeholder="NIPP" required autofocus>
  <label for="inputPassword" class="sr-only">Password</label>
  <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
  <div class="checkbox mb-3">
    <label>
      <input type="checkbox" value="remember-me"> Ingat Saya
    </label>
  </div>
  <button class="btn btn-lg btn-primary btn-block" type="submit">Masuk</button>
  <br>
  <p class="mt-5 mb-3 text-muted">&copy; Tirtanadi 2021</p>
  </form>
</body>

</html>