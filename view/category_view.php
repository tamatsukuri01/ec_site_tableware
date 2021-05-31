<!DOCTYPE html>
<html lang="ja">
  <head>
      <title>トップページ</title>
      <?php include VIEW_PATH .'templates/head.php'; ?>
      <link rel="stylesheet" href="<?php print(STYLESHHET_PATH. 'top.css'); ?>">
  </head>
  <body>
    <?php include VIEW_PATH .'templates/header.php'; ?>
    <main>
      <div class="container">
        <div class="row">
          <div class="col-lg-3">
            <h2 class="my-4">Categories</h2>
            <div class="list-group">
              <?php foreach($categories as $category) {?>
                <a class="list-group-item list-group-item-action <?php if(isset($category_id) && $category_id === $category['item_type']){echo 'active';} ?>" 
                  href="category.php?category_id=<?php print h($category['item_type']); ?>&sort=<?php print h($sort); ?>">
                  <?php print h($category['item_type']); ?>
                </a>
              <?php } ?>
            </div>
          </div>

          <div class="col-lg-9">
            <?php include VIEW_PATH .'templates/messages.php'; ?>
            <div class="row">
              <form action="category.php" method="get" onchange="submit(this.form);">
                <select name="sort">
                  <option value="new" <?php if((isset($sort)) && $sort === "new") {echo 'selected' ;} ?>>新着順</option>
                  <option value="cheap" <?php if((isset($sort)) && $sort === "cheap") {echo 'selected' ;} ?>>価格が安い順</option>
                  <option value="high" <?php if((isset($sort)) && $sort === "high") {echo 'selected' ;} ?>>価格が高い順</option>
                </select>
                <input type="hidden" name="category_id" value="<?php print h($category_id); ?>">
              </form>
            </div>
            <div class="row">
              <?php foreach($items as $item) {?>
              <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                    <img class="card-img-top" src="<?php print IMG_PATH.h($item['img']); ?>" />
                  <div class="card-body">
                    <h4 class="card-title"><?php print h($item['name']); ?></h4>
                    <h5>上代：<?php print number_format( h($item['price'])); ?>円</h5>
                    <h5>下代：<?php print number_format(h($item['price']) * $persent); ?>円</h5>
                    <form method="get" action="/item_data.php">
                      <input type="submit" value="商品詳細" class="btn btn-primary">
                      <input type="hidden" name="item_id" value="<?php print h($item['item_id']); ?>">
                    </form>
                  </div>
                  <div class="card-footer"> 
                    <?php if((int)h($item['stock']) === 0) { ?>
                      <p><?php echo '売り切れ' ?></p>
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