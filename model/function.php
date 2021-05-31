<?php
require_once MODEL_PATH . 'db.php';
//リダイレクト処理関数
function redirect_to($url)
{
  header('Location: ' . $url);
  exit;
}

//セッションを取得
function get_session($name)
{
  if (isset($_SESSION[$name]) === true) {
    return $_SESSION[$name];
  };
  return '';
}

//セッションをセット
function set_session($name, $value)
{
  $_SESSION[$name] = $value;
}

//ログインユーザー情報取得
function get_login_user($dbh)
{
  $login_user_id = get_session('user_id');
  $login_staff_id = get_session('staff_id');

  return get_company_staff_id($dbh, $login_user_id, $login_staff_id);
}

//ユーザーIDとスタッフIDが一致するユーザー情報取得
function get_company_staff_id($dbh, $user_id, $staff_id)
{
  $sql = '
  SELECT 
    users.user_id ,
    users.company_name ,
    users.user_name ,
    users.post_code ,
    users.address ,
    users.tell ,
    users.password ,
    staffs.staff_name ,
    staffs.staff_id ,
    user_type ,
    persent
  FROM 
    users
  INNER JOIN
    staffs
  ON
    staffs.user_id = users.user_id
  WHERE 
    users.user_id = ?
  AND
    staffs.staff_id = ?
  LIMIT 1';

  return fetch_query($dbh, $sql, [$user_id, $staff_id]);
}

//ログインチェック関数
function is_logined()
{
  if (isset($_SESSION['user_id'])) {
    return  true;
  }
  return false;
}

//管理者かチェック
function is_admin($user)
{
  return $user['user_type'] === 'admin';
}

//エラーメッセージセット
function set_error($error)
{
  $_SESSION['__errors'][] = $error;
}

//エラーメッセージ取得
function get_errors()
{
  $errors = get_session('__errors');
  if ($errors === '') {
    return array();
  }
  set_session('__errors', array());
  return $errors;
}

//セッションにエラーメッセージが入っていないかチェック
function has_error()
{
  return isset($_SESSION['__errors']) && count($_SESSION['__errors']) !== 0;
}

//メッセージセット
function set_message($message)
{
  $_SESSION['__messages'][] = $message;
}

//メッセージ取得
function get_messages()
{
  $messages = get_session('__messages');
  if ($messages === '') {
    return array();
  }
  set_session('__messages', array());
  return $messages;
}

//ポストデータ受け取り
function get_post($name)
{
  if (isset($_POST[$name]) === TRUE) {
    return $_POST[$name];
  }
  return '';
}

//ゲットデータ受け取り
function get_get($name)
{
  if (isset($_GET[$name]) === TRUE) {
    return $_GET[$name];
  }
  return '';
}

//ファイル取得
function get_file($name)
{
  if (isset($_FILES[$name]) === TRUE) {
    return $_FILES[$name];
  }
  return '';
}

//特殊文字変換
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

//カート内の合計金額取得
function get_total_price($cart_items)
{
  $total_price = 0;
  foreach ($cart_items as $cart_item) {
    $total_price += $cart_item['price'] * $cart_item['amount'];
  }
  return $total_price;
}

//下代合計金額
function get_sale_total_price($cart_items, $persent) {
  $total_price = 0;
  foreach ($cart_items as $cart_item) {
    $total_price += ($cart_item['price'] * $persent) * $cart_item['amount'];
  }
  return $total_price;
}

//掛け率取得関数
function get_user_persent($persent) {
  return $persent /100;
}

//送料算出関数
function get_delivery_cost($sail_total_price) {
  $delivery_cost = 0;
  if($sail_total_price < 10000) {
    $delivery_cost = 800;
  }
  return $delivery_cost;
}

//前後の空白削除
function trim_space($str) {
  return trim($str);
}

//文字数のバリデーション
function is_valid_length($string, $minimum_length, $maximum_length = PHP_INT_MAX){
  $length = mb_strlen($string);
  return ($minimum_length <= $length) && ($length <= $maximum_length);
}

//0以上の整数かバリデーション
function is_positive_integer($string) {
  return is_valid_format($string, REGEXP_POSITIVE_INTEGER);
}

//半角英数字かバリデーション
function is_alphanumeric($string){
  return is_valid_format($string, REGEXP_ALPHANUMERIC);
}

//正しいメールアドレスかバリデーション
function is_email($string) {
  return is_valid_format($string, REGEXP_EMAIL_ADDRESS);
}

//電話番号のバリデーション
function is_phone_number($string) {
  return is_valid_format($string, REGEXP_PHONE_NUMBER);
}

//郵便番号のバリデーション
function is_post_code($string) {
  return is_valid_format($string, REGEXP_PHOST_CODE);
}

//バリデーションフォーマット
function is_valid_format($string, $format) {
  return preg_match($format, $string) === 1;
}

function get_random_string($length = 20){
  return substr(base_convert(hash('sha256', uniqid()), 16, 36), 0, $length);
}
// トークンの生成
function get_csrf_token()
{
  $token = get_random_string(30);
  set_session('csrf_token', $token);
  return $token;
}

// トークンのチェック
function is_valid_csrf_token($token)
{
  if($token === '') {
    return false;
  }
  return $token === get_session('csrf_token');
}