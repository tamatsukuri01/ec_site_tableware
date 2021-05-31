<?php

//商品登録エラーチェック
function validate_item($item_name, $price, $stock, $status,$item_type, $filename) 
{
  $is_valid_item_name = is_valid_item_name($item_name);
  $is_valid_item_price = is_valid_item_price($price);
  $is_valid_item_stock = is_valid_item_stock($stock);
  $is_valid_item_type = is_valid_item_type($item_type);
  $is_valid_item_status = is_valid_item_status($status);
  $is_valid_item_filename = is_valid_item_filename($filename);

  return $is_valid_item_name 
  && $is_valid_item_price 
  && $is_valid_item_stock 
  && $is_valid_item_type 
  && $is_valid_item_status 
  && $is_valid_item_filename;
}

//商品名エラーチェック
function is_valid_item_name($item_name) 
{
  $item_name = trim_space($item_name);
  $is_valid = true;
  if($item_name === '') {
    set_error('商品名を入力して下さい');
    $is_valid = false;
  }
  return $is_valid;
}

//商品価格エラーチェック
function is_valid_item_price($price) 
{
  $price = trim_space($price);
  $is_valid = true;
  if(is_positive_integer($price) === false ) {
    set_error('値段は0以上の整数で入力して下さい');
    $is_valid = false;
  }
  return $is_valid;
}

//商品在庫エラーチェック
function is_valid_item_stock($stock) 
{
  $stock = trim_space($stock);
  $is_valid = true;
  if(is_positive_integer($stock) === false ) {
    set_error('在庫数は0以上の整数で入力して下さい');
    $is_valid = false; 
  }
  return $is_valid;
}

//商品ステータスエラーチェック
function is_valid_item_status($status) 
{
  $status = trim_space($status);
  $is_valid = true;
  if(preg_match('/\A[0-1]\z/',$status) !==1 ) {
    set_error('不正なステータス値です');
    $is_valid = false;
  }
  return $is_valid;
}

//アイテムタイプのエラーチェック
function is_valid_item_type($item_type) 
{
  $is_valid = true;
  if($item_type === '') {
    set_error('商品の種類を選択して下さい');
  $is_valid = false;        
  }
  return $is_valid;
}

//不正なアイテムIDが送られてないかチェック
function is_valid_item_id($item_id)
{
  $is_valid = true;
  if (is_positive_integer($item_id) === false) {
    set_error('不正な操作が行われました。');
    $is_valid = false;
  }
  return $is_valid;
}

//商品画像エラーチェック
function is_valid_item_filename($filename) 
{
  $is_valid = true;
  if($filename === '') {
    $is_valid = false;
  }
  return $is_valid;
}

//数量のエラーチェック
function is_valid_amount($amount) 
{
  $is_valid = true;
  if(is_positive_integer($amount) === false) {
    set_error('数量は整数で入力して下さい。') ;
    $is_valid = false;
  }
  return $is_valid;
}

//掛け率エラーチェック
function is_valid_persent($persent) 
{
  $is_valid = true;
  if(is_positive_integer($persent) === false) {
    set_error('掛け率は0以上の整数で入力してください。');
    $is_valid = false;
  }
  return $is_valid;
}

//オーダーナンバーのエラーチェック
function is_valid_order_number($order_number) 
{
  $is_valid = true;
  if(is_positive_integer($order_number) === false){
    set_error('不正な操作が行われました。');
    $is_valid = false;
  }
  return $is_valid;
}

//会社登録エラーチェック
function is_valid_company($user_name, $post_code, $address, $user_tell, $user_mail) 
{
  $is_valid_name = is_valid_name($user_name);
  $is_valid_post_code = is_valid_post_code($post_code);
  $is_valid_address = is_valid_address($address);
  $is_valid_phone_number = is_valid_phone_number($user_tell);
  $is_valid_email = is_valid_email($user_mail);
  
  return $is_valid_name 
    && $is_valid_post_code
    && $is_valid_address
    && $is_valid_phone_number 
    && $is_valid_email;
}

//社員登録エラーチェック
function is_valid_staff($staff_name, $staff_mail, $staff_tell) 
{
  $is_valid_name = is_valid_name($staff_name);
  $is_valid_email = is_valid_email($staff_mail);
  $is_valid_phone_number = is_valid_phone_number($staff_tell);

  return $is_valid_name
  && $is_valid_email
  && $is_valid_phone_number;
}

//届け先登録エラーチェック
function is_valid_end_user($end_user_post_code, $end_user_address, $end_user_tell)
{
  $is_valid_post_code = is_valid_post_code($end_user_post_code);
  $is_valid_address = is_valid_address($end_user_address);
  $is_valid_phone_number = is_valid_phone_number($end_user_tell);

  return $is_valid_post_code
  && $is_valid_address
  && $is_valid_phone_number;
}

//ユーザー名エラーチェック
function is_valid_name($user_name)
{
  $is_valid = true;
  if (is_valid_length($user_name, NAME_LENGTH_MIN, NAME_LENGTH_MAX) === false) {
    set_error('名前は'.NAME_LENGTH_MIN.'文字以上'.NAME_LENGTH_MAX.'文字以内で入力して下さい。');
    $is_valid = false;
  }
  return $is_valid;
}

//パスワードエラーチェック
function is_valid_password($pass)
{
  $is_valid = true;
  if (is_valid_length($pass, USER_PASSWORD_LENGTH_MIN, USER_PASSWORD_LENGTH_MAX) === false) {
    set_error('パスワードは'.USER_PASSWORD_LENGTH_MIN.'文字以上'.USER_PASSWORD_LENGTH_MAX.'文字以内で入力して下さい。');
    $is_valid = false;
  }
  if(is_alphanumeric($pass) === false) {
    set_error('パスワードは半角英数字で入力して下さい。');
    $is_valid = false;
  }
  return $is_valid;
}

//電話番号エラーチェック
function is_valid_phone_number($phone_number)
{
  $is_valid = true;
  if(is_phone_number($phone_number) === false) {
    set_error('正しくない電話番号の形式です。') ;
    $is_valid = false;
  }
  return $is_valid;
}

//メールアドレスエラーチェック
function is_valid_email($email)
{
  $is_valid = true;
  if (is_email($email) === false) {
    set_error('正しくないメールアドレスの形式です。');
    $is_valid = false;
  }
  return $is_valid;
}

//郵便番号のエラーチェック
function is_valid_post_code($post_code) 
{
  $is_valid = true;
  if(is_post_code($post_code) === false) {
    set_error('正しくない郵便番号の形式です。');
    $is_valid = false;
  }
  return $is_valid;
}
//住所のエラーチェック
function is_valid_address($address) 
{
  $is_valid = true;
  if($address === '') {
    set_error('住所を入力して下さい。');
    $is_valid = false;
  }
  return $is_valid;
}

//すでに存在する会社名かチェック
function check_exist_company_name($dbh, $company_name) 
{
  $is_check = true;
  if(get_company_name($dbh, $company_name) !== false) {
    set_error('すでに御社名で登録がお済みのようです。');
    $is_check = false;
  }
  return $is_check;
}
