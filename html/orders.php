<?php
//設定ファイル読み込み
require_once '../conf/setting.php';
//関数ファイル読み込み
require_once MODEL_PATH.'db.php';
require_once MODEL_PATH.'user_model.php';
require_once MODEL_PATH.'order_model.php';
require_once MODEL_PATH.'function.php';
require_once MODEL_PATH.'validate_model.php';

session_start();
if(is_logined() === false) {
    redirect_to(LOGIN_URL);
}

$dbh = get_db_connect();
$login_user = get_login_user($dbh);
$token = get_csrf_token();

$staff_id = get_get('staff_id');

if($staff_id === '') {
  $staff_id = null;
}

if(is_admin($login_user)){
  $staffs =  get_staffs($dbh);
} else {
  $staffs =  get_staffs($dbh, $login_user['user_id']);
}

if(is_admin($login_user)){
  $orders = get_user_orders($dbh, null, $staff_id);
  if($orders === false) {
    set_error('購入履歴の取得に失敗しました');
  } 
} else {
  $orders = get_user_orders($dbh, $login_user['user_id'], $staff_id);
  if($orders === false) {
    set_error('購入履歴の取得に失敗しました');
  } else if(count($orders) === 0) {
    set_error('購入履歴が有りません');
  }
} 

include_once VIEW_PATH.'orders_view.php';
?>
