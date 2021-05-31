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
              <h2 class="card-header text-left">届け先登録</h2>
              <div class="card-body">
                <form method="post" action="regist_end_user_process.php">
                  <div class="form-group row">
                    <label for="end_user_name" class="col-sm-4 col-form-label">届け先名：</label>
                    <input style="width:50%;" type="text" name="end_user_name" class="form-control" id="end_user_name" required autofocus>
                  </div>
                  <div class="form-group row">
                    <label for="end_user_post_code" class="col-sm-4 col-form-label">郵便番号：</label>
                    <input style="width:100px;" type="text" name="end_user_post_code" onKeyUp="AjaxZip3.zip2addr('end_user_post_code', '', 'end_user_address', 'end_user_address');" id="end_user_post_code" required autofocus>
                  </div>
                  <div class="form-group row">
                    <label for="end_user_address" class="col-sm-4 col-form-label">住所：</label>
                    <input type="text" class="form-control"  name="end_user_address" id="end_user_address" required autofocus>
                  </div>
                  <div class="form-group row">
                    <label for="end_user_tell"  class="col-sm-4 col-form-label">電話番号：</label>
                    <input style="width:50%;" type="tel" name="end_user_tell" id="end_user_tell" class="form-control" required autofocus>
                  </div>
                  <div class="row ">
                    <div class=col-sm-5>
                      <input type="submit" class="btn btn-success btn-block " value="登録">
                      <input type="hidden" name="token" value="<?php print $token; ?>">
                    </div>
                    <div class=col-sm-5>
                      <a class="btn btn-primary " href='end_user.php'>届け先確認へ戻る</a>
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