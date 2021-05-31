<?php
//設定ファイル読み込み
require_once '../conf/setting.php';
//関数ファイル読み込み
require_once MODEL_PATH.'db.php';
require_once MODEL_PATH.'function.php';
require_once MODEL_PATH.'cart_model.php';
require_once MODEL_PATH.'item_model.php';
require_once MODEL_PATH.'user_model.php';
require_once MODEL_PATH.'order_model.php';
require_once MODEL_PATH.'validate_model.php';

session_start();

if(is_logined() === false) {
  redirect_to(LOGIN_URL);
} 

$dbh = get_db_connect();
$login_user = get_login_user($dbh);
$persent = get_user_persent($login_user['persent']);
$token = get_post('token');

$cart_items = get_user_cart($dbh, $login_user['user_id'], $login_user['staff_id']);
$delivery_address = get_delivery_address($dbh, $login_user['user_id'], $login_user['staff_id']);

$sail_total_price = get_sale_total_price($cart_items, $persent);
$delivery_cost = get_delivery_cost($sail_total_price);

if(is_valid_csrf_token($token)) {
  if(purchase_carts($dbh, $cart_items, $persent) === true) {
    set_message('ご購入ありがとうございました。');
  } else {
    redirect_to(CART_URL);
  }
} else {
  set_error('不正な操作が行われました。');
}

include_once VIEW_PATH.'finish_view.php';