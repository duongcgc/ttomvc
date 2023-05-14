<?php

/** 
 * Định nghĩa class cho bộ tùy chỉnh Live Customize
 */

class AN_Customize_View {

    // Thuộc tính
    protected $model;       // data của customizer
    protected $view;        // view của customizer
    private $customize_scripts = array();


    // Khởi tạo
    public function __construct() {

        // Thao tác khi khởi tạo customizer        

    }

    /**
     * Render the site title for the selective refresh partial.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @return void
     */
    public function partial_blogname() {
        bloginfo('name');
    }

    /**
     * Render the site tagline for the selective refresh partial.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @return void
     */
    public function partial_blogdescription() {
        bloginfo('description');
    }

    // Render Live backto Customize Preview
    public function render_live($css_selector, $function_name) {

        $back_action = array(
            'selector'        => $css_selector,
            'render_callback' => array($this, $function_name),
        );

        return $back_action;
    }

    // Add Script vào Customize Control
    public function add_control_script($js_name, $js_file, $js_depend = array(), $js_version = false, $at_footer = true) {

        // Nếu không cung cấp version thì 
        if (!$js_version) {
            $param_version = wp_get_theme()->get('Version');
        } else {
            $param_version = $js_version;
        }

        $this->customize_scripts[$js_name] = array(
            'js-name'       => $js_name,
            'js-file'       => $js_file,
            'js-depend'     => $js_depend,
            'js-version'    => $param_version,
            'at-footer'     => $at_footer
        );

        // Móc vào hook controls customize
        add_action('customize_controls_enqueue_scripts', array($this, 'an_customize_controls_enqueue_scripts'), 10, 5);
        return $this;
    }

    /**
     * Enqueue scripts for the customizer.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @return void
     */
    function an_customize_controls_enqueue_scripts() {

        // đăng ký query
        wp_enqueue_script($js_name, $js_file, $js_depend, $js_version, $at_footer);
    }

    /**
     * Enqueue scripts for the customizer preview.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @return void
     */
    // Add Script vào Customize Preview
    public function add_preview_script($js_name, $js_file, $js_depend = array(), $js_version = false, $at_footer = true) {

        // Nếu không cung cấp version thì 
        if (!$js_version) {
            $param_version = wp_get_theme()->get('Version');
        } else {
            $param_version = $js_version;
        }

        $this->customize_scripts[$js_name] = array(
            'js-name'       => $js_name,
            'js-file'       => $js_file,
            'js-depend'     => $js_depend,
            'js-version'    => $param_version,
            'at-footer'     => $at_footer
        );

        // Móc vào hook controls customize
        add_action('customize_preview_init', array($this, 'an_customize_preview_enqueue_scripts'), 10, 5);

        return $this;
    }

    /**
     * Enqueue scripts for the customizer.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @return void
     */
    function an_customize_preview_enqueue_scripts($js_name, $js_file, $js_depend, $js_version, $at_footer) {

        // đăng ký query
        wp_enqueue_script($js_name, $js_file, $js_depend, $js_version, $at_footer);
    }
}
