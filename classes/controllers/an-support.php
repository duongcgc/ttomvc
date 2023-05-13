<?php

/** 
 * Định nghĩa class chứa các cấu hình web - Theme Support
 */

class AN_Support {

    // Thuộc tính
    private $support_data;                      // Support Model
    private $thumbnail_sizes = array();
    private $post_formats = array();
    private $html5_supports = array();
    private $supports = array();

    // Phương thức
    public function __construct() {

        // Thao tác khi bắt đầu
        $this->support_data = new AN_Support_Model();
    }

    // Kiểm tra xem đã hỗ trợ tính năng chưa
    public function is_supported($feature = '') {
        return current_theme_supports($feature);
    }

    // Add custom editor font sizes.
    public function enable_editor_font_sizes() {
        add_theme_support(
            'editor-font-sizes',
            $this->support_data->get_editor_font_sizes()
        );
    }

    // Add custom editor color palette.
    public function enable_editor_color_palette() {

        add_theme_support(
            'editor-color-palette',
            $this->support_data->get_editor_color_palette()
        );
    }

    // Add custom editor gradient.
    public function enable_editor_gradient_presets() {

        add_theme_support(
            'editor_gradient_presets',
            $this->support_data->get_editor_gradient_presets()
        );
    }


    /**
     * Add theme supports.
     * Thêm các tính năng đơn lẻ
     */
    public function add_support($feature = '') {

        // updated list features
        $this->supports[] = $feature;

        foreach ($this->supports as $add_feature) {
            add_theme_support($add_feature);
        }

        return $this;
    }

    // Get all supports
    public function get_supports() {
        return $this->supports;
    }

    // Cho phếp tính năng thumbnail vào post
    public function enable_post_thumbnail() {

        /*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
        $this->add_support('post-thumbnails');
    }

    /**
     * Add post-thumbnail size.
     */
    public function add_post_thumbnail($width = 300, $height = 200, $crop = false) {

        $this->thumbnail_sizes[] = [$width, $height];
        set_post_thumbnail_size($width, $height, $crop);

        return $this;
    }

    // Get post thumbnail size
    public function get_post_thumbnail_sizes() {
        return $this->thumbnail_sizes;
    }

    /**
     * Add post-formats support.
     */
    public function add_post_formats($format = 'aside') {

        $this->post_formats[] = $format;
        add_theme_support('post-formats', $this->get_post_formats());

        return $this;
    }

    // Get post formats
    public function get_post_formats() {
        return $this->post_formats;
    }

    /*
    * Switch default core markup for search form, comment form, and comments
    * to output valid HTML5.
    */
    public function add_html5($html5_for = 'comment-form') {

        $this->html5_supports[] = $html5_for;
        add_theme_support('html5', $this->get_html5_supports());

        return $this;
    }

    // Get html5 support
    public function get_html5_supports() {
        return $this->html5_supports;
    }

    // Custom Logo
    public function enable_custom_logo($params = array()) {
        add_theme_support('custom-logo', $params);
    }

    // Custom Background
    public function enable_custom_background($params = array()) {
        add_theme_support('custom-background', $params);
    }
}
