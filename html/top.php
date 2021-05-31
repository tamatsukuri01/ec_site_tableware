<?php
//設定ファイル読み込み
require_once '../conf/setting.php';
//関数ファイル読み込み
require_once MODEL_PATH.'db.php';
require_once MODEL_PATH.'item_model.php';
require_once MODEL_PATH.'function.php';
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

$new_items = get_new_items($dbh);

$order_history_items = get_orders_items($dbh, $login_user['user_id'], $login_user['staff_id']);

include_once VIEW_PATH.'top_view.php';
