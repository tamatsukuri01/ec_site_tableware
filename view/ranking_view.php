<!DOCTYPE html>
  <html lang="ja">
    <head>
      <?php include VIEW_PATH .'templates/head.php'; ?>
      <title>売れ筋ランキング</title>
    </head>
    <body>
      <main>
        <div class="container">
          <?php include VIEW_PATH . 'templates/header.php'; ?>
          <h1>売れ筋ランキング</h1>
          <div class="row">
            <form method="get" action="ranking.php">
                <select name="categories">
                  <option value="" selected>全カテゴリー</option>
                  <?php foreach($categories as $category) { ?>
                  <option <?php if(isset($category_id) && $category_id === $category['item_type'] ) {echo 'selected';} ?> value="<?php print h($category['item_type']); ?>">
                  <?php print h($category['item_type']); ?></option>
                  <?php } ?>
                </select>
                <input type="submit" value="絞り込む">
              </form>
              <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th>順位</th>
                    <th>商品名</th>
                    <th>価格</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($ranking_items as $key => $ranking_item) { ?>
                  <tr>
                    <td><?php print h($key + 1); ?>位</td>
                    <td><?php print h($ranking_item['name']); ?></td>
                    <td><?php print h($ranking_item['price']) * $persent; ?>円</td>
                    <td>
                      <form method="get" action="item_data.php">
                        <input type="submit" value="商品詳細" class="btn btn-primary">
                        <input type="hidden" name="item_id" value="<?php print h($ranking_item['item_id']); ?>">
                      </form>
                    </td>
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

