<?php

/** 
 * Định nghĩa class base cho các menu
 */

class AN_Menu_Function {

    // Thuộc tính    
    private $menu_view;        // view của controller


    // Khởi tạo
    public function __construct() {

        // Thao tác khi khởi tạo menu   
        $this->menu_view = new AN_Menu_View;

        add_filter('walker_nav_menu_start_el', [$this, 'an_add_sub_menu_toggle'], 10, 4);
        add_filter('walker_nav_menu_start_el', [$this, 'an_nav_menu_social_icons'], 10, 4);
        add_filter('nav_menu_item_args', [$this, 'an_add_menu_description_args'], 10, 3);
    }

    /**
     * Filters the arguments for a single nav menu item.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @param stdClass $args  An object of wp_nav_menu() arguments.
     * @param WP_Post  $item  Menu item data object.
     * @param int      $depth Depth of menu item. Used for padding.
     * @return stdClass
     */
    function an_add_menu_description_args($args, $item, $depth) {

        $args = $this->menu_view->add_description_args($args, $item, $depth);

        return $args;
    }

    /**
     * Displays SVG icons in the footer navigation.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @param string   $item_output The menu item's starting HTML output.
     * @param WP_Post  $item        Menu item data object.
     * @param int      $depth       Depth of the menu. Used for padding.
     * @param stdClass $args        An object of wp_nav_menu() arguments.
     * @return string The menu item output with social icon.
     */
    function an_nav_menu_social_icons($item_output, $item, $depth, $args) {

        $item_output = $this->menu_view->nav_menu_social_icons($item_output, $item, $depth, $args);

        return $item_output;
    }

    /**
     * Detects the social network from a URL and returns the SVG code for its icon.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @param string $uri  Social link.
     * @param int    $size The icon size in pixels.
     * @return string
     */
    function get_social_link_svg($uri, $size = 24) {
        return AN_SVG_Icons::get_social_link_svg($uri, $size);
    }

    /**
     * Functions and filters related to the menus.
     *
     * Makes the default WordPress navigation use an HTML structure similar
     * to the Navigation block.
     *
     * @link https://make.wordpress.org/themes/2020/07/06/printing-navigation-block-html-from-a-legacy-menu-in-themes/
     *
     * @package WordPress
     * @subpackage Twenty_Twenty_One
     * @since Twenty Twenty-One 1.0
     */

    /**
     * Add a button to top-level menu items that has sub-menus.
     * An icon is added using CSS depending on the value of aria-expanded.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @param string $output Nav menu item start element.
     * @param object $item   Nav menu item.
     * @param int    $depth  Depth.
     * @param object $args   Nav menu args.
     * @return string Nav menu item start element.
     */
    function an_add_sub_menu_toggle($output, $item, $depth, $args) {

        $output = $this->menu_view->nav_menu_social_icons($output, $item, $depth, $args);

        return $output;
    }
}
