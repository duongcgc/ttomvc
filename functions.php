<?php

/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage TTOMVC
 * @since Twenty Twenty-One MVC 1.0
 */

// Định nghĩa hằng số cơ bản Theme WordPress
define('THEME_NAME',                'TTOMVC');

// Định nghĩa hằng số liên quan đến version
define('THEME_VERSION',             '1.0.0');

// Định nghĩa hằng số liên quan đến đường dẫn
define('THEME_URL',                 get_template_directory_uri());
define('THEME_DIR',                 get_template_directory());
define('THEME_ASSET',               THEME_URL . '/assets');
define('THEME_CSS',                 THEME_ASSET . '/css');
define('THEME_JS',                  THEME_ASSET . '/js');
define('THEME_IMG',                 THEME_ASSET . '/images');
define('THEME_CLASS',               THEME_DIR . '/classes');
define('THEME_CONFIG',              THEME_CLASS . '/config');
define('THEME_MODEL',               THEME_CLASS . '/models');
define('THEME_VIEW',                THEME_CLASS . '/views');
define('THEME_CONTROLLER',          THEME_CLASS . '/controllers');

// Autoload classes
require_once(THEME_CLASS . '/autoloader.php');

// This theme requires WordPress 5.3 or later.
if (version_compare($GLOBALS['wp_version'], '5.3', '<')) {

    // Tạo đối tượng xử lý tương thích phiên bản cũ, nếu tồn tại class AN_Back_Compat    
    if (class_exists("AN_Back_Compat")) {
        $an_back_compat = new AN_Back_Compat();
    }
}

// Load code start theme ===============>
// Kiểm tra nếu tồn tại class AN_Start thì tạo một đối tượng Init

require THEME_CLASS . '/class-an-start.php';
if (class_exists("AN_Start")) {

    // Chạy các hàm khởi động
    $theme_start = new AN_Start();
}
