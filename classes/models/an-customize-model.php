<?php

/** 
 * Định nghĩa class base cho các models
 */

class AN_Customize_Model {

    // Thuộc tính


    // Khởi tạo
    public function __construct() {

        // Thao tác khi khởi tạo model

    }


    // Thêm Section mới
    public function new_section($wp_customize, $params = []) {

        $section_id = $params['id'];
        $section_args = array();
        $section_args['title'] = $params['title'];
        $section_args['priority'] = $params['priority'];

        $wp_customize->add_section(
            $section_id,
            $section_args
        );

        return $section_id;
    }

    // Thêm Control và Setting mới
    public function new_option($wp_customize, $params = []) {

        $setting_id     = $params['id'];
        $setting_param  = array();
        $control_param  = array();

        $setting_param['capability']            = $params['capability'];
        $setting_param['default']               = $params['default'];
        $setting_param['sanitize_callback']      = $params['sanitize_callback'];

        $control_param['type']                  = $params['type'];
        $control_param['section']               = $params['section'];
        $control_param['label']                 = $params['label'];
        $control_param['choices']                = $params['choices'];

        $wp_customize->add_setting($setting_id, $setting_param);
        $wp_customize->add_control($setting_id, $control_param);

        return $setting_id;
    }

    // Ghi đè control đã có
    public function override_option($wp_customize, $custom_control) {
        // Add the control. Overrides the default background-color control.
        $wp_customize->add_control($custom_control);
    }
}
