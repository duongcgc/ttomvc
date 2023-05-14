<?php

/**
 * Customizer settings for this theme.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 * 
 * Định nghĩa class cho bộ tùy chỉnh Live Customize
 */

class AN_Customize {

    // Thuộc tính
    protected $customize_model;       // data của controller
    protected $customize_view;        // view của controller


    /**
     * Constructor. Instantiate the object.
     *
     * @since Twenty Twenty-One 1.0
     */
    public function __construct() {

        // Thao tác khi khởi tạo controller        
        $this->customize_model = new AN_Customize_Model;
        $this->customize_view = new AN_Customize_View;

        // Nạp script vào customize control bằng view
        $this->customize_view->add_control_script(
            'ttomvc-customize-helpers',
            THEME_JS . '/customize-helpers.js'
        );

        // Nạp script vào customize preview bằng view
        $this->customize_view->add_preview_script(
            'ttomvc-customize-helpers',
            THEME_JS . '/customize-helpers.js'
        );

        $this->customize_view->add_preview_script(
            'ttomvc-customize-preview',
            THEME_JS . '/customize-preview.js',
            array('customize-preview', 'customize-selective-refresh', 'jquery', 'twentytwentyone-customize-helpers')
        );

        // Đăng ký Customize Settings
        add_action('customize_register', array($this, 'register'));
    }

    /**
     * Register customizer options.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @param WP_Customize_Manager $wp_customize Theme Customizer object.
     * @return void
     */
    public function register($wp_customize) {

        // Change site-title & description to postMessage.
        $wp_customize->get_setting('blogname')->transport        = 'postMessage'; // @phpstan-ignore-line. Assume that this setting exists.
        $wp_customize->get_setting('blogdescription')->transport = 'postMessage'; // @phpstan-ignore-line. Assume that this setting exists.


        // PARTIAL ======>
        // Add partial for blogname.
        $wp_customize->selective_refresh->add_partial(
            'blogname',
            $this->customize_view->render_live('.site-title', 'partial_blogname')
        );

        // Add partial for blogdescription.
        $wp_customize->selective_refresh->add_partial(
            'blogdescription',
            $this->customize_view->render_live('.site-description', 'partial_blogdescription')
        );

        // SECTIONS =======>




        // SETTINGS ========>



        // CONTROL ========>
    }
}
