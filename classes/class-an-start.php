<?php

/** 
 * Định nghĩa class khởi động website
 */

class AN_Start {

    // Thuộc tính
    private $theme_setup;               // Setup Theme Module
    private $theme_menu;                // Setup Theme Menu

    // Phương thức
    public function __construct() {

        // Chạy các hàm setup
        new AN_Setup();

        // Chạy chức năng menu
        $this->theme_menu = new AN_Menu_Admin();

        // Tạo UI Menu quản lý Giao diện > Menu
        $this->theme_menu
            ->add_location('primary', esc_html__('Primary menu', 'ttomvc'))
            ->add_location('secondary', esc_html__('Secondary menu', 'ttomvc'));

        // Kiểm tra xem Tạo ra một đối tượng AN_Sidebar có thì tạo một đối tượng
        /**
         * Register widget area. 
         *
         * @since Twenty Twenty-One 1.0
         *
         * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
         *
         * @return void
         */

        // Tạo UI quản lý Sidebar => Giao diện > Widgets
        $sidebar1 = array('id' => 'sidebar-1', 'name' => 'Main Sidebar', 'class' => 'main-sidebar');
        $sidebar2 = array('id' => 'sidebar-2', 'name' => 'Footer Sidebar', 'class' => 'footer-sidebar');

        new AN_Sidebar($sidebar1);
        new AN_Sidebar($sidebar2);

        // SVG Icon class. ====> when using call
        new AN_SVG_Icons;

        // Custom color classes.
        new AN_Custom_Colors;

        // Enhance the theme by hooking into WordPress.
        new AN_Template_Function;

        // Menu functions and filters. ====> when using call
        new AN_Menu_Function;

        // Custom template tags for the theme.
        new AN_Template_Tag;

        // Customizer additions.
        // new AN_Customize;

        // Block Patterns.
        new AN_Block_Pattern;

        // Block Styles.
        new AN_Block_Styler;

        // Dark Mode.


        // Add class into body if browser is IE
        add_action('wp_footer', array($this, 'add_ie_class'));
    }

    /**
     * Add "is-IE" class to body if the user is on Internet Explorer.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @return void
     */
    function add_ie_class() {
?>
        <script>
            if (-1 !== navigator.userAgent.indexOf('MSIE') || -1 !== navigator.appVersion.indexOf('Trident/')) {
                document.body.classList.add('is-IE');
            }
        </script>
<?php
    }
}
