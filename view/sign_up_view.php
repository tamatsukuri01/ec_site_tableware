<!DOCTYPE html>
<html lang="ja">
  <head>
    <title>ユーザー登録</title>
    <?php include VIEW_PATH .'templates/head.php'; ?>
    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
  </head>
  <body>
    <header>
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
          <a class="navbar-brand" href="<?php print(LOGIN_URL) ?>">TABLE WARE SHOP</a>
        </div>
      </nav>
    </header>
    <main>
      <?php include VIEW_PATH .'templates/messages.php'; ?>
      <div class="cotainer">
        <div class="row justify-content-center">
          <div class="col-md-4">
            <div class="card">
              <h2 class="card-header text-left">会員登録</h2>
              <div class="card-body">
                <form method="post" action="sign_up_process.php">
                  <div class="form-group row">
                    <label for="company_name" class="col-sm-4 col-form-label">御社名：</label>
                    <input style="width:50%;" type="text" name="company_name" class="form-control" id="company_name" required autofocus placeholder="株式会社〇〇">
                  </div>
                  <div class="form-group row">
                    <label for="user_name" class="col-sm-4 col-form-label">代表者名：</label>
                    <input style="width:50%;" type="text" name="user_name" class="form-control" id="user_name" required autofocus>
                  </div>
                  <div class="form-group row">
                    <label for="pass" class="col-sm-4 col-form-label">パスワード：</label>
                      <input style="width:50%;" type="password" id="pass" class="form-control" maxlength="8"  name="pass" required>
                    <span>(パスワードは半角英数字6文字以上8文字以内で入力して下さい。)</span>
                  </div>
                  <div class="form-group row">
                    <label for="user_mail" class="col-sm-5 col-form-label">代表メールアドレス：</label>
                    <input style="width:50%;" type="email" name="user_mail" class="form-control" id="user_mail" placeholder="aaa@bbb.com" required autofocus>
                  </div>
                  <div class="form-group row">
                    <label for="user_tell"  class="col-sm-4 col-form-label">代表電話番号：</label>
                    <input style="width:50%;" type="tel" name="user_tell" class="form-control" id="user_tell" placeholder="○○-○○○○-○○○○" required autofocus>
                    <span>(ハイフン"-"を含めた半角数字で入力して下さい。)</span>
                  </div>
                  <div class="form-group row">
                    <label for="post_code" class="col-sm-4 col-form-label">郵便番号：</label>
                    <input style="width:100px;" type="text" name="post_code" onKeyUp="AjaxZip3.zip2addr('post_code', '', 'address', 'address');" id="post_code" placeholder="123-4567" required>
                    <span>(ハイフン"-"を含めた半角数字で入力して下さい。)</span>
                  </div>
                  <div class="form-group row">
                    <label for="address" class="col-sm-4 col-form-label">住所：</label>
                    <input type="text" class="form-control"  name="address" placeholder="東京都〇〇区〇〇1-2-3" id="address" required>
                  </div>
                  <div class="row ">
                    <div class=col-sm-5>
                      <input type="submit" name="login" class="btn btn-success btn-block " value="登録">
                      <input type="hidden" name="token" value="<?php print $token; ?>">
                    </div>
                    <div class=col-sm-5>
                      <a class="btn btn-primary " href='login.php'>ログインページへ</a>
                    </div>
                  </div>   
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </body>
</html>