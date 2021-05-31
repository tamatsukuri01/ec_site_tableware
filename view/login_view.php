<!DOCTYPE html>
<html lang="ja">
  <head>
    <title>ログインページ</title>
    <?php include VIEW_PATH .'templates/head.php'; ?>
  </head>
  <body class="text-center">
    <header>
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
          <a class="navbar-brand" href="<?php print(HOME_URL) ?>">TABLE WARE SHOP</a>
        </div>
      </nav>
    </header>
    <main>
      <?php include VIEW_PATH .'templates/messages.php'; ?>
      <div class="cotainer">
        <div class="row justify-content-center">
          <div class="col-md-4">
            <div class="card">
              <h2 class="card-header text-left">ログイン</h2>
              <div class="card-body">
                <form method="post" action='login_process.php'>
                  <div class="form-group row">
                    <label for="company_name" class="col-sm-4 col-form-label">御社名：</label>
                    <input style="width:50%;" type="text" id="company_name" class="form-control" name="company_name" required autofocus>
                  </div>
                  <div class="form-group row">
                    <label for="staff_name" class="col-sm-4 col-form-label">お名前：</label>
                    <input style="width:50%;" type="text" id="staff_name" class="form-control" name="staff_name" required autofocus>
                  </div>
                  <div class="form-group row">
                    <label for="pass" class="col-sm-4 col-form-label">パスワード：</label>
                    <input style="width:50%;" type="password" id="pass" class="form-control" name="pass" required>
                  </div>
                  <div class="row">
                    <div class="col-sm-5">
                      <input type="submit" name="login" class="btn btn-primary btn-block" value="ログイン">
                      <input type="hidden" name="token" value="<?php print $token; ?>">
                    </div>
                    <div class="col-sm-5">
                      <a href="sign_up.php"class="btn btn-success">新規会員登録の方はこちら</a>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-md-2">
            <h5>管理者としてログイン</h5>
            <p>御社名：admin</p>
            <p>お名前：admin</p>
            <p>パスワード：admin</p>
          </div>
          <div class="col-md-2">
            <h5>ユーザーとしてログイン</h5>
            <p>御社名：</p>
            <p>お名前：</p>
            <p>パスワード：</p>
          </div>
        </div>
      </div>
    </main>
  </body>
</html>