<?php
//アイテムIDが一致するものを1レコード取得
function get_item($dbh, $item_id, $is_open = false)
{
  $sql = "
  SELECT
    item_id , 
    name ,
    price ,
    stock ,
    img ,
    status ,
    item_type ,
    pickup ,
    comment
  FROM
    items
  WHERE
    item_id = ?
  ";
  if($is_open === true) {
    $sql .="
    AND
      status = 1
    ";
  }

  return fetch_query($dbh, $sql, [$item_id]);
}
//アイテム一覧情報取得
function get_item_list($dbh, $is_open = false, $sort = null, $category_id = null) 
{
  $params = [];
  $sql = "
  SELECT 
    item_id ,
    name ,
    price ,
    stock ,
    img ,
    status ,
    item_type ,
    pickup ,
    comment
  FROM 
    items 
  ";
  if($is_open === true) {
    $sql .="
    WHERE 
      status = 1
    ";
  }
  if($category_id !==null) {
  $sql .="
    AND
      item_type = ?
    ";
    $params[] = $category_id;
  }
  if($sort === 'new' ||$sort === '') {
  $sql .="
    ORDER BY 
      createdate DESC
    ";
  }
  if($sort === 'cheap') {
  $sql .="
    ORDER BY
      price ASC
    ";
  }
  if($sort === 'high') {
  $sql .="
    ORDER BY 
      price DESC
    ";
  }
  return fetch_all_query($dbh, $sql, $params);
}

//ログイン中ユーザーの注文履歴商品
function get_orders_items($dbh, $user_id, $staff_id) 
{
  $sql = "
  SELECT 
    orders.order_datetime ,
    items.name ,
    items.price ,
    items.img ,
    items.item_id ,
    items.stock ,
    orders.user_id ,
    orders.staff_id
  FROM
    items
  INNER JOIN 
    order_details
  ON
    order_details.item_id = items.item_id
  INNER JOIN
    orders
  ON
    orders.order_number = order_details.order_number
  WHERE
    orders.user_id = ?
  AND
    orders.staff_id = ?
  GROUP BY
    orders.order_datetime ,
    items.item_id ,
    items.price ,
    items.name ,
    items.img ,
    items.stock ,
    orders.user_id ,
    orders.staff_id
  ORDER BY 
    orders.order_datetime DESC LIMIT 3
  ";
  return fetch_all_query($dbh, $sql, [$user_id, $staff_id]);
}

//商品のカテゴリー情報取得
function get_categories($dbh) 
{
  $sql="
  SELECT
    item_type
  FROM
    items
  GROUP BY
    item_type
  ORDER BY
    item_type DESC
  ";
  return fetch_all_query($dbh, $sql);
}

//ランキング情報取得
function get_ranking_item($dbh, $category_id = null) 
{
  $params = [];
  $sql = "
  SELECT 
    order_details.item_id ,
    name ,
    items.price ,
    sum(amount) 
  FROM 
    order_details
  INNER JOIN 
    items 
  ON 
    items.item_id = order_details.item_id
  ";
  if($category_id !== null) {
    $sql .="
    WHERE
      item_type = ?
    ";
    $params[] = $category_id;
    }
  $sql .= "
  GROUP BY 
    items.item_id
  ORDER BY 
    sum(amount) DESC limit 3
  ";  
  return fetch_all_query($dbh, $sql, $params);
}

//新着アイテム取得 
function get_new_items($dbh) {
  $sql = "
  SELECT 
    item_id ,
    name ,
    price ,
    stock ,
    img ,
    status ,
    item_type ,
    pickup ,
    comment
  FROM 
    items 
  WHERE 
    status = 1
  ORDER BY 
    createdate DESC
  LIMIT 6
  ";
  return fetch_all_query($dbh, $sql);
}
