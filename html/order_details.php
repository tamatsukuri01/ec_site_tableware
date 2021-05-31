<?php
//設定ファイル読み込み
require_once '../conf/setting.php';
//関数ファイル読み込み
require_once MODEL_PATH.'db.php';
require_once MODEL_PATH.'order_model.php';
require_once MODEL_PATH.'function.php';
require_once MODEL_PATH.'validate_model.php';

session_start();

if(is_logined() === false) {
  redirect_to(LOGIN_URL);
} 

$dbh = get_db_connect();
$login_user = get_login_user($dbh);

$order_number = get_post('order_number');
$user_id = get_post('user_id');
$staff_id = get_post('staff_id');
$token = get_post('token');

if(empty($order_number)) {
  redirect_to(ORDERS_URL);
}

if(is_valid_csrf_token($token)) {
  if(is_admin($login_user)) {
    $records = get_user_order_records($dbh, $order_number);
    if($records === false) {
        set_error('購入履歴の取得に失敗しました。');
    }
  } else {
    $records = get_user_order_records($dbh, $order_number, $user_id, $staff_id);
    if($records === false) {
        set_error('購入履歴の取得に失敗しました。');
    }
  }
} else {
  set_error('不正な操作が行われました。');
}

if(is_valid_csrf_token($token)) {
  if(is_admin($login_user)){
    $details = get_user_order_details($dbh, $order_number);
    if($details === false) {
      set_error('購入明細の取得に失敗しました。');
    }
  } else {
    $details = get_user_order_details($dbh, $order_number, $user_id, $staff_id);
    if($details === false) {
      set_error('購入明細の取得に失敗しました。');
    }
  }
}

include_once VIEW_PATH.'order_details_view.php';
?>