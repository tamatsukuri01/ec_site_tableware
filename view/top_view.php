<!DOCTYPE html>
<html lang="ja">
  <head>
    <title>トップページ</title>
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
            <div class="carousel slide my-4" id="carouselExampleIndicators" data-ride="carousel">
              <ol class="carousel-indicators">
                <li class="active" data-target="#carouselExampleIndicators" data-slide-to="0"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
              </ol>
              <div class="carousel-inner" role="listbox">
                <div class="carousel-item active"><img class="d-block img-fluid" src="/assets/img/syokki900×350.jpg" alt="First slide" /></div>
                <div class="carousel-item"><img class="d-block img-fluid" src="/assets/img/cafe.jpeg" alt="Second slide" /></div>
                <div class="carousel-item"><img class="d-block img-fluid" src="/assets/img/granping900×350.jpeg" alt="Third slide" /></div>
              </div>
              <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>

            <?php include VIEW_PATH .'templates/messages.php'; ?>
            <?php if(count($order_history_items) > 0) { ?>
            <h4>直近の購入商品</h4>
            <div class="row">
              <?php foreach($order_history_items as $order_history_item) {?>
              <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                  <img class="card-img-top" src="<?php print IMG_PATH.h( $order_history_item['img']); ?>" />
                  <div class="card-body">
                    <h4 class="card-title"><?php print h( $order_history_item['name']); ?></h4>
                    <h5>上代：<?php print number_format( h( $order_history_item['price'])); ?>円</h5>
                    <h5>下代：<?php print number_format(h( $order_history_item['price']) * $persent); ?>円</h5>
                    <form method="get" action="item_data.php">
                      <input type="submit" value="商品詳細" class="btn btn-primary">
                      <input type="hidden" name="item_id" value="<?php print h( $order_history_item['item_id']); ?>">
                    </form>
                  </div>
                  <div class="card-footer"> 
                    <?php if((int)h( $order_history_item['stock']) === 0) { ?>
                      <p><?php echo '欠品中' ?></p>
                    <?php } else { ?>
                      <form method="post" action="add_cart.php">
                        <div class="form-group row">
                          数量：<input type="number" name="amount" min="1" value="1" style="width:50px;">
                        </div>
                        <input type="submit" value="カートに入れる" class="btn btn-primary">
                        <input type="hidden" name="item_id" value="<?php print h( $order_history_item['item_id']); ?>">
                        <input type="hidden" name="token" value="<?php print $token; ?>">
                      </form>
                    <?php } ?>  
                  </div>
                </div>
              </div>
              <?php } ?>
            </div>
            <?php } ?>     
            <h4>新着商品</h4>
            <div class="row">
              <?php foreach($new_items as $new_item) {?>
              <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                  <img class="card-img-top" src="<?php print IMG_PATH.h($new_item['img']); ?>" />
                  <div class="card-body">
                    <h4 class="card-title"><?php print h($new_item['name']); ?></h4>
                    <h5>上代：<?php print number_format( h($new_item['price'])); ?>円</h5>
                    <h5>下代：<?php print number_format(h($new_item['price']) * $persent); ?>円</h5>
                    <form method="get" action="item_data.php">
                      <input type="submit" value="商品詳細" class="btn btn-primary">
                      <input type="hidden" name="item_id" value="<?php print h($new_item['item_id']); ?>">
                    </form>
                  </div>
                  <div class="card-footer"> 
                    <?php if((int)h($new_item['stock']) === 0) { ?>
                      <p><?php echo '欠品中' ?></p>
                    <?php } else { ?>
                      <form method="post" action="add_cart.php">
                        <div class="form-group row">
                          数量：<input type="number" name="amount" min="1" value="1" style="width:50px;">
                        </div>
                        <input type="submit" value="カートに入れる" class="btn btn-primary">
                        <input type="hidden" name="item_id" value="<?php print h($new_item['item_id']); ?>">
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