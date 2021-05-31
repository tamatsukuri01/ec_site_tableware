<!DOCTYPE html>
<html lang="ja">
  <head>
    <title>商品一覧</title>
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
            <?php include VIEW_PATH .'templates/messages.php'; ?>   
            <div class="row">
              <form action="<?php print (ITEM_LIST_URL) ?>" method="get" onchange="submit(this.form);">
                <?php include VIEW_PATH .'templates/sort.php'; ?>
              </form>
            </div>
            <h4>商品一覧</h4>
            <div class="row">
              <?php foreach($items as $item) {?>
              <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                  <img class="card-img-top" src="<?php print IMG_PATH.h($item['img']); ?>" />
                  <div class="card-body">
                    <h4 class="card-title"><?php print h($item['name']); ?></h4>
                    <h5>上代：<?php print number_format( h($item['price'])); ?>円</h5>
                    <h5>下代：<?php print number_format(h($item['price']) * $persent); ?>円</h5>
                    <form method="get" action="<?php print (ITEM_DATA_URL) ?>">
                      <input type="submit" value="商品詳細" class="btn btn-primary">
                      <input type="hidden" name="item_id" value="<?php print h($item['item_id']); ?>">
                    </form>
                  </div>
                  <div class="card-footer"> 
                    <?php if((int)h($item['stock']) === 0) { ?>
                      <p><?php echo '欠品中' ?></p>
                    <?php } else { ?>
                      <form method="post" action="add_cart.php">
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
              <?php } ?>
            </div> 
          </div> 
        </div>
      </div>
    </main>
  </body>
</html>