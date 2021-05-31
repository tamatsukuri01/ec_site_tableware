<?php
//設定ファイル読み込み
require_once '../conf/setting.php';
//関数ファイル読み込み
require_once MODEL_PATH . 'db.php';
require_once MODEL_PATH.'function.php';
require_once MODEL_PATH.'validate_model.php';

session_start();

if(is_logined() === true) {
  redirect_to(TOP_URL);
} 
$dbh = get_db_connect();
$token = get_csrf_token();


include_once VIEW_PATH.'sign_up_view.php';
?>