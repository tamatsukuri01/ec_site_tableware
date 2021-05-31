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
            <h1>購入履歴</h1> 
            <form method="get" action="orders.php">
              <select name="staff_id" class="form-select">
                <option value="" selected >全件表示</option>
                <?php foreach($staffs as $staff) { ?>
                <option value="<?php print h($staff['staff_id']); ?>" <?php if(isset($staff_id) && $staff['staff_id'] == $orders[0]['staff_id']) 
                  {echo 'selected';} ?>><?php print h($staff['staff_name']); ?></option>
                <?php } ?>
              </select>
                <input type="submit" value="表示" class="btn btn-primary">
            </form>
            <table class="table">
              <thead class="thead-dark">
                <tr>
                  <th>御社名</th>
                  <th>ご担当者</th>
                  <th>注文番号</th>
                  <th>注文日</th>
                  <th>合計金額</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($orders as $order) { ?>
                <tr>
                  <td><?php print h($order['company_name']); ?></td>
                  <td><?php print h($order['staff_name']); ?>様</td>
                  <td><?php print h($order['order_number']); ?></td>
                  <td><?php print h($order['order_datetime']); ?></td>
                  <td><?php print number_format(h($order['total_price'])); ?>円</td>
                  <td>
                    <form method='post' action='order_details.php'>
                      <input type="submit" name='order_details' value='購入明細表示'>
                      <input type='hidden' name='order_number' value="<?php print h($order['order_number']); ?>">
                      <input type='hidden' name='user_id' value="<?php print h($order['user_id']); ?>">
                      <input type='hidden' name='staff_id' value="<?php print h($order['staff_id']); ?>">
                      <input type="hidden" name="token" value="<?php print $token; ?>">
                    </form>
                  </td>
                </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>
  </body>
</html>