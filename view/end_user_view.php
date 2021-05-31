<!DOCTYPE html>
<html lang="ja">
  <head>
    <title>ユーザー情報</title>
    <?php include VIEW_PATH .'templates/head.php'; ?>
  </head>
  <body>
    <?php include VIEW_PATH .'templates/header.php'; ?>
    <main>
      <?php include VIEW_PATH .'templates/messages.php'; ?>
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <a href="regist_end_user.php" class="btn btn-primary">届け先登録</a>
            <a href="my_page.php" class="btn btn-secondary">マイページへ戻る</a>
            <?php if($end_users > 0) { ?>
            <table class="table table-bordered">
              <thead class="thead-dark">
                <tr>
                  <th>届け先名</th>
                  <th>郵便番号</th>
                  <th>住所</th>
                  <th>電話番号</th>
                  <th>登録日</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($end_users as $end_user) { ?>
                <tr>
                  <td><?php print h($end_user['end_user_name']); ?>様</td>
                  <td><?php print h($end_user['end_user_post_code']); ?></td>
                  <td><?php print h($end_user['end_user_address']); ?></td>
                  <td><?php print h($end_user['end_user_tell']); ?></td>
                  <td><?php print h($end_user['createdate']); ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <?php } ?>
          </div>
        </div>
      </div>
    </main>
  </body>
</html>