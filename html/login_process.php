<?php
//設定ファイル読み込み
require_once '../conf/setting.php';
//関数ファイル読み込み
require_once MODEL_PATH.'db.php';
require_once MODEL_PATH.'function.php';
require_once MODEL_PATH.'user_model.php';
require_once MODEL_PATH.'validate_model.php';

session_start();

if(is_logined() === true) {
  redirect_to(TOP_URL);
}

$company_name = get_post('company_name');
$staff_name = get_post('staff_name');
$pass = get_post('pass');
$token = get_post('token');

$dbh = get_db_connect();
$user_data = login_as($dbh, $company_name, $staff_name, $pass);

if(is_valid_csrf_token($token)) {
  if($user_data === false) {
    set_error('入力情報が間違っています');
    redirect_to(LOGIN_URL);
  }
  if(is_admin($user_data) === true){
    redirect_to(ADMIN_URL);
  }
}

redirect_to(TOP_URL);
?>