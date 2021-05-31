<!doctype html>
<html lang="ja">
	<head>
		<title>購入手続き</title>
		<?php include VIEW_PATH .'templates/head.php'; ?>
    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
	</head>
      <?php include VIEW_PATH .'templates/header.php'; ?>
  <body class="bg-light">
    <main>
      <?php include VIEW_PATH .'templates/messages.php'; ?>
      <div class="container">
        <div class="row g-3">
          <div class="col-md-5 order-md-last">
            <table class="table">
              <h3>カート</h3>
              <thead class="thead-dark">
                  <tr>
                  <th class="text-center">商品名</th>
                  <th class="text-center">数量</th>
                  <th class="text-center">下代</th>
                  <th class="text-center">合計</th>
                  </tr>
              </thead>
              <tbody>
                <?php foreach($cart_items as $cart_item) { ?>
                <tr>
                  <td class=" text-center">
                      <h6><?php print h($cart_item['name']); ?></h6>
                  </td>
                  <td class=" text-center">
                      <h6><?php print h($cart_item['amount']); ?>個</h6>
                  </td>
                  <td class=" text-center">
                      <h6><?php print number_format(h($cart_item['price']) * $persent); ?>円</h6>
                  </td>
                  <td class=" text-center">
                      <h6><?php print number_format (h(($cart_item['price']) * $persent) * h($cart_item['amount'])); ?>円</h6>
                  </td>
                </tr>
                <?php } ?>
                <tr>
                  <td></td>
                  <td></td>
                  <td><h6>小計</h6></td>
                  <td class="text-right">
                      <h6><strong><?php print number_format ($sail_total_price) ?>円</strong></h6>
                  </td>
                </tr>
                <tr>
                  <td></td>
                  <td></td>
                  <td><h6>送料</h6></td>
                  <td class="text-right"><h6><strong><?php print number_format($delivery_cost)  ?></strong></h6></td>
                </tr>
                <tr> 
                  <td></td>
                  <td></td>
                  <td><h5>合計金額</h5></td>    
                  <td class="text-right">
                    <h5><strong><?php print number_format ($sail_total_price + $delivery_cost) ?>円</strong></h5>
                  </td>
                </tr>
              </tbody>
            </table>
              <a href="cart.php" type="button" class="w-100 btn btn-secondary btn-lg">カートに戻る</a>
          </div>

          <div class="col-md-7">
            <h4 class="mb-3">送り先</h4>
            <div class="col-12">
              <form method="post" action="checkout.php">
                <label for="username" class="form-label">送り先</label>
                <select class="form-select" name="end_user_id">
                    <option value=0>直送先を選択</option>
                  <?php foreach($end_users as $end_user) { ?>
                    <option  value="<?php print h($end_user['end_user_id']); ?>"<?php if(isset($end_user_id) && (int)$end_user_id === $end_user['end_user_id'] ){echo 'selected';} ?>>
                    <?php print h($end_user['end_user_name']); ?></option>
                  <?php } ?>
                </select>
                <input class=" btn btn-primary" type="submit" value="送り先を変更する">
              </form>
            </div>
            <div class="col-md-7">
              <label for="name " class="form-label">送り先名:</label>
              <input disabled type="text" class="form-control" id="name " value="<?php print h($delivery_address['end_user_name']); ?>" >
            </div>
            <div class="col-md-7">
              <label for="post_code" class="form-label">郵便番号</label>
              <input disabled type="text" class="form-control" id="post_code" value="<?php print h($delivery_address['end_user_post_code']); ?>" >
            </div>
            <div class="col-me-7">
              <label for="address" class="form-label">送り先住所</label>
              <input disabled type="text" class="form-control" id="address" value="<?php print h($delivery_address['end_user_address']); ?>">
            </div>
            <div class="col-md-7">
              <label for="tell" class="form-label">電話番号</label>
              <input disabled type="text" class="form-control" id="tell" value="<?php print h($delivery_address['end_user_tell']); ?>">
            </div>
            <form method="post" action="finish.php">
              <input <?php if($delivery_address['end_user_id'] === null ){echo 'disabled';} ?> class="finish btn btn-primary btn-lg" type="submit" value=購入確定する>
              <input type="hidden" name="token" value="<?php print $token; ?>">
            </form>
              <p><?php if($delivery_address['end_user_id'] === null ) {echo 'お届け先を指定して下さい';} ?></p>
          </div>
        </div>
      </div>
    </main>
    <script>
      $('.finish').on('click', () => confirm('購入を確定してもよろしいでしょうか？'))
    </script>
  </body>
</html>
