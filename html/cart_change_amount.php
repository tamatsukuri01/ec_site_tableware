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

$item_id = get_post('item_id');
$amount = get_post('amount');
$token = get_post('token');

if(is_valid_csrf_token($token)) { 
  if(update_cart($dbh, $amount, $item_id, $login_user['user_id'], $login_user['staff_id']) === false) {
    set_error('数量の変更に失敗しました。');
  } else {
    set_message('数量が変更されました。');
  }
}else {
  set_error('不正な操作が行われました。');
}

redirect_to(CART_URL);
?>