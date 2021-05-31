<?php
//設定ファイル読み込み
require_once '../conf/setting.php';
//関数ファイル読み込み
require_once MODEL_PATH.'db.php';
require_once MODEL_PATH.'function.php';
require_once MODEL_PATH.'cart_model.php';
require_once MODEL_PATH.'validate_model.php';

session_start();

if(is_logined() === false) {
  redirect_to(LOGIN_URL);
} 

$dbh = get_db_connect();
$login_user = get_login_user($dbh);
$persent = get_user_persent($login_user['persent']);
$token = get_csrf_token();

$cart_items = get_user_cart($dbh, $login_user['user_id'], $login_user['staff_id']);

$sail_total_price = get_sale_total_price($cart_items, $persent);
$delivery_cost = get_delivery_cost($sail_total_price);

if(count($cart_items) === 0) {
  set_error('現在カートに商品が入っていません。');
} 

include_once VIEW_PATH.'cart_view.php';

?>