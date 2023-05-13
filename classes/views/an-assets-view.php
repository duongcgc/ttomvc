<?php

/** 
 * Định nghĩa class views cho assets
 */

class AN_Assets_View {

    // Thuộc tính
    public function __construct() {
    }

    // Add Theme CSS
    public function add_theme_css($css_name, $css_file, $css_depend = array(), $css_version = false, $css_media = 'all') {

        if (!$css_version) {
            wp_enqueue_style($css_name, $css_file, $css_depend, wp_get_theme()->get('Version'), $css_media);
        } else {
            wp_enqueue_style($css_name, $css_file, $css_depend, $css_version, $css_media);
        }

        return $this;
    }

    // ADD Theme JS
    public function add_theme_js($js_name, $js_file, $js_depend = array(), $js_version = false, $at_footer = true) {

        if (!$js_version) {
            wp_register_script($js_name, $js_file, $js_depend, wp_get_theme()->get('Version'), $at_footer);
        } else {
            wp_register_script($js_name, $js_file, $js_depend, $js_version, $at_footer);
        }

        return $this;
    }

    // Add Editor CSS
    public function add_editor_css($css_file) {
        add_editor_style($css_file);
    }

    // Add Editor JS
    public function add_block_editor_js($js_file) {
        wp_enqueue_script('ttomvc-editor', $js_file, array('wp-blocks', 'wp-dom'), wp_get_theme()->get('Version'), true);
    }
}
