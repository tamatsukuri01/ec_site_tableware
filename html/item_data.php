<?php
//設定ファイル読み込み
require_once '../conf/setting.php';
//関数ファイル読み込み
require_once MODEL_PATH.'db.php';
require_once MODEL_PATH.'function.php';
require_once MODEL_PATH.'item_model.php';
require_once MODEL_PATH.'validate_model.php';

session_start();

if(is_logined() === false) {
  redirect_to(LOGIN_URL);
} 

$dbh = get_db_connect();
$login_user = get_login_user($dbh);
$persent = get_user_persent($login_user['persent']);
$token = get_csrf_token();

$categories = get_categories($dbh);

$item_id = get_get('item_id');

if(is_valid_item_id($item_id)) {
  $item = get_item($dbh, $item_id, true);
  if($item === false) {
    set_error('商品データの取得に失敗しました');
  }
}   

include_once VIEW_PATH.'item_data_view.php';
?>
