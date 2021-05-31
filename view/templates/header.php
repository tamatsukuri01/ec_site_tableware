<header>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="<?php print(TOP_URL) ?>">TABLE WARE SHOP</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item" >
              <a class="nav-link <?php if($_SERVER['REQUEST_URI'] === TOP_URL) {echo "active";} ?>" href="<?php print(TOP_URL) ?>">ホーム</a>
          </li>
          <li class="nav-item" >
              <a class="nav-link <?php if($_SERVER['REQUEST_URI'] === ITEM_LIST_URL) {echo "active";} ?>" href="<?php print(ITEM_LIST_URL) ?>">商品一覧</a>
          </li>
          <li class="nav-item" >
              <a class="nav-link <?php if($_SERVER['REQUEST_URI'] === RANKING_URL) {echo "active";} ?>" href="<?php print(RANKING_URL) ?>">ランキング</a>
          </li>
          <li class="nav-item">
              <a class="nav-link <?php if($_SERVER['REQUEST_URI'] === CART_URL) {echo "active";} ?>" href="<?php print(CART_URL) ?>">カート</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle <?php if($_SERVER['REQUEST_URI'] === MY_PAGE_URL) {echo "active";} ?>" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              マイページ
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="<?php print(MY_PAGE_URL) ?>">登録情報</a></li>
              <li><a class="dropdown-item" href="<?php print(ORDERS_URL) ?>">購入履歴</a></li>
            </ul>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="<?php print(LOGOUT_URL) ?>">ログアウト</a>
          </li>
          <?php if(is_admin($login_user)) { ?>
          <li class="nav-item">
              <a class="nav-link <?php if($_SERVER['REQUEST_URI'] === ADMIN_URL) {echo "active";} ?>" href="<?php print(ADMIN_URL) ?>">商品管理</a>
          </li>
          <?php } ?>
        </ul>
      </div>
      <div class="nav-item text-white font-weight-bold">
        <?php print h($_SESSION['company_name']); ?>
        <?php print h($_SESSION['staff_name']); ?>様
      </div>
    </div>
  </nav>
</header>