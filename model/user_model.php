<?php
//ユーザー登録処理
function regist_company($dbh, $company_name, $user_name, $post_code, $address, $user_tell, $pass, $user_mail, $user_type) 
{
  if(check_exist_company_name($dbh, $company_name) === false) {
    return false;
  }
  if(is_valid_company($user_name, $post_code, $address, $user_tell, $user_mail) === false) {
    return false;
  }
  if(is_valid_password($pass) === false) {
    return false;
  }
  $hash = password_hash($pass, PASSWORD_DEFAULT);
  $dbh->beginTransaction();
  if(insert_company($dbh, $company_name, $user_name, $post_code, $address, $user_tell, $hash, $user_mail, $user_type) ===false) {
    set_error('会員登録に失敗しました。<br>お手数ですが管理者までご連絡ください');
    return false;
  }
  $user_id = $dbh->lastInsertId('user_id');
  if(insert_staff($dbh, $user_id, $user_name, $user_mail, $user_tell) === false) {
    set_error('会員登録に失敗しました。<br>お手数ですが管理者までご連絡ください');
    return false;
  }
  if(insert_end_users($dbh, $user_id, $user_name, $post_code, $address, $user_tell) === false) {
    set_error('届け先の登録に失敗しました。<br>お手数ですが管理者までご連絡ください');
    return false;
  }
  if(has_error() !== true) {
    $dbh->commit();
    return true;
  }
    $dbh->rollback();
    return false; 
}

//会員情報インサート
function insert_company($dbh, $company_name, $user_name, $post_code, $address, $user_tell, $hash, $user_mail, $user_type) 
{
  $sql = "
  INSERT INTO 
    users(
      company_name ,
      user_name ,
      post_code ,
      address ,
      tell ,
      password ,
      mail ,
      user_type ,
      persent ,
      createdate ,
      updatedate
    )
  VALUES
    (?, ?, ?, ?, ?, ?, ?, ?, 100, now(), now())
  ";

  return execute_query($dbh, $sql, [$company_name, $user_name, $post_code, $address, $user_tell, $hash, $user_mail, $user_type]);
}

//社員登録処理
function regist_staff($dbh, $user_id, $staff_name, $staff_mail, $staff_tell) 
{
  if(is_valid_staff($staff_name, $staff_mail, $staff_tell) === false) {
    return false;
  }
  if(insert_staff($dbh, $user_id, $staff_name, $staff_mail, $staff_tell) === false) {
    return false;
  }
  return true;
}

//社員登録
function insert_staff($dbh, $user_id, $staff_name, $staff_mail, $staff_tell) 
{
  $sql ="
  INSERT
    staffs(
      user_id , 
      staff_name , 
      staff_mail , 
      staff_tell , 
      createdate , 
      updatedate
    )
  VALUES
    (?, ?, ?, ?, now(), now())
  ";

  return execute_query($dbh, $sql, [$user_id, $staff_name, $staff_mail, $staff_tell]);
}

//届け先登録処理
function regist_end_users($dbh, $user_id, $end_user_name, $end_user_post_code, $end_user_address, $end_user_tell) 
{
  if(is_valid_end_user($end_user_post_code, $end_user_address, $end_user_tell) === false) {
    return false;
  }
  if(insert_end_users($dbh, $user_id, $end_user_name, $end_user_post_code, $end_user_address, $end_user_tell) === false) 
  {
    return false;
  }
  return true;
}

//届け先登録
function insert_end_users($dbh, $user_id, $end_user_name, $end_user_post_code, $end_user_address, $end_user_tell)
{
  $sql ="
  INSERT
    end_users(
      user_id ,
      end_user_name , 
      end_user_post_code , 
      end_user_address , 
      end_user_tell , 
      createdate , 
      updatedate
    )
  VALUES
    (?, ?, ?, ?, ?, now(), now())
  ";
  return execute_query($dbh, $sql, [$user_id, $end_user_name, $end_user_post_code, $end_user_address, $end_user_tell]);
}

