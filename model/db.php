<?php

function get_db_connect() {
  $dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST.';charset='.DB_CHARSET;
try {
    $dbh = new PDO($dsn,DB_USER,DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  } catch (PDOException $e) {
    exit('接続できませんでした:'.$e->getMessage());
  }
  return $dbh;
}

function fetch_query($dbh, $sql, $params = array()){
  try{
    $stmt = $dbh->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetch();
  }catch(PDOException $e){
    echo $e->getMessage();
    set_error('データ取得に失敗しました。');
  }
  return false;
}

//dbよりデータ取得
function fetch_all_query($dbh,$sql,$params = array()) {
  try {
    $stmt = $dbh->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
  } catch(PDOException $e) {
    echo $e->getMessage();
    set_error('データ取得に失敗しました。管理者にご連絡ください');   
  }
  return false;
}

//dbにデータ更新
function execute_query($dbh, $sql, $params = array()){
  try{
    $stmt = $dbh->prepare($sql);
    return $stmt->execute($params);
  }catch(PDOException $e){
      echo $e->getMessage();
    set_error('更新に失敗しました。管理者にご連絡ください');
  }
  return false;
}