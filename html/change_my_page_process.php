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

$sql_kind = get_post('sql_kind');
$company_name = get_post('company_name');
$user_name = get_post('user_name');
$user_mail = get_post('user_mail');
$user_tell = get_post('user_tell');
$post_code = get_post('post_code');
$address = get_post('address');
$staff_name = get_post('staff_name');
$staff_mail = get_post('staff_mail');
$staff_tell = get_post('staff_tell');

$token = get_post('token');

if(is_valid_csrf_token($token)) {
  if($sql_kind === 'change_my_page') {
    $result = update_my_page($dbh, $company_name, $user_name, $post_code, $address, $user_tell, $user_mail, $login_user['user_id']);
    if($result === false) {
      set_error('会員情報更新に失敗しました。<br>お手数ですが管理者までご連絡ください。');
    } else {
      set_message('会員情報が更新されました。');
    }
    redirect_to(CHANGE_MY_PAGE_URL);
  } else if($sql_kind === 'register_staff') {
    $result = regist_staff($dbh, $login_user['user_id'], $staff_name, $staff_mail, $staff_tell);
    if($result === false) {
      set_error('社員の登録に失敗しました。<br>お手数ですが管理者までご連絡ください。');
    } else {
      set_message('社員の登録が完了しました。');
    }
    redirect_to(CHANGE_MY_PAGE_URL);
  }
} else {
  set_error('不正な操作が行われました。');
}
redirect_to(CHANGE_MY_PAGE_URL);
?>