//ログイン処理
function login_as($dbh, $company_name, $staff_name, $pass) 
{
  $user_data = get_company_name($dbh, $company_name, $staff_name);
  if($user_data === false || password_verify($pass, $user_data['password']) === false) {
    return false;
  }
  set_session('user_id',$user_data['user_id']);
  set_session('company_name',$user_data['company_name']);
  set_session('staff_name',$user_data['staff_name']);
  set_session('staff_id',$user_data['staff_id']);

  return $user_data;
}

//会社名、スタッフ名取得
function get_company_name($dbh, $company_name, $staff_name = null) 
{
  $params = [];
  $sql = "
  SELECT 
    users.user_id ,
    users.company_name ,
    users.user_name ,
    users.password ,
    staffs.staff_name ,
    staffs.staff_id ,
    user_type 
  FROM 
    users 
  INNER JOIN
    staffs
  ON
    staffs.user_id = users.user_id
  WHERE
    company_name = ?
  ";
  $params[] = $company_name;
  
  if($staff_name !== null) {
    $sql .="
    AND
    staff_name = ?
    ";
    $params[] = $staff_name;
  }
  $sql .="
  LIMIT 1
  ";
  return fetch_query($dbh, $sql, $params);
}

//ユーザー登録情報取得
function get_user_info($dbh, $user_id = null) 
{
  $sql = "
  SELECT 
    user_id ,
    company_name ,
    post_code ,
    address ,
    user_name ,
    password ,
    mail ,
    tell ,
    persent ,
    user_type ,
    createdate ,
    updatedate
  FROM 
    users
  ";
  if($user_id !== null) {
    $sql .="
    WHERE 
      user_id = ?
  ";
  return fetch_all_query($dbh, $sql, [$user_id]);
  }
  return fetch_all_query($dbh, $sql);
}

//会員情報更新処理
function update_my_page($dbh, $company_name, $user_name, $post_code, $address, $user_tell, $user_mail, $user_id) 
{
  if(is_valid_company($user_name, $post_code, $address, $user_tell, $user_mail) === false) {
    return false;
  }
  if(update_user_info($dbh, $company_name, $user_name, $post_code, $address, $user_tell, $user_mail, $user_id) === false) {
    return false;
  }
}

//マイページ情報更新
function update_user_info($dbh, $company_name, $user_name, $post_code, $address, $user_tell, $user_mail, $user_id) 
{
  $sql ="
  UPDATE 
    users
  SET 
    company_name = ? ,
    user_name = ? ,
    post_code = ? ,
    address = ? ,
    tell = ? ,
    mail = ? ,
    updatedate = now()
  WHERE 
    user_id = ?    
  ";
  return execute_query($dbh, $sql, [$company_name, $user_name, $post_code, $address, $user_tell, $user_mail, $user_id]);

}

//社員情報取得
function get_staffs($dbh, $user_id = null ,$staff_id = null)
{
  $params = [];
  $sql ="
  SELECT
    staff_id ,
    user_id ,
    staff_name ,
    staff_tell ,
    staff_mail ,
    createdate ,
    updatedate
  FROM
    staffs
  ";
  if($user_id !== null) {
    $sql .="
    WHERE
      user_id = ?
  ";
  $params[] = $user_id;
  }
  
  if($staff_id !== null) {
    $sql .="
    AND
      staff_id = ?
  ";
  $params[] = $staff_id;
  }
  
  return fetch_all_query($dbh, $sql, $params);
  
}

//届け先情報取得
function get_end_users($dbh, $user_id = null, $end_user_id = null) 
{
  $sql ="
  SELECT
    end_user_id ,
    user_id ,
    end_user_name ,
    end_user_post_code ,
    end_user_address ,
    end_user_tell ,
    createdate ,
    updatedate
  FROM
    end_users
  ";
if($user_id !== null) {
  $sql .="
  WHERE
    user_id = ?
  ";
  return fetch_all_query($dbh, $sql, [$user_id]);
}
if($end_user_id !== null) {
  $sql .="
  WHERE
    end_user_id = ?
    LIMIT 1
  ";
  return fetch_query($dbh, $sql, [$end_user_id]);
}
  return fetch_all_query($dbh, $sql);
}


