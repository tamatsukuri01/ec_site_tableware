<?php
//設定ファイル読み込み
require_once '../conf/setting.php';
//関数ファイル読み込み
require_once MODEL_PATH.'db.php';
require_once MODEL_PATH.'user_model.php';
require_once MODEL_PATH.'function.php';
require_once MODEL_PATH.'validate_model.php';

session_start();

if(is_logined() === false) {
  redirect_to(LOGIN_URL);
} 

$dbh = get_db_connect();
$login_user = get_login_user($dbh);

$user_info = get_user_info($dbh, $login_user['user_id']);

$staffs = get_staffs($dbh, $login_user['user_id']);

include_once VIEW_PATH.'my_page_view.php';
?>
