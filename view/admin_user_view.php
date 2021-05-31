<!DOCTYPE html>
<html lang="ja">
  <head>
      <title>ユーザー管理</title>
      <?php include VIEW_PATH .'templates/head.php'; ?>
  </head>
  <body>
    <main>
      <div class="container">
        <?php include VIEW_PATH .'templates/header.php'; ?>
        <h1>TABL WARE SHOP 管理ページ</h1>
        <a href='<?php print (ADMIN_URL) ?>'>商品管理ページへ</a>
        <h2>ユーザー管理情報</h2>
        <?php include VIEW_PATH .'templates/messages.php'; ?>
        <div class="row">
          <div class="col-me-12">
            <table class="table">
              <thead class="thead-dark">
                <tr  class="text-nowrap">
                    <th>ユーザーID</th>
                    <th>会社名</th>
                    <th>代表者名</th>
                    <th>電話番号</th>
                    <th>メールアドレス</th>
                    <th>掛け率</th>
                    <th>登録日</th>
                    <th>更新日</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($user_lists as $user_list) { ?>
                <tr class="text-nowrap">
                    <td><?php print h($user_list['user_id']); ?></td>
                    <td><?php print h($user_list['company_name']); ?></td>
                    <td><?php print h($user_list['user_name']); ?></td>
                    <td><?php print h($user_list['tell']); ?></td>
                    <td><?php print h($user_list['mail']); ?></td>
                    <td>
                      <form method="post" action="admin_user_process.php">
                          <input style="width: 30%;" type="text" name="persent" value="<?php print h($user_list['persent']); ?>">
                          <input type="hidden" name="user_id" value="<?php print h($user_list['user_id']); ?>">
                          <input type="hidden" name="token" value="<?php print $token; ?>">
                          <input type="submit" value="変更する">
                      </form>    
                    </td>
                    <td><?php print h($user_list['createdate']); ?></td>
                    <td><?php print h($user_list['updatedate']); ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>
  </body>
</html>