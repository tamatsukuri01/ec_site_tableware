<!DOCTYPE html>
<html lang="ja">
  <head>
      <title>商品詳細</title>
      <?php include VIEW_PATH .'templates/head.php'; ?>
      <link rel="stylesheet" href="/assets/css/top.css">
  </head>
  <body>
    <?php include VIEW_PATH .'templates/header.php'; ?>
    <main>
      <div class="container">
        <div class="row">
          <div class="col-lg-3">
            <?php include VIEW_PATH .'templates/categories.php'; ?>
          </div>
          <div class="col-lg-9">
            <div class="card mt-4">
                <img class="card-img-top img-fluid" style="width:450px; height: 450px;" src="<?php print IMG_PATH.h($item['img']); ?>" />
              <div class="card-body">
                <h3 class="card-title"><?php print h($item['name']); ?></h3>
                <h4>上代：<?php print number_format(h($item['price']));  ?></h4>
                <h4>下代：<?php print number_format(h($item['price']) * $persent) ; ?></h4>
                <h4>現在個数：<?php if((int)h($item['stock']) === 0)
                    {echo '欠品中'; }
                  else if($item['stock'] <= 20) {
                    echo '20個以下です。詳しくはお問い合わせください。';} 
                  else if($item['stock'] >= 200) 
                    { echo '200個以上あります。';}
                  else { print h($item['stock']);} ?></h4>
                <p class="card-text"><?php print h($item['comment']); ?></p>
              </div>
              <div class="card-footer"> 
                <?php if((int)h($item['stock']) === 0) { ?>
                  <p><?php echo '欠品中' ?></p>
                <?php } else { ?>
                  <form method="post" action="<?php print (ADD_CART_URL) ?>">
                    <div class="form-group row">
                        数量：<input type="number" name="amount" min="1" value="1" style="width:50px;">
                    </div>
                    <input type="submit" value="カートに入れる" class="btn btn-primary">
                    <input type="hidden" name="item_id" value="<?php print h($item['item_id']); ?>">
                    <input type="hidden" name="token" value="<?php print $token; ?>">
                  </form>
                <?php } ?>  
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </body>
</html> 