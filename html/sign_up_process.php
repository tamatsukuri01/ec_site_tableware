<?php
//設定ファイル読み込み
require_once '../conf/setting.php';
//関数ファイル読み込み
require_once MODEL_PATH . 'db.php';
require_once MODEL_PATH.'function.php';
require_once MODEL_PATH.'user_model.php';
require_once MODEL_PATH.'validate_model.php';

session_start();

if(is_logined() === true) {
  redirect_to(TOP_URL);
} 
$dbh = get_db_connect();

$company_name = get_post('company_name');
$user_name = get_post('user_name');
$pass = get_post('pass');
$user_mail = get_post('user_mail');
$user_tell = get_post('user_tell');
$post_code = get_post('post_code');
$address = get_post('address');
$token = get_post('token');
$user_type = 'user';

if(is_valid_csrf_token($token)) {
  $result = regist_company($dbh, $company_name, $user_name, $post_code, $address, $user_tell, $pass, $user_mail, $user_type);
  if($result === true) {
    set_message('会員登録が完了しました。<br>後日営業担当よりご連絡致します。');
  } 
} else {
  set_error('不正な操作が行われました。');
}

redirect_to(SIGN_UP_URL);
?>