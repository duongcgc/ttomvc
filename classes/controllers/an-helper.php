<?php

/** 
 * Định nghĩa class Helper để hỗ trợ
 */

class AN_Helper {

    // Thuộc tính


    // Phương thức
    public function __construct() {

        // Thao tác khởi tạo
    }

    /**
     * Retrieves the list item separator based on the locale.
     *
     * Added for backward compatibility to support pre-6.0.0 WordPress versions.
     *
     * @since 6.0.0
     */
    public static function wp_get_list_item_separator() {
        /* translators: Used between list items, there is a space after the comma. */
        return __(', ', 'ttomvc');
    }

    /**
     * Calculate classes for the main <html> element.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @return void
     */
    public static function the_html_classes() {
        /**
         * Filters the classes for the main <html> element.
         *
         * @since Twenty Twenty-One 1.0
         *
         * @param string The list of classes. Default empty string.
         */
        $classes = apply_filters('twentytwentyone_html_classes', '');
        if (!$classes) {
            return;
        }
        echo 'class="' . esc_attr($classes) . '"';
    }
}
