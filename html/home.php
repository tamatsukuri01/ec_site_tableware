<!DOCTYPE html>
<html lang="ja">
  <head>
    <title>ホーム</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="//code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <style>
    .jumbotron-extend {
        position: relative;
        height: 100vh;
        min-height: 300px;
        background: url(assets/img/main.jpeg) no-repeat center center;
        background-size: cover;
    }
    .jumbotron-container {
        position: relative;
        top: 50%;
        transform: translateY(-50%);
    }
    .site-name {
        margin-bottom: 40px;
        font-family: 'Playfair Display', serif; 
    }
    .btn-primary {
        border-radius: 0;
        font-family: 'Avenir', serif;
        margin-left: 20px;
    }
    .btn-primary:hover {
        opacity: 0.8;
    }
    </style>
  </head>
  <body>
    <div class="jumbotron jumbotron-extend">
      <div class="container-fluid jumbotron-container">
        <h1 class="site-name">TABLE WARE SHOP</h1>
        <div class="row">
          <p><a class="btn btn-primary btn-lg" href="sign_up.php" role="button">新規会員登録</a>
          <a class="btn btn-primary btn-lg" href="login.php" role="button">ログイン</a></p>
        </div>
      </div>
    </div>
  </body>
</html>