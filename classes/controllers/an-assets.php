<?php

/** 
 * Định nghĩa class chứa các cấu hình web - Web Assets (scripts, styles,...)
 */

class AN_Assets {

    // Thuộc tính
    private $assets_view;
    private $assets_support;

    // Phương thức
    public function __construct() {

        // Phần render assets liên quan đến view
        $this->assets_view = new AN_Assets_View;
        $this->assets_support = new AN_Support;

        // Add support for editor styles.
        $this->assets_support->add_support('editor-styles');

        // Fix Focus
        add_action("wp_print_footer_scripts", array($this, 'skip_link_focus_fix'));

        // Non Language style
        add_action('wp_enqueue_scripts', array($this,'non_latin_languages'));


        // Móc phương thức triển khai add_editor_styles của class vào action after_setup_theme
        add_action("after_setup_theme", array($this, 'add_editor_styles'));

        // Móc phần thêm scripts cho block editor
        add_action("enqueue_block_editor_assets", array($this, 'add_block_editor_script'));

        // Móc theme css và js
        add_action("wp_enqueue_scripts", array($this, 'add_theme_styles'));
        add_action("wp_enqueue_scripts", array($this, 'add_theme_scripts'));
    }

    /**
     * Enqueue non-latin language styles.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @return void
     */
    public function non_latin_languages() {
        $custom_css = AN_Template_Function::get_non_latin_css('front-end');

        if ($custom_css) {
            wp_add_inline_style('ttomvc-style', $custom_css);
        }
    }

    /**
     * Fix skip link focus in IE11.
     *
     * This does not enqueue the script because it is tiny and because it is only for IE11,
     * thus it does not warrant having an entire dedicated blocking script being loaded.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @link https://git.io/vWdr2
     */

    public function skip_link_focus_fix() {
        // If SCRIPT_DEBUG is defined and true, print the unminified file.
        if (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) {
            echo '<script>';
            include THEME_JS . '/skip-link-focus-fix.js';
            echo '</script>';
        } else {
            // The following is minified via `npx terser --compress --mangle -- assets/js/skip-link-focus-fix.js`.
?>
            <script>
                /(trident|msie)/i.test(navigator.userAgent) && document.getElementById && window.addEventListener && window.addEventListener("hashchange", (function() {
                    var t, e = location.hash.substring(1);
                    /^[A-z0-9_-]+$/.test(e) && (t = document.getElementById(e)) && (/^(?:a|select|input|button|textarea)$/i.test(t.tagName) || (t.tabIndex = -1), t.focus())
                }), !1);
            </script>
<?php
        }
    }

    /**
     * Enqueue scripts and styles.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @return void
     */
    public function add_theme_styles() {

        // Note, the is_IE global variable is defined by WordPress and is used
        // to detect if the current browser is internet explorer.

        global $is_IE;

        if ($is_IE) {
            // If IE 11 or below, use a flattened stylesheet with static values replacing CSS Variables.
            $this->assets_view->add_theme_css('ttomvc-style', THEME_CSS . '/ie.css');
        } else {
            // If not IE, use the standard stylesheet.            
            $this->assets_view->add_theme_css('ttomvc-style', THEME_CSS . '/style.css');
        }

        // RTL styles.
        wp_style_add_data('twenty-twenty-one-style', 'rtl', 'replace');

        // Print styles.
        $this->assets_view->add_theme_css('ttomvc-print-style', THEME_CSS . '/print.css', array(), wp_get_theme()->get('Version'), 'print');

        // Threaded comment reply styles.
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }

    // Theme Scripts
    public function add_theme_scripts() {

        global $wp_scripts;

        // Register the IE11 polyfill file.
        $this->assets_view->add_theme_js('ttomvc-ie11-polyfills-asset', THEME_JS . '/polyfills.js');

        // Register the IE11 polyfill loader.
        $this->assets_view->add_theme_js('ttomvc-ie11-polyfills', null);

        // Inline Scripts
        wp_add_inline_script(
            'ttomvc-ie11-polyfills',
            wp_get_script_polyfill(
                $wp_scripts,
                array(
                    'Element.prototype.matches && Element.prototype.closest && window.NodeList && NodeList.prototype.forEach' => 'twenty-twenty-one-ie11-polyfills-asset',
                )
            )
        );

        // Main navigation scripts.
        if (has_nav_menu('primary')) {
            $this->assets_view->add_theme_js(
                'ttomvc-primary-navigation-script',
                THEME_JS . '/primary-navigation.js',
                array('ttomvc-ie11-polyfills')
            );
        }

        // Responsive embeds script.
        $this->assets_view->add_theme_js(
            'ttomvc-responsive-embeds-script',
            THEME_JS . '/responsive-embeds.js',
            array('ttomvc-ie11-polyfills')
        );
    }

    /**
     * Enqueue block editor script.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @return void
     */
    public function add_block_editor_script() {

        $block_editor_script_path = THEME_JS . '/editor.js';

        // Enqueue block editor script.
        $this->assets_view->add_editor_css($block_editor_script_path);
    }

    // Hỗ trợ Editor Styles cho Theme
    public function add_editor_styles() {

        // Path CSS editor file
        $editor_stylesheet_path = THEME_CSS . '/style-editor.css';

        // Note, the is_IE global variable is defined by WordPress and is used
        // to detect if the current browser is internet explorer.
        global $is_IE;
        if ($is_IE) {
            $editor_stylesheet_path = THEME_CSS . '/ie-editor.css';
        }

        // Enqueue editor styles.
        $this->assets_view->add_editor_css($editor_stylesheet_path);
    }
}
