<!DOCTYPE html>
<html lang="ja">
  <head>
    <title>購入明細</title>
    <?php include VIEW_PATH .'templates/head.php'; ?>
  </head>
  <body>
    <?php include VIEW_PATH .'templates/header.php'; ?>
    <main>
      <?php include VIEW_PATH .'templates/messages.php'; ?>
      <div class="container">
        <a href="orders.php" class="btn btn-secondary">購入履歴に戻る</a>
        <div class="row">
          <div class="col-md-12">
            <table class="table">
              <thead class="thead-dark">
                <tr>
                  <th>御社名</th>
                  <th>お届け先</th>
                  <th>ご担当者</th>
                  <th>注文番号</th>
                  <th>注文日</th>
                  <th>合計金額</th>
                </tr>  
              </thead>  
              <tbody>
                <?php foreach($records as $record) { ?>
                <tr>
                  <td><?php print h($record['company_name']); ?></td>
                  <td><?php print h($record['end_user_name']); ?></td>
                  <td><?php print h($record['staff_name']); ?>様</td>
                  <td><?php print h($record['order_number']); ?></td>
                  <td><?php print h($record['order_datetime']); ?></td>
                  <td><?php print number_format(h($record['total_price'])); ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">  
            <h1>購入明細</h1>
            <table class="table">
              <thead class="thead-dark">
                <tr>
                  <th>商品名</th>
                  <th>価格</th>
                  <th>購入数</th>
                  <th>小計</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($details as $detail) { ?>
                <tr>
                  <td><?php print h($detail['name']); ?></td>
                  <td><?php print h($detail['price']); ?>円</td>
                  <td><?php print h($detail['amount']); ?>個</td>
                  <td><?php print number_format(h($detail['price']) * h($detail['amount'])); ?></td>
                  <td> 
                    <form method="get" action="item_data.php">
                      <input type="submit" value="商品詳細" class="btn btn-primary">
                      <input type="hidden" name="item_id" value="<?php print h($detail['item_id']); ?>">
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