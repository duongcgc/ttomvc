<?php

/** 
 * Định nghĩa class Support Model
 */

class AN_Support_Model {

    // Thuộc tính


    // Khởi tạo
    public function __construct() {

        // Thao tác khi khởi tạo model

    }

    // Phương thức lấy dữ liệu từ file bên ngoài
    private function get_array_from_file($data_file = '', $array_name = '') {

        // Lấy tên file cần include vào
        $filename_without_ext = str_replace(".php", "", $data_file); // Thay thế ".php" bằng chuỗi rỗng
        $filename_data = get_template_directory() . '/classes/config/' . $filename_without_ext . '.php';

        // Kiểm tra xem file tồn tại không
        if (file_exists($filename_data)) {

            // include vào
            include $filename_data;

            // Kiểm tra xem tồn tại biến không
            if (isset(${$array_name})) {
                return ${$array_name};
            } else {
                return array();
            }
        } else {
            return array();
        }
    }

    // Trả ra danh sách editor font size lấy từ file classes/config/editor-font-sizes.php
    public function get_editor_font_sizes($data_file = 'editor-font-sizes', $array_name = 'editor_font_sizes') {

        // Lấy dữ liệu cho font
        return $this->get_array_from_file($data_file, $array_name);
    }

    // Trả ra danh sách editor color lấy từ file classes/config/editor-color-pallette.php
    public function get_editor_color_palette($data_file = 'editor-color-palette', $array_name = 'editor_color_palette') {

        // Lấy dữ liệu cho color
        return $this->get_array_from_file($data_file, $array_name);
    }

    // Trả ra danh sách editor color lấy từ file classes/config/editor-gradient-presets.php
    public function get_editor_gradient_presets($data_file = 'editor-gradient-presets', $array_name = 'editor_gradient_presets') {

        // Lấy dữ liệu cho gradient
        return $this->get_array_from_file($data_file, $array_name);
    }
}
