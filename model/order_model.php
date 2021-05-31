<?php
//購入履歴の作成
function register_orders($dbh, $cart_items, $persent) 
{
  if(insert_orders($dbh, $cart_items[0]['user_id'], $cart_items[0]['staff_id'], $cart_items[0]['end_user_id']) === false) {
    set_error('購入履歴の作成に失敗しました');
    return false;
  }
  $order_number = $dbh->lastInsertId('order_number');
  foreach($cart_items as $cart_item) {
    if(insert_order_details($dbh, $order_number,
      $cart_item['item_id'], $cart_item['amount'], $cart_item['price'] * $persent) === false) {
      set_error($cart_item['name'].'の購入明細作成に失敗しました');
    }
  }
  if(has_error() === true) {
    return false;
  }
  return true;
}

//購入履歴をordersテーブルにインサート
function insert_orders($dbh, $user_id, $staff_id, $end_user_id) 
{
  $sql = "
  INSERT INTO 
    orders(
      user_id , 
      staff_id ,
      end_user_id ,
      order_datetime
    )
  VALUES
    (?, ?, ?, now())
  ";
    
  return execute_query($dbh, $sql, [$user_id, $staff_id, $end_user_id]);      
}

//購入明細をordel_datalisテーブルにインサート
function insert_order_details($dbh, $order_number, $item_id, $amount, $price) 
{
  $sql = '
  INSERT INTO 
    order_details(
      order_number , 
      item_id , 
      amount , 
      price 
    )
  VALUES
    (?, ?, ?, ?)';
  
  return execute_query($dbh, $sql, [$order_number, $item_id, $amount, $price]);
}

//ユーザー購入履歴取得
function get_user_orders($dbh, $user_id = null, $staff_id = null ) 
{
  $params = [];
  $sql = "
  SELECT 
    company_name ,
    orders.user_id ,
    orders.staff_id ,
    staff_name ,
    order_details.order_number ,
    order_datetime ,
    sum(amount * order_details.price) AS total_price
  FROM 
    order_details
  INNER JOIN 
    items 
  ON 
    items.item_id = order_details.item_id
  INNER JOIN 
    orders 
  ON
    orders.order_number = order_details.order_number
  INNER JOIN 
    users
  ON
    users.user_id = orders.user_id
  INNER JOIN
    staffs
  on
    orders.staff_id = staffs.staff_id
  ";
  if($user_id !== null ) {
    $sql .="
    WHERE 
      orders.user_id = ?
    ";
    $params[] = $user_id;
  }
  if($staff_id !== null ) {
    $sql .="
    AND 
      orders.staff_id = ?
    ";
    $params[] = $staff_id;
  }
  
  $sql .=" 
  GROUP BY 
    orders.order_number
  ORDER BY 
    order_datetime DESC
  ";

  return fetch_all_query($dbh, $sql, $params);
}

//ユーザー購入明細取得
function get_user_order_details($dbh, $order_number, $user_id = null, $staff_id = null) 
{
  $sql = "
  SELECT 
    order_details.order_number ,
    order_details.item_id ,
    name ,
    amount ,
    order_details.price
  FROM 
    order_details
  INNER JOIN 
    items 
  ON
    items.item_id = order_details.item_id
  INNER JOIN 
    orders 
  ON
    orders.order_number = order_details.order_number
  WHERE 
    order_details.order_number = ?
  ";
  if($user_id !== null && $staff_id !== null) {
    $sql .="
    AND 
      user_id = ?
    AND
      staff_id = ?
    ";
    return fetch_all_query($dbh, $sql, [$order_number, $user_id, $staff_id]);
  }
  return fetch_all_query($dbh,$sql,[$order_number]);
}

//ユーザー購入履歴取得
function get_user_order_records($dbh, $order_number, $user_id = null, $staff_id = null) 
{
  $sql = "
  SELECT 
    staff_name ,
    company_name ,
    order_details.order_number ,
    order_datetime ,
    orders.end_user_id ,
    end_users.end_user_name ,
    sum(amount * order_details.price) AS total_price
  FROM 
    order_details
  INNER JOIN 
    items 
  ON
    items.item_id = order_details.item_id
  INNER JOIN 
    orders 
  ON
    orders.order_number = order_details.order_number
  INNER JOIN
    users
  ON
    users.user_id = orders.user_id
  INNER JOIN
    staffs
  ON 
    staffs.staff_id = orders.staff_id
  INNER JOIN
    end_users
  ON
    end_users.end_user_id = orders.end_user_id
  WHERE 
    order_details.order_number = ?
  ";
  if($user_id !== null && $staff_id !== null) {
    $sql .="
    AND 
      orders.user_id = ?
    AND
      orders.staff_id = ?
    ";
  }
  $sql .="
    GROUP BY 
      orders.order_number
    ";
  if($user_id !== null && $staff_id !== null) {
    return fetch_all_query($dbh,$sql,[$order_number,$user_id,$staff_id]);
  }

  return fetch_all_query($dbh,$sql,[$order_number]);
}
