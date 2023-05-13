<?php

// Định nghĩa autoload class khi gọi đến
spl_autoload_register('autoload');
function autoload($class_name) {

    // Chuyển tên class về chữ thường
    $class_name = strtolower($class_name);

    // đổi dấu gạch chéo thành dấu gạch ngang
    $class_name = str_replace('_', '-', $class_name);

    // Nếu tên class có chứa từ "model" thì nó là controller
    // và sẽ nằm trong thư mục models
    if (strstr($class_name, 'model')) {
        $path = THEME_DIR . '/classes/models/' . $class_name . '.php';
    } elseif (strstr($class_name, 'view')) {
        // Nếu tên class có chứa từ "view" thì nó là model
        // và sẽ nằm trong thư mục views
        $path = THEME_DIR . '/classes/views/' . $class_name . '.php';
    } else {
        // Còn không thì nó là controller trong thư mục controllers
        $path = THEME_DIR . '/classes/controllers/' . $class_name . '.php';
    }

    // Nếu file tồn tại thì require_once
    if (file_exists($path)) {
        require_once($path);
    }
}
