<?php
//設定ファイル読み込み
require_once '../conf/setting.php';
//関数ファイル読み込み
require_once MODEL_PATH.'db.php';
require_once MODEL_PATH.'function.php';
require_once MODEL_PATH.'cart_model.php';
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

$category_id = get_get('category_id');

$category_id = empty($category_id) ? $categories[0]['item_type'] : $category_id;

$sort = get_get('sort');

$items = get_item_list($dbh, true, $sort, $category_id);

include_once VIEW_PATH.'category_view.php';
