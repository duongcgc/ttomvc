<?php

/** 
 * Định nghĩa class chứa các cấu hình web - Theme Setup
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Twenty Twenty-One 1.0
 *
 * @return void
 */

class AN_Setup {

    // Thuộc tính
    private $theme_support;
    private $global_config;

    // Phương thức

    public function __construct() {

        // Thao tác khi bắt đầu Setup Theme =============

        /** 
         * Tạo đối tượng bổ sung các tính năng lõi của Theme 
         * Loading code từ trong thư mục theme /classes/controllers/an-support.php
         **/

        require_once get_template_directory() . '/classes/controllers/an-support.php';

        // Kiểm tra nếu tồn tại class AN_Support thì tạo mới đối tượng từ nó
        if (class_exists('AN_Support')) {
            $this->theme_support = new AN_Support();

            // Móc phương thức triển khai add_theme_support của class vào action after_setup_theme
            add_action("after_setup_theme", array($this, 'add_theme_support'));
        }
    }

    // Tạo phương thức add_theme_support cho class
    public function add_theme_support() {


        do_action('an_begin_of_setup');

        /*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Twenty Twenty-One, use a find and replace
		 * to change 'twentytwentyone' to the name of your theme in all the template files.
		 */
        load_theme_textdomain('ttomvc', get_template_directory() . '/languages');

        // Bổ sung hỗ trợ post-thumbnails với thumbnail size 1568, 9999, crop default = false                
        $this->theme_support->enable_post_thumbnail();
        $this->theme_support->add_post_thumbnail(1568, 9999);

        // Bổ sung fontsize cho editor
        $this->theme_support->enable_editor_font_sizes();

        // Bổ sung color palette cho editor
        $this->theme_support->enable_editor_color_palette();

        // Bổ sung color gradient cho editor
        $this->theme_support->enable_editor_gradient_presets();

        /*
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
        $logo_params = array();
        $logo_params['height']                  = 300;
        $logo_params['width']                   = 100;
        $logo_params['flex-height']             = true;
        $logo_params['flex-width']              = true;
        $logo_params['unlink-homepage-logo']    = true;
        $this->theme_support->enable_custom_logo($logo_params);

        // Custom background color.
        $bg_params = array();
        $bg_params['default-color']             = 'd1e4dd';
        $bg_params['default-image']             = '';
        $this->theme_support->enable_custom_background($bg_params);

        // Bổ sung HTML5 hỗ trợ cho các thành phần
        // Bổ sung các định dạng bài viết 
        $this->theme_support
            ->add_html5('comment-form')
            ->add_html5('comment-list')
            ->add_html5('gallery')
            ->add_html5('caption')
            ->add_html5('style')
            ->add_html5('script')
            ->add_html5('navigation-widgets');

        // Bổ sung các định dạng bài viết 
        $this->theme_support
            ->add_post_formats('link')
            ->add_post_formats('aside')
            ->add_post_formats('gallery')
            ->add_post_formats('image')
            ->add_post_formats('status')
            ->add_post_formats('video')
            ->add_post_formats('audio')
            ->add_post_formats('chat');

        // Bổ sung các phần khác đơn lẻ
        $this->theme_support
            ->add_support('align-wide')                                 // Add support for full and wide align images.
            ->add_support('automatic-feed-links')                       // Add default posts and comments RSS feed links to head.
            ->add_support('responsive-embeds')                          // Add support for responsive embedded content.
            ->add_support('custom-line-height')                         // Add support for custom line height controls.
            ->add_support('experimental-link-color')                    // Add support for experimental link color control.
            ->add_support('custom-spacing')                             // Add support for experimental cover block spacing.
            ->add_support('custom-units')                               // Add support for custom units.
            // This was removed in WordPress 5.6 but is still required to properly support WP 5.5.

            ->add_support('wp-block-styles')                            // Add support for Block Styles. 
            ->add_support('customize-selective-refresh-widgets')        // Add theme support for selective refresh for widgets.

            /*
            * Let WordPress manage the document title.
            * This theme does not use a hard-coded <title> tag in the document head,
            * WordPress will provide it for us.
            */
            ->add_support('title-tag');


        // Register Menu register_nav_menus ===============>



        // Support Starter Content ===========>


        // Support editor-styles ===========>

        do_action('an_end_of_setup');
    }
}
