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

if(is_admin($login_user) === false)
{
  redirect_to(LOGIN_URL);
}

$item_name = get_post('name');
$price = get_post('price');
$stock = get_post('stock');
$status = get_post('status');
$item_type = get_post('item_type');
$item_id = get_post('item_id');
$pickup = get_post('pickup');
$comment = get_post('comment');
$item_img = get_file('img');
$token = get_post('token');

$sql_kind = get_post('sql_kind');

if(is_valid_csrf_token($token)) {
  if($sql_kind === 'insert_item') {
    //商品登録
    if(regist_item($dbh, $item_name, $price, $stock, $item_img,
      $status, $item_type, $pickup, $comment) === false) {
        set_error('商品登録に失敗しました。');
    }
    //----在庫の更新----   
  } else if($sql_kind === 'update_stock') {
    if(update_stock($dbh, $stock, $item_id) === false){
      set_error('在庫数の更新に失敗しました。');
    } 
  //価格変更処理      
  } else if($sql_kind === 'update_price') {
    if(update_price($dbh, $price, $item_id) === false) {
      set_error('価格の更新に失敗しました。');
    }
  //---ステータス変更処理---    
  } else if($sql_kind === 'update_status') {
    if(update_status($dbh, $status, $item_id) === false) {
      set_error('商品のステータス更新に失敗しました');
    }
  //---データ削除処理---    
  } else if($sql_kind === 'delete_item') {
    if(delete_item($dbh, $item_id) ===false) {
      set_error('商品データの削除に失敗しました。');
    }
  //---商品説明変更---     
  } else if($sql_kind === 'update_comment') {
    if(update_comment($dbh, $comment, $item_id) === false) {
      set_error('商品説明の更新に失敗しました。');
    }
  //---特集変更---    
  } else if($sql_kind === 'update_pickup') {
    if(update_pickup($dbh, $pickup, $item_id) ===false) {
      set_error('商品特集の更新に失敗しました。');
    } 
  }
} else {
  set_error('不正な操作が行われました。');
}

redirect_to(ADMIN_URL);
