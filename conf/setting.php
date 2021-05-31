<?php
define('DB_HOST', 'mysql');
define('DB_NAME', 'sample');
define('DB_USER', 'testuser');
define('DB_PASS', 'password');
define('DB_CHARSET','utf8');

define('VIEW_PATH',$_SERVER['DOCUMENT_ROOT'] . '/../view/');
define('MODEL_PATH',$_SERVER['DOCUMENT_ROOT'] . '/../model/');
define('IMG_PATH', '/assets/img/' );
define('IMAGE_DIR', $_SERVER['DOCUMENT_ROOT'] . '/assets/img/' );
define('STYLESHHET_PATH',$_SERVER['DOCUMENT_ROOT'] . '/assets/css/');

define('HOME_URL','/home.php');
define('ADMIN_URL','/admin.php');
define('ADMIN_USER_URL' , '/admin_user.php');
define('SIGN_UP_URL','/sign_up.php');
define('LOGIN_URL','/login.php');
define('TOP_URL','/top.php');
define('ITEM_LIST_URL','/item_list.php');
define('CATEGORY_URL','/category.php');
define('CART_URL','/cart.php');
define('ADD_CART_URL','add_cart.php');
define('FINISH_URL','/finish.php');
define('LOGOUT_URL' , '/logout.php');
define('PICKUP_URL','/pickup.php');
define('ITEM_DATA_URL','/item_data.php');
define('MY_PAGE_URL' , '/my_page.php');
define('CHANGE_MY_PAGE_URL','/change_my_page.php');
define('ORDERS_URL','/orders.php');
define('ORDER_DETAILS_URL' , '/order_details.php');
define('CHECKOUT_URL','/checkout.php');
define('END_USER_URL','/end_user.php');
define('REGIST_END_USER_URL','/regist_end_user.php');
define('RANKING_URL', '/ranking.php');

define('NAME_LENGTH_MIN' , 1);
define('NAME_LENGTH_MAX' , 10);
define('USER_PASSWORD_LENGTH_MIN' , 6);
define('USER_PASSWORD_LENGTH_MAX' , 8);
define('REGEXP_POSITIVE_INTEGER', '/\A([1-9][0-9]*|0)\z/');
define('REGEXP_ALPHANUMERIC', '/\A[0-9a-zA-Z]+\z/');
define('REGEXP_PHONE_NUMBER', '/\A[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}\z/');
define('REGEXP_EMAIL_ADDRESS', '/\A([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+\z/');
define('REGEXP_PHOST_CODE', '/\A([0-9]{3}-[0-9]{4})\z/');