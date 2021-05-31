<!DOCTYPE html>
<html lang="ja">
  <head>
      <title>購入完了ページ</title>
      <?php include VIEW_PATH .'templates/head.php'; ?>
  </head>
  <body>
    <?php include VIEW_PATH .'templates/header.php'; ?>
    <main>
      <?php include VIEW_PATH .'templates/messages.php'; ?>
      <div class="container">
        <?php if(count($cart_items) > 0) {?>
        <h2>ショッピングカート</h2>
        <div class="row">
          <div class="col-md-12">
            <table class="table">
              <thead class="thead-dark">
                <tr>
                  <th>お届け先名</th>
                  <th>郵便番号</th>
                  <th>住所</th>
                  <th>電話番号</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><?php print h($delivery_address['end_user_name']); ?></td>
                  <td><?php print h($delivery_address['end__user_post_code']); ?></td>
                  <td><?php print h($delivery_address['end_user_address']); ?></td>
                  <td><?php print h($delivery_address['end_user_tell']); ?></td>
                </tr>
              </tbody>
            </table>
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
                  <td>
                    <div class="media">
                      <a class="thumbnail pull-left" href="#"> 
                        <img class="media-object" src="<?php print IMG_PATH.h($cart_item['img']); ?>" style="width: 100px; height: 100px;"> 
                      </a>
                      <div class="media-body">
                        <h4 class="media-heading">
                          <?php print h($cart_item['name']); ?>
                        </h4>
                      </div>
                    </div>
                  </td>
                  <td class="text-center">
                    <strong><?php print h($cart_item['amount']); ?>個</strong>    
                  </td>
                  <td class=" text-center">
                    <strong><?php print number_format(h($cart_item['price'])); ?>円</strong>
                  </td>
                  <td class=" text-center">
                    <strong><?php print number_format(h($cart_item['price']) * $persent); ?>円</strong>
                  </td>
                  <td class="text-center">
                    <strong><?php print number_format (h(($cart_item['price']) * $persent) * h($cart_item['amount'])); ?>円</strong>
                  </td>
                </tr>
                <?php } ?>
                <tr>
                  <td>  </td>
                  <td>  </td>
                  <td>  </td>
                  <td>  </td>
                  <td><h5>小計</h5></td>
                  <td class="text-right">
                    <h5><strong><?php print number_format ($sail_total_price) ?>円</strong></h5>
                  </td>
                </tr>
                <tr>
                  <td>  </td>
                  <td>  </td>
                  <td>  </td>
                  <td>  </td>
                  <td><h5>送料</h5></td>
                  <td class="text-right"><h5><strong><?php print number_format($delivery_cost); ?> </strong></h5></td>
                </tr>
                <tr>
                  <td>  </td>
                  <td>  </td> 
                  <td>  </td>
                  <td>  </td>
                  <td><h3>合計金額</h3></td>
                  <td class="text-right"><h3><strong><?php print number_format ($sail_total_price + $delivery_cost) ?>円</strong></h3></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <?php } ?>
      </div>
    </main>
  </body>
</html>