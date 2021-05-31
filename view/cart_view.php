<!DOCTYPE html>
<html lang="ja">
  <head>
    <title>ショッピングカート</title>
    <?php include VIEW_PATH .'templates/head.php'; ?>
  </head>
  <body>
    <?php include VIEW_PATH .'templates/header.php'; ?>
    <main>     
      <?php include VIEW_PATH .'templates/messages.php'; ?>
      <div class="container">
        <h2>ショッピングカート</h2>
        <?php if(count($cart_items) > 0) { ?>
        <h5>※合計金額1万円以下の場合、別途送料800円ご負担をお願いします。</h5>
        <div class="row">
          <div class="col-md-12">
            <table class="table">
              <thead class="thead-dark">
                <tr>
                  <th>商品名</th>
                  <th>数量</th>
                  <th class="text-center">上代</th>
                  <th class="text-center">下代</th>
                  <th class="text-center">合計</th>
                  <th> </th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($cart_items as $cart_item) { ?>
                <tr>
                  <td class="text-nowrap">
                    <div class="media">
                      <img class="media-object thumbnail pull-left" src="<?php print IMG_PATH.h($cart_item['img']); ?>" style="width: 100px; height: 100px;"> 
                      <div class="media-body">
                        <h4 class="media-heading">
                          <?php print h($cart_item['name']); ?>
                        </h4>
                      </div>
                    </div>
                  </td>
                  <td class="text-nowrap">
                    <form method="post" action="cart_change_amount.php">
                      <input type="number" name="amount" class="form-control" style="width: 80px;"  value="<?php print h($cart_item['amount']); ?>">個
                      <input type="hidden" name="sql_kind" value="change_amount">
                      <input type="hidden" name="item_id" value="<?php print h($cart_item['item_id']); ?>">
                      <input type="hidden" name="token" value="<?php print $token; ?>">
                      <input type="submit" value="変更する">
                    </form> 
                  </td>
                  <td class="text-nowrap">
                    <strong><?php print number_format(h($cart_item['price'])); ?>円</strong>
                  </td>
                  <td class="text-nowrap">
                    <strong><?php print number_format(h($cart_item['price']) * $persent); ?>円</strong>
                  </td>
                  <td class="text-center">
                    <strong><?php print number_format (h(($cart_item['price']) * $persent) * h($cart_item['amount'])); ?>円</strong>
                  </td>
                  <td class=" text-center">
                    <form  method="post" action="cart_delete_item.php">
                      <input type="submit" value="削除" class="btn btn-danger delete">
                      <input type="hidden" name="sql_kind" value="delete_item">
                      <input type="hidden" name="item_id" value="<?php print h($cart_item['item_id']); ?>">
                      <input type="hidden" name="token" value="<?php print $token; ?>">
                    </form>
                  </td>
                </tr>
                <?php } ?>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td><h5>小計</h5></td>
                  <td class="text-right">
                    <h5><strong><?php print number_format ($sail_total_price) ?>円</strong></h5>
                  </td>
                </tr>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td><h5>送料</h5></td>
                  <td class="text-right"><h5><strong><?php print number_format($delivery_cost)  ?></strong></h5></td>
                </tr>
                <tr>
                  <td></td>
                  <td></td> 
                  <td></td>
                  <td></td>
                  <td><h3>合計金額</h3></td>    
                  <td class="text-right"><h3><strong><?php print number_format ($sail_total_price + $delivery_cost) ?>円</strong></h3></td>
                </tr>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>
                    <a class="btn btn-success btn-lg" href="checkout.php">購入手続きに進む</a>
                  </td>
                  <td>
                    <a href="top.php" type="button" class="btn btn-secondary btn-lg">買い物を続ける</a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <?php } ?>
      </div>
    </main>
    <script>
      $('.delete').on('click', () => confirm('商品をカートから削除してもよろしいですか？'))
    </script>
  </body>
</html>