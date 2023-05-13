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

// This theme requires WordPress 5.3 or later.
if (version_compare($GLOBALS['wp_version'], '5.3', '<')) {

    // Nạp code tương thích phiên bản cũ
    require get_template_directory() . '/classes/controllers/an-back-compat.php';

    // Tạo đối tượng xử lý tương thích phiên bản cũ, nếu tồn tại class AN_Back_Compat    
    if (class_exists("AN_Back_Compat")) {
        $an_back_compat = new AN_Back_Compat();
    }
}

// Load code start theme ===============>
// Kiểm tra nếu tồn tại class AN_Start thì tạo một đối tượng Init

require get_template_directory() . '/classes/class-an-start.php';
if (class_exists("AN_Start")) {

    // Chạy các hàm khởi động
    $theme_start = new AN_Start();
}
