<?php

/** 
 * Định nghĩa class base cho các menu view
 */

class AN_Menu_View {

    // Thuộc tính


    // Khởi tạo
    public function __construct() {

        // Thao tác khi khởi tạo menu view

    }

    // Add Description for menu
    public function add_description_args($args, $item, $depth) {
        if ('</span>' !== $args->link_after) {
            $args->link_after = '';
        }

        if (0 === $depth && isset($item->description) && $item->description) {
            // The extra <span> element is here for styling purposes: Allows the description to not be underlined on hover.
            $args->link_after = '<p class="menu-item-description"><span>' . $item->description . '</span></p>';
        }

        return $args;
    }

    // Nav Menu Social Icons
    function nav_menu_social_icons($item_output, $item, $depth, $args) {
        // Change SVG icon inside social links menu if there is supported URL.
        if ('footer' === $args->theme_location) {
            $svg = twenty_twenty_one_get_social_link_svg($item->url, 24);
            if (!empty($svg)) {
                $item_output = str_replace($args->link_before, $svg, $item_output);
            }
        }

        return $item_output;
    }

    // Add submenu
    function add_sub_menu_toggle($output, $item, $depth, $args) {
        if (0 === $depth && in_array('menu-item-has-children', $item->classes, true)) {

            // Add toggle button.
            $output .= '<button class="sub-menu-toggle" aria-expanded="false" onClick="twentytwentyoneExpandSubMenu(this)">';
            $output .= '<span class="icon-plus">' . twenty_twenty_one_get_icon_svg('ui', 'plus', 18) . '</span>';
            $output .= '<span class="icon-minus">' . twenty_twenty_one_get_icon_svg('ui', 'minus', 18) . '</span>';
            /* translators: Hidden accessibility text. */
            $output .= '<span class="screen-reader-text">' . esc_html__('Open menu', 'twentytwentyone') . '</span>';
            $output .= '</button>';
        }
        return $output;
    }
}
