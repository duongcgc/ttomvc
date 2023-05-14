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
    private $customize_model;           // data của controller  => settings
    private $customize_view;            // view của controller  => render
    private $customize_color_control;

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

        // SECTIONS - SETTINGS - CONTROL ========>

        /** Default section title_tagline
         * ==================================================================
         */
        $section_name = 'title_tagline';

        // Add "display_title_and_tagline" setting for displaying the site-title & tagline.
        // & Add control for the "display_title_and_tagline" setting.
        $this->customize_model->new_option(
            $wp_customize,
            array(
                'id'                => 'display_title_and_tagline',
                'capability'        => 'edit_theme_options',
                'type'              => 'checkbox',
                'default'           => true,
                'section'           => $section_name,
                'label'             => esc_html__('Display Site Title & Tagline', 'twentytwentyone'),
                'sanitize_callback' => array(__CLASS__, 'sanitize_checkbox')
            )
        );

        /**
         * Add excerpt or full text selector to customizer
         * ==================================================================
         */
        $section_name = 'excerpt_settings';
        $this->customize_model->new_section(
            $wp_customize,
            array(
                'id'                => $section_name,
                'title'             => esc_html__('Excerpt Settings', 'twentytwentyone'),
                'priority'          => 120,
            )
        );

        $this->customize_model->new_option(
            $wp_customize,
            array(
                'id'                => 'display_excerpt_or_full_post',
                'capability'        => 'edit_theme_options',
                'type'              => 'checkbox',
                'default'           => 'excerpt',
                'section'           => $section_name,
                'label'             => esc_html__('On Archive Pages, posts show:', 'twentytwentyone'),
                'choices'           => array(
                    'excerpt' => esc_html__('Summary', 'twentytwentyone'),
                    'full'    => esc_html__('Full text', 'twentytwentyone'),
                ),
                'sanitize_callback' => static function ($value) {
                    return 'excerpt' === $value || 'full' === $value ? $value : 'excerpt';
                },
            )
        );

        /** Add the control. Overrides the default background-color control. 
         * ==================================================================
         */
        $section_name = 'colors';

        // Build the colors array from theme-support.
        $colors = array();
        if (isset($palette[0]) && is_array($palette[0])) {
            foreach ($palette[0] as $palette_color) {
                $colors[] = $palette_color['color'];
            }
        }

        // Get the palette from theme-supports.
        $palette = get_theme_support('editor-color-palette');

        // Register the custom control.
        $wp_customize->register_control_type('AN_Customize_Color_Control');

        // Background color.
        // Include the custom control class.
        // Add the control. Overrides the default background-color control.
        $this->customize_model->override_option(
            $wp_customize,
            new AN_Customize_Color_Control(
                $wp_customize,
                'background_color',
                array(
                    'label'   => esc_html_x('Background color', 'Customizer control', 'twentytwentyone'),
                    'section' => $section_name,
                    'palette' => $colors,
                )
            )
        );
    }

    /**
     * Sanitize boolean for checkbox.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @param bool $checked Whether or not a box is checked.
     * @return bool
     */
    public static function sanitize_checkbox($checked = null) {
        return (bool) isset($checked) && true === $checked;
    }
}
