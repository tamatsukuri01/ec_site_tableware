<?php
//設定ファイル読み込み
require_once '../conf/setting.php';
//関数ファイル読み込み
require_once MODEL_PATH.'db.php';
require_once MODEL_PATH.'function.php';
require_once MODEL_PATH.'admin_model.php';
require_once MODEL_PATH.'item_model.php';
require_once MODEL_PATH.'validate_model.php';


session_start();

if(is_logined() === false)
{
  redirect_to(LOGIN_URL);
}

$dbh = get_db_connect();
$login_user = get_login_user($dbh);
$token = get_csrf_token();

if(is_admin($login_user) === false)
{
  redirect_to(LOGIN_URL);
}

$items = get_item_list($dbh, false);

include_once VIEW_PATH.'admin_view.php';
