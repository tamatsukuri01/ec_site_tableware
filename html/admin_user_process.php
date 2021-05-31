<?php
//設定ファイル読み込み
require_once '../conf/setting.php';
//関数ファイル読み込み
require_once MODEL_PATH.'db.php';
require_once MODEL_PATH.'function.php';
require_once MODEL_PATH.'user_model.php';
require_once MODEL_PATH.'admin_model.php';
require_once MODEL_PATH.'validate_model.php';

session_start();

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

$dbh = get_db_connect();
$login_user = get_login_user($dbh);

if(is_admin($login_user) === false){
  redirect_to(LOGIN_URL);
}

$user_id = get_post('user_id');
$persent = get_post('persent');
$token = get_post('token');

if(is_valid_csrf_token($token)) {
  if(is_valid_persent($persent) === true) {
    if(update_user_persent($dbh, $persent, $user_id) ===false) {
      set_error('掛け率の変更に失敗しました');
    } else {
      set_message('掛け率を変更しました');
    }   
  }
} else {
  set_error('不正な操作が行われました。');
}


redirect_to(ADMIN_USER_URL);