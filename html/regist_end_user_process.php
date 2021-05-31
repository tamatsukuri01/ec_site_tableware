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

$token = get_post('token');
$end_user_name = get_post('end_user_name');
$end_user_post_code = get_post('end_user_post_code');
$end_user_address = get_post('end_user_address');
$end_user_tell = get_post('end_user_tell');

if(is_valid_csrf_token($token)) {
  $result = regist_end_users($dbh, $login_user['user_id'], $end_user_name, $end_user_post_code, $end_user_address, $end_user_tell);
  if($result === false) {
    set_error('届け先登録に失敗しました。');
  } else {
    set_message('届け先登録が完了しました。');
  }
} else {
  set_error('不正な操作が行われました。');
}

redirect_to(REGIST_END_USER_URL);
?>