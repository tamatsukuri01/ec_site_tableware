<!DOCTYPE html>
<html lang="ja">
  <head>
    <title>商品管理ページ</title>
    <style>
        img {
            width:150px;
            height:150px;
        }
        .close_item {
          background-color: #dddddd;
        }
    </style>
    <?php include VIEW_PATH .'templates/head.php'; ?>
  </head>
  <body>
    <?php include VIEW_PATH .'templates/header.php'; ?>
    <main>
      <div class="container"> 
        <h1>商品管理ページ</h1>
        <a href="<?php print(ADMIN_USER_URL) ?>">ユーザー管理ページへ</a>
        <h2>商品の登録</h2>
        <?php include VIEW_PATH .'templates/messages.php'; ?>
        <form method="post" action="admin_process.php" enctype="multipart/form-data">
            <div><label for="name">商品名：</label><input type="text" name="name" id="name"></div>
            <div><label for="price">値段：</label><input type="text" name="price" id="price"></div>
            <div><label for="stock">個数：</label><input type="text" name="stock" id="stock"></div>
            <div><label for="img">商品画像：</label><input type="file" name="img" id="img"></div>
            <div>種類：
              <select name="item_type">
                <option value="">選択してください</option>
                <option value="プレート">プレート</option>
                <option value="カップ">カップ</option>
                <option value="グラス">グラス</option>
                <option value="カトラリー">カトラリー</option>
              </select>
            </div>
            <div><label for="pickup">特集：</label><input type="text" name="pickup" id="pickup"></div>
            <div><label for="comment">商品説明：</label><br><textarea rows="4" name="comment" id="comment"></textarea></div>
            <div>ステータス：
              <select name="status">
                <option value="0">非公開</option>
                <option value="1" selected>公開</option>
              </select>
            </div>
            <input type="submit" value="商品を登録する"> 
            <input type="hidden" name="sql_kind" value="insert_item">
            <input type="hidden" name="token" value="<?php print $token; ?>">
        </form>
        <h2>商品情報の一覧・変更</h2>
        <table class="table">
          <thead class="thead-dark">
            <tr class="text-nowrap">
              <th>商品ID</th>
              <th>商品画像</th>
              <th>商品名</th>
              <th>値段</th>
              <th>在庫数</th>
              <th>種類</th>
              <th>特集</th>
              <th>商品説明</th>
              <th>ステータス</th>
              <th>操作</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($items as $item) { ?>
            <tr class="<?php if((int)($item['status']) === 0) {echo 'close_item'; } ?>" >
              <td><?php print h($item['item_id']); ?></td>
              <td><img src="<?php print IMG_PATH.h($item['img']); ?>"></td>
              <td class="text-nowrap"><?php print h($item['name']); ?></td>
              <td>
                <form method="post" action="admin_process.php">
                  <input type="number" name="price" style="width:70px;" min="1" value="<?php print h($item['price']); ?>">円
                  <input type="hidden" name="item_id" value="<?php print h($item['item_id']); ?>">
                  <input type="hidden" name="token" value="<?php print $token; ?>">
                  <input type="hidden" name="sql_kind" value="update_price">
                  <input type="submit" value="変更する">
                </form>
              <td>
                <form method="post" action="admin_process.php">
                  <input type="number" name="stock" style="width:50px;" min="1" value="<?php print h($item['stock']); ?>">個
                  <input type="hidden" name="item_id" value="<?php print h($item['item_id']); ?>">
                  <input type="hidden" name="token" value="<?php print $token; ?>">
                  <input type="hidden" name="sql_kind" value="update_stock">
                  <input type="submit" value="変更する">
                </form>
              </td>  
              <td>
                <?php print h($item['item_type']); ?>
              </td>
              <td>
                <form method="post" action="admin_process.php">
                  <input type="text" name="pickup" style="width:70px;" value="<?PHP print h($item['pickup']); ?>">
                  <input type="hidden" name="item_id" value="<?php print h($item['item_id']); ?>">
                  <input type="hidden" name="token" value="<?php print $token; ?>">
                  <input type="hidden" name="sql_kind" value="update_pickup">
                  <input type="submit" value="変更する">
                </form>
              </td>
              <td>
                <form method="post" action="admin_process.php">
                  <textarea rows="4" name="comment"><?php print h($item['comment']); ?></textarea>
                  <input type="hidden" name="item_id" value="<?php print h($item['item_id']); ?>">
                  <input type="hidden" name="token" value="<?php print $token; ?>">
                  <input type="hidden" name="sql_kind" value="update_comment">
                  <input type="submit" value="変更する">
                </form>
              </td>
              <td>
                <?php if((int)$item['status'] === 0) { ?>
                  <form method="post" action="admin_process.php">
                    <input type="submit" value="非公開→公開にする">
                    <input type="hidden" name="sql_kind" value="update_status">
                    <input type="hidden" name="status" value="1">
                    <input type="hidden" name="item_id" value="<?php print h($item['item_id']); ?>">
                    <input type="hidden" name="token" value="<?php print $token; ?>">
                  </form>
                <?php } else { ?>
                  <form method="post" action="admin_process.php">
                    <input type="submit" value="公開→非公開にする">
                    <input type="hidden" name="sql_kind" value="update_status">
                    <input type="hidden" name="status" value="0">
                    <input type="hidden" name="item_id" value="<?php print h($item['item_id']); ?>">
                    <input type="hidden" name="token" value="<?php print $token; ?>">
                  </form>
                <?php } ?>
              </td>
              <td>
                <form method="post" action="admin_process.php">
                  <input type="submit" value="削除">
                  <input type="hidden" name="sql_kind" value="delete_item">
                  <input type="hidden" name="item_id" value="<?php print h($item['item_id']); ?>">
                  <input type="hidden" name="token" value="<?php print $token; ?>">
                </form>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </main>
  </body>
</html>