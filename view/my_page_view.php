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
            <h1>登録情報</h1>
            <table class="table table-bordered">
              <thead class="thead-dark">
                <tr class="text-nowrap">
                  <th>御社名</th>
                  <th>代表者名</th>
                  <th>住所</th>
                  <th>メールアドレス</th>
                  <th>電話番号</th>
                  <th>掛け率</th>
                  <th>会員登録日</th>
                  <th>更新日</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($user_info as $info) { ?>
                <tr class="text-nowrap">
                  <td><?php print h($info['company_name']); ?></td>
                  <td><?php print h($info['user_name']); ?>様</td>
                  <td><?php print h($info['address']); ?></td>
                  <td><?php print h($info['mail']); ?></td>
                  <td><?php print h($info['tell']); ?></td>
                  <td><?php print h($info['persent']); ?>%</td>
                  <td><?php print h($info['createdate']); ?></td>
                  <td><?php print h($info['updatedate']); ?></td>
                </tr>
                <?php } ?>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>
                    <a class="btn btn-primary" href="change_my_page.php" >登録情報変更</a>
                  </td>
                  <td>
                    <a class="btn btn-primary" href="end_user.php" >届け先確認</a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <h2>登録社員</h2>
            <table class="table table-bordered">
              <thead class="thead-dark">
                <tr>
                  <th>お名前</th>
                  <th>メールアドレス</th>
                  <th>電話番号</th>
                  <th>登録日</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($staffs as $staff) { ?>
                <tr>
                  <td><?php print h($staff['staff_name']); ?>様</td>
                  <td><?php print h($staff['staff_mail']); ?></td>
                  <td><?php print h($staff['staff_tell']); ?></td>
                  <td><?php print h($staff['createdate']); ?></td>
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