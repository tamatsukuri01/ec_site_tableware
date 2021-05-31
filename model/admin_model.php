<?php
//商品登録処理
function regist_item($dbh, $item_name, $price, $stock, $item_img,
  $status, $item_type, $pickup, $comment) 
{
  $filename = get_upload_img($item_img);
  if(validate_item($item_name, $price, $stock, $status, $item_type, $filename) === false) {
    return false;
  }
  return regist_item_transaction($dbh, $item_name, $price, $stock, $item_img,
  $status, $item_type, $pickup, $comment, $filename);
}

//商品登録
function regist_item_transaction($dbh, $item_name, $price, $stock, $item_img,
  $status, $item_type, $pickup, $comment, $filename) 
{
  $dbh->beginTransaction();
  if(insert_item($dbh, $item_name, $price, $stock, $filename, $status, $item_type, $pickup, $comment) && 
  save_img($item_img, $filename)) {
    $dbh->commit();
    set_message('商品登録が完了しました');
    return true;
  }
  $dbh->rollback();
  return false;
}

//商品在庫更新処理
function update_stock($dbh, $stock, $item_id) 
{
  if(is_valid_item_stock($stock)===false) {
    return false;
  } 
  if(is_valid_item_id($item_id) === false) {
    return false;
  }
  if(update_item_stock($dbh, $stock, $item_id)) {
    set_message('在庫数が更新されました');
    return true;
  }
  return false;
}

//価格変更処理
function update_price($dbh, $price, $item_id) 
{
  if(is_valid_item_price($price) === false) {
    return false;
  }
  if(is_valid_item_id($item_id) === false) {
    return false;
  }
  if(update_item_price($dbh, $price, $item_id)) {
    set_message('商品価格が更新されました。');
    return true;
  }
  return false;
}

//商品の公開情報更新
function update_status($dbh, $status, $item_id) 
{
  if(is_valid_item_status($status) === false) {
    return false;
  } 
  if(is_valid_item_id($item_id) === false) {
    return false;
  }
  if(update_item_status($dbh, $status, $item_id)) {
    set_message('商品のステータスが更新されました');
    return true;
  }
  return false;
}

//商品データ削除処理
function delete_item($dbh, $item_id) 
{
  if(is_valid_item_id($item_id) === false) {
    return false;
  }
  $item = get_item($dbh, $item_id, false);
  if($item === false) {
    return false;
  }
  $dbh->beginTransaction();
  if(delete_item_data($dbh, $item['item_id']) 
    && delete_image($item['img'])) {
    $dbh->commit();
    set_message('商品データを削除しました');
    return true;
  }
  $dbh->rollback();
  return false;
}

//商品説明更新処理
function update_comment($dbh, $comment, $item_id) 
{
  if(is_valid_item_id($item_id) === false) {
    return false;
  }
  if(update_item_comment($dbh, $comment, $item_id)) {
    set_message('商品説明が更新されました。');
    return true;
  }
  return false;
}

//商品特集更新処理
function update_pickup($dbh, $pickup, $item_id) 
{
  if(is_valid_item_id($item_id) ===false) {
    return false;
  }
  if(update_item_pickup($dbh, $pickup, $item_id)) {
    set_message('商品特集が更新されました。');
    return true;
  }
  return false;
  
}

//商品画像削除処理
function delete_image($filename)
{
  if(file_exists(IMAGE_DIR . $filename) === true){
    unlink(IMAGE_DIR . $filename);
  return true;
  }
  return false;  
}

//商品画像アップロード処理
function get_upload_img($item_img) 
{
  if(is_valid_upload_img($item_img) === false) {
    return false;
  }
  $extension = pathinfo($item_img['name'], PATHINFO_EXTENSION);
  return get_new_file_name($extension); 
}
//商品画像エラーチェック
function is_valid_upload_img($item_img) 
{
  if(is_uploaded_file($item_img['tmp_name']) === false) {
    set_error('ファイルを選択して下さい');
    return false;
  }
  $extension = pathinfo($item_img['name'], PATHINFO_EXTENSION);
  if($extension === 'JPEG' || $extension === 'jpeg' || $extension === 'JPG' || $extension === 'jpg' || $extension === 'png') {
    return true;
  } else {
    set_error('ファイル形式が異なります。JPEGもしくはPNGにてアップロードして下さい');
    return false;
  }
  return true;
}

function get_new_file_name($extension) 
{
  return sha1(uniqid(mt_rand(), true)). '.'.$extension;
}

function save_img($item_img, $filename) 
{
  return move_uploaded_file($item_img['tmp_name'], IMAGE_DIR.$filename);
}


//商品インサート
function insert_item($dbh, $item_name, $price, $stock, $filename, $status, $item_type, $pickup, $comment) 
{
  $sql = "
  INSERT INTO 
    items(
      name , 
      price , 
      stock , 
      img , 
      status , 
      item_type , 
      pickup , 
      comment , 
      createdate , 
      updatedate
    )
  VALUES
    (?, ?, ?, ?, ?, ?, ?, ?, now(), now())
  ";
  return execute_query($dbh, $sql, [$item_name, $price, $stock, $filename, $status, $item_type, $pickup, $comment]);   
}

//価格変更処理
function update_item_price($dbh, $price, $item_id) 
{
  $sql ="
  UPDATE
    items
  SET
    price = ? ,
    updatedate = now()
  WHERE
    item_id = ?
  ";

  return execute_query($dbh, $sql, [$price, $item_id]);
}

   //---ステータス変更処理---
function update_item_status($dbh, $status, $item_id) 
{
  $sql = '
  UPDATE 
    items
  SET 
    status = ? , 
    updatedate = now() 
  WHERE 
    item_id = ?
  ';

  return execute_query($dbh, $sql, [$status, $item_id]);
}

//---データ削除処理---
function delete_item_data($dbh, $item_id) 
{
  $sql = "
  DELETE 
  FROM 
    items 
  WHERE 
    items.item_id = ?
  ";

  return execute_query($dbh, $sql, [$item_id]);
}

//----商品説明変更処理----
function update_item_comment($dbh, $comment, $item_id)
{
  $sql = "
  UPDATE 
    items 
  SET 
    comment = ? ,
    updatedate = now() 
  WHERE 
    item_id = ?
  ";
  
  return execute_query($dbh, $sql, [$comment, $item_id]);
}

//---特集変更---    
function update_item_pickup($dbh, $pickup, $item_id) 
{
  $sql = "
  UPDATE 
    items 
  SET 
    pickup = ? ,
    updatedate = now() 
  WHERE 
    item_id = ?";

  return execute_query($dbh, $sql, [$pickup, $item_id]);
}

//掛け率の更新
function update_persent($dbh, $persent, $user_id) 
{
  if(is_valid_persent($persent) === false) {
    return false;
  }
  if(update_user_persent($dbh, $persent, $user_id) === false) {
    return false;
  }
}

//掛け率の更新処理
function update_user_persent($dbh, $persent, $user_id) 
{
  $sql = "
  UPDATE
    users
  SET
    persent = ? ,
    updatedate = now()
  WHERE
    user_id = ?
  ";

  return execute_query($dbh, $sql, [$persent, $user_id]);
}
