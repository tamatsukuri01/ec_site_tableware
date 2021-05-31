<?php
//設定ファイル読み込み
require_once '../conf/setting.php';
//関数ファイル読み込み
require_once MODEL_PATH . 'db.php';
require_once MODEL_PATH.'function.php';
require_once MODEL_PATH.'cart_model.php';
require_once MODEL_PATH.'user_model.php';
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
$end_users = get_end_users($dbh, $login_user['user_id']);

$end_user_id = get_post('end_user_id');

if($end_user_id === '') {
  $end_user_id = null;
}

if($end_user_id !== null) {
  if(update_cart_end_user($dbh, $end_user_id, $login_user['user_id'], $login_user['staff_id']) === false) {
    set_error('直送先の変更に失敗しました。');
  } else {
    set_message('直送先を変更しました。');
  }
} 

$delivery_address = get_delivery_address($dbh, $login_user['user_id'], $login_user['staff_id']);

$sail_total_price = get_sale_total_price($cart_items, $persent);
$delivery_cost = get_delivery_cost($sail_total_price);

include_once VIEW_PATH.'checkout_view.php';
?>