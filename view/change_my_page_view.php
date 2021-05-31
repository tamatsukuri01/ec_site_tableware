<!DOCTYPE html>
<html lang="ja">
  <head>
    <title>ユーザー情報</title>
    <?php include VIEW_PATH .'templates/head.php'; ?>
    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
  </head>
  <body>
    <?php include VIEW_PATH .'templates/header.php'; ?>
    <main>
      <?php include VIEW_PATH .'templates/messages.php'; ?>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="card">
              <h2 class="card-header text-left">登録情報変更</h2>
              <?php foreach($users as $user) { ?>
              <div class="card-body">
                <form method="post" action="change_my_page_process.php">
                  <div class="form-group row">
                      <label for="company_name" class="col-sm-4 col-form-label">御社名：</label>
                      <input style="width:50%;" type="text" name="company_name" class="form-control" id="company_name" value="<?php print h($user['company_name']); ?>" required autofocus>
                  </div>
                  <div class="form-group row">
                      <label for="user_name" class="col-sm-4 col-form-label">代表者名：</label>
                      <input style="width:50%;" type="text" name="user_name" class="form-control" id="user_name" value="<?php print h($user['user_name']); ?>" required autofocus>
                  </div>
                  <div class="form-group row">
                  <label for="user_mail" class="col-sm-5 col-form-label">代表メールアドレス：</label>
                      <input style="width:50%;" type="email" name="user_mail" class="form-control" id="user_mail"  value="<?php print h($user['mail']); ?>" required autofocus>
                  </div>
                  <div class="form-group row">
                      <label for="user_tell"  class="col-sm-4 col-form-label">代表電話番号：</label>
                      <input style="width:50%;" type="tel" name="user_tell" class="form-control" id="user_tell" value="<?php print h($user['tell']); ?>" required autofocus>
                  </div>
                  <div class="form-group row">
                      <label for="post_code" class="col-sm-4 col-form-label">郵便番号：</label>
                      <input style="width:100px;" type="text" name="post_code" onKeyUp="AjaxZip3.zip2addr('post_code', '', 'address', 'address');" id="post_code" value="<?php print h($user['post_code']); ?>" required autofocus>
                  </div>
                  <div class="form-group row">
                      <label for="address" class="col-sm-4 col-form-label">住所：</label>
                      <input type="text" class="form-control"  name="address" id="address" value="<?php print h($user['address']); ?>" required autofocus>
                  </div>

                  <div class="row ">
                    <div class=col-sm-5>
                      <input type="submit" name="login" class="btn btn-success btn-block " value="変更">
                      <input type="hidden" name="sql_kind" value="change_my_page">
                      <input type="hidden" name="token" value="<?php print $token; ?>">
                    </div>
                    <div class=col-sm-5>
                      <a class="btn btn-secondary " href='my_page.php'>マイページへ戻る</a>
                    </div>
                  </div>   
                </form>
              </div>
              <?php } ?>
            </div> 
          </div>
        </div>

        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="card">
              <h2 class="card-header text-left">社員登録</h2>
              <div class="card-body">
                <form method="post" action="change_my_page_process.php">
                  <div class="form-group row">
                    <label for="staff_name" class="col-sm-4 col-form-label">お名前：</label>
                    <input style="width:50%;" type="text" name="staff_name" class="form-control" id="staff_name" required autofocus>
                  </div>
                  <div class="form-group row">
                    <label for="staff_mail" class="col-sm-5 col-form-label">メールアドレス：</label>
                    <input style="width:50%;" type="email" name="staff_mail" class="form-control" id="staff_mail" required autofocus>
                  </div>
                  <div class="form-group row">
                    <label for="staff_tell"  class="col-sm-4 col-form-label">携帯電話番号：</label>
                    <input style="width:50%;" type="tel" name="staff_tell" id="staff_tell" class="form-control" required autofocus>
                  </div>
                  <div class="row ">
                    <div class=col-sm-5>
                      <input type="submit" name="login" class="btn btn-success btn-block " value="登録">
                      <input type="hidden" name="sql_kind" value="register_staff">
                      <input type="hidden" name="token" value="<?php print $token; ?>">
                    </div>
                    <div class=col-sm-5>
                      <a class="btn btn-secondary " href='my_page.php'>マイページへ戻る</a>
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