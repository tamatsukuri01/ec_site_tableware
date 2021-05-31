<?php
//設定ファイル読み込み
require_once '../conf/setting.php';
require_once MODEL_PATH.'function.php';



session_start();

if (isset($_COOKIE[$session_name])) {
  
  $params = session_get_cookie_params();

  setcookie($session_name, '', time() - 42000,
    $params["path"], $params["domain"],
    $params["secure"], $params["httponly"]
  );
}
session_destroy();

redirect_to(HOME_URL);