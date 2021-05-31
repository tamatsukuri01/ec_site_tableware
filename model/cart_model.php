<?php 

// **** 「ログイン中のユーザー」が入れているカートの商品取得
function get_user_cart($dbh, $user_id, $staff_id)
{
  $sql = "
  SELECT  
    carts.cart_id ,
    carts.user_id ,
    carts.staff_id ,
    carts.item_id ,
    carts.amount ,
    carts.end_user_id ,
    items.name ,
    items.price ,
    items.stock ,
    items.img ,
    items.status 
  FROM 
    carts 
  INNER JOIN 
    items 
  ON 
    carts.item_id = items.item_id 
  WHERE 
    carts.user_id = ?
  AND
    carts.staff_id = ?
  ";

    return fetch_all_query($dbh, $sql, [$user_id, $staff_id]);
}


//カート内アイテムの数量変更処理
function update_cart($dbh, $amount, $item_id, $user_id, $staff_id) {
  if(is_valid_amount($amount) === false) {
    return false;
  }
  if(is_valid_item_id($item_id) === false) {
    return false;
  }
  update_cart_amount($dbh, $amount, $item_id, $user_id, $staff_id);
}

//カートの数量変更処理
function update_cart_amount($dbh, $amount, $item_id, $user_id, $staff_id)
{
  $sql = "
  UPDATE 
    carts
  SET 
    amount = ? ,
    updatedate = now()
  WHERE 
    item_id = ?
  AND 
    user_id = ?
  AND
    staff_id = ?
  ";
  return execute_query($dbh, $sql, [$amount, $item_id, $user_id, $staff_id]);
}

//カートのアイテムデータ削除
function delete_cart_item($dbh, $item_id, $user_id, $staff_id)
{
  $sql = "
  DELETE 
  FROM 
    carts 
  WHERE 
    item_id = ?
  AND 
    user_id = ?
  AND
    staff_id = ?
  ";

  return execute_query($dbh, $sql, [$item_id, $user_id, $staff_id]);
}

//カートに入れる処理
function add_cart($dbh, $user_id, $staff_id, $item_id, $amount) {
  $cart = get_cart_item($dbh, $user_id, $staff_id, $item_id);
  if($cart === false) {
    return insert_cart($dbh, $user_id, $staff_id, $item_id, $amount);    
  }
  return update_cart_amount($dbh, $cart['amount'] + $amount, $cart['item_id'], $cart['user_id'], $cart['staff_id']);
}

//「ログインしているユーザー」のカートからアイテムIDが一致するものを取得
function get_cart_item($dbh, $user_id, $staff_id, $item_id) 
{  
  $sql = '
  SELECT 
    cart_id ,
    user_id ,
    staff_id ,
    item_id ,
    amount
  FROM 
    carts 
  WHERE 
    user_id = ? 
  AND
    staff_id = ?
  AND 
    item_id = ?
  ';

  return fetch_query($dbh, $sql, [$user_id, $staff_id, $item_id]);
}

//カートへのインサート
function insert_cart($dbh, $user_id, $staff_id, $item_id, $amount )
{
  $sql = "
  INSERT INTO 
    carts(
      user_id ,
      staff_id ,
      item_id ,
      amount ,
      createdate ,
      updatedate
    )
    VALUES
      (?, ?, ?, ?, now(), now())
  ";
  return execute_query($dbh, $sql, [$user_id, $staff_id, $item_id, $amount]);
}

//カートに直送先を登録
function update_cart_end_user($dbh, $end_user_id, $user_id, $staff_id) 
{
  $sql = "
  UPDATE
    carts
  SET
    end_user_id = ? ,
    updatedate = now()
  WHERE
    user_id = ?
  AND
    staff_id = ?
  ";
  return execute_query($dbh, $sql, [$end_user_id, $user_id, $staff_id]);
}
//カート内の商品の直送先情報取得
function get_delivery_address($dbh, $user_id, $staff_id) 
{
  $sql ="
  SELECT
    end_users.end_user_id,
    end_users.end_user_name,
    end_users.end_user_post_code,
    end_users.end_user_address,
    end_users.end_user_tell,
    carts.user_id,
    carts.staff_id
  FROM
    end_users
  INNER JOIN
    carts
  ON 
    end_users.end_user_id = carts.end_user_id
  WHERE
    carts.user_id = ?
  AND
    carts.staff_id = ?
  ";
  return fetch_query($dbh, $sql, [$user_id, $staff_id]);

}
//購入処理
function purchase_carts($dbh, $cart_items, $persent) 
{
  if(validate_cart_purchase($cart_items) === false) {
    return false;
  }
  $dbh->beginTransaction();
  foreach($cart_items as $cart_item) {
    if(update_item_stock($dbh, $cart_item['stock']-$cart_item['amount'], $cart_item['item_id']) === false) {
      set_error($cart_item['name'].'の購入に失敗しました。');
      return false;
    }
  }
  if(register_orders($dbh, $cart_items, $persent) === false) {
    set_error('購入に失敗しました。');
    return false;
  }
  if(delete_all_cart_item($dbh, $cart_items[0]['user_id'], $cart_items[0]['staff_id']) === false) {
    set_error('購入に失敗しました。');
    return false;
  }
  if(has_error() !== true) {
    $dbh->commit();
    return true;
  }
    $dbh->rollback();
    return false; 
}

//カート内商品のエラーチェック
function validate_cart_purchase($cart_items) 
{
  if(count($cart_items) === 0 ) {
    return false;
  } 
  foreach($cart_items as $cart_item) {
    if($cart_item['status'] !== 1) {
      set_error('申し訳ございません、'.$cart_item['name'].'は現在購入できません');
    }
    if($cart_item['stock'] - $cart_item['amount'] < 0) {
    set_error('申し訳ございません。'.$cart_item['name'].'は在庫が足りません。
    <br>この商品の現在購入可能数は'.$cart_item['stock'].'個です。') ; 
    }
  }
  if (has_error() === true) {
    return false;
  }
  return true;
}

//----在庫の更新----         
function update_item_stock($dbh, $new_stock, $item_id) 
{
  $sql = "
  UPDATE 
    items
  SET 
    stock = ? ,
    updatedate = now()
  WHERE 
    item_id = ? 
  ";
  return execute_query($dbh, $sql, [$new_stock, $item_id]);
}

//カートの中身の削除   
function delete_all_cart_item($dbh, $user_id, $staff_id) 
{
  $sql = "
  DELETE 
  FROM 
    carts 
  WHERE 
    user_id = ?
  AND
    staff_id = ?
  ";
  return execute_query($dbh, $sql, [$user_id, $staff_id]);
}

