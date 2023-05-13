<?php

/** 
 * Định nghĩa class chứa các thành phần hỗ trợ sử dụng chung
 * Các template functions
 */

/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

class AN_Template_Function {

    // Thuộc tính

    // Phương thức
    public function __construct() {

        // Add body classes
        add_filter('body_class', array($this, 'an_body_classes'));

        // Add post classes
        add_filter('post_class', array($this, 'an_post_classes'), 10, 3);

        // Add pingback
        add_action('wp_head', array($this, 'an_pingback_header'));

        // Remove no-js class
        add_action('wp_footer', array($this, 'an_supports_js'));

        // Change comments form
        add_filter('comment_form_defaults', array($this, 'an_comment_form_defaults'));


        // Filter the excerpt more link.
        add_filter('excerpt_more', array($this, 'an_continue_reading_link_excerpt'));


        // Filter the content more link.
        add_filter('the_content_more_link', array($this, 'an_continue_reading_link'));

        // Title
        add_filter('the_title', array($this, 'an_post_title'));

        // Change calendar nav arrow
        add_filter('get_calendar', array($this, 'an_change_calendar_nav_arrows'));

        // Password Form
        add_filter('the_password_form', array($this, 'an_password_form'), 10, 2);

        // Attachment Image
        add_filter('wp_get_attachment_image_attributes', array($this, 'an_get_attachment_image_attributes'), 10, 3);
    }

    /**
     * Filters the list of attachment image attributes.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @param string[]     $attr       Array of attribute values for the image markup, keyed by attribute name.
     *                                 See wp_get_attachment_image().
     * @param WP_Post      $attachment Image attachment post.
     * @param string|int[] $size       Requested image size. Can be any registered image size name, or
     *                                 an array of width and height values in pixels (in that order).
     * @return string[] The filtered attributes for the image markup.
     */
    function an_get_attachment_image_attributes($attr, $attachment, $size) {

        if (is_admin()) {
            return $attr;
        }

        if (isset($attr['class']) && false !== strpos($attr['class'], 'custom-logo')) {
            return $attr;
        }

        $width  = false;
        $height = false;

        if (is_array($size)) {
            $width  = (int) $size[0];
            $height = (int) $size[1];
        } elseif ($attachment && is_object($attachment) && $attachment->ID) {
            $meta = wp_get_attachment_metadata($attachment->ID);
            if (isset($meta['width']) && isset($meta['height'])) {
                $width  = (int) $meta['width'];
                $height = (int) $meta['height'];
            }
        }

        if ($width && $height) {

            // Add style.
            $attr['style'] = isset($attr['style']) ? $attr['style'] : '';
            $attr['style'] = 'width:100%;height:' . round(100 * $height / $width, 2) . '%;max-width:' . $width . 'px;' . $attr['style'];
        }

        return $attr;
    }

    /**
     * Retrieve protected post password form content.
     *
     * @since Twenty Twenty-One 1.0
     * @since Twenty Twenty-One 1.4 Corrected parameter name for `$output`,
     *                              added the `$post` parameter.
     *
     * @param string      $output The password form HTML output.
     * @param int|WP_Post $post   Optional. Post ID or WP_Post object. Default is global $post.
     * @return string HTML content for password form for password protected post.
     */
    function an_password_form($output, $post = 0) {
        $post   = get_post($post);
        $label  = 'pwbox-' . (empty($post->ID) ? wp_rand() : $post->ID);
        $output = '<p class="post-password-message">' . esc_html__('This content is password protected. Please enter a password to view.', 'twentytwentyone') . '</p>
	<form action="' . esc_url(site_url('wp-login.php?action=postpass', 'login_post')) . '" class="post-password-form" method="post">
	<label class="post-password-form__label" for="' . esc_attr($label) . '">' . esc_html_x('Password', 'Post password form', 'twentytwentyone') . '</label><input class="post-password-form__input" name="post_password" id="' . esc_attr($label) . '" type="password" spellcheck="false" size="20" /><input type="submit" class="post-password-form__submit" name="' . esc_attr_x('Submit', 'Post password form', 'twentytwentyone') . '" value="' . esc_attr_x('Enter', 'Post password form', 'twentytwentyone') . '" /></form>
	';
        return $output;
    }

    /**
     * Print the first instance of a block in the content, and then break away.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @param string      $block_name The full block type name, or a partial match.
     *                                Example: `core/image`, `core-embed/*`.
     * @param string|null $content    The content to search in. Use null for get_the_content().
     * @param int         $instances  How many instances of the block will be printed (max). Default  1.
     * @return bool Returns true if a block was located & printed, otherwise false.
     */
    public static function print_first_instance_of_block($block_name, $content = null, $instances = 1) {
        $instances_count = 0;
        $blocks_content  = '';

        if (!$content) {
            $content = get_the_content();
        }

        // Parse blocks in the content.
        $blocks = parse_blocks($content);

        // Loop blocks.
        foreach ($blocks as $block) {

            // Sanity check.
            if (!isset($block['blockName'])) {
                continue;
            }

            // Check if this the block matches the $block_name.
            $is_matching_block = false;

            // If the block ends with *, try to match the first portion.
            if ('*' === $block_name[-1]) {
                $is_matching_block = 0 === strpos($block['blockName'], rtrim($block_name, '*'));
            } else {
                $is_matching_block = $block_name === $block['blockName'];
            }

            if ($is_matching_block) {
                // Increment count.
                $instances_count++;

                // Add the block HTML.
                $blocks_content .= render_block($block);

                // Break the loop if the $instances count was reached.
                if ($instances_count >= $instances) {
                    break;
                }
            }
        }

        if ($blocks_content) {
            /** This filter is documented in wp-includes/post-template.php */
            echo apply_filters('the_content', $blocks_content); // phpcs:ignore WordPress.Security.EscapeOutput
            return true;
        }

        return false;
    }

    /**
     * Changes the default navigation arrows to svg icons
     *
     * @since Twenty Twenty-One 1.0
     *
     * @param string $calendar_output The generated HTML of the calendar.
     * @return string
     */
    function an_change_calendar_nav_arrows($calendar_output) {
        $calendar_output = str_replace('&laquo; ', is_rtl() ? self::get_icon_svg('ui', 'arrow_right') : self::get_icon_svg('ui', 'arrow_left'), $calendar_output);
        $calendar_output = str_replace(' &raquo;', is_rtl() ? self::get_icon_svg('ui', 'arrow_left') : self::get_icon_svg('ui', 'arrow_right'), $calendar_output);
        return $calendar_output;
    }

    /**
     * Gets the SVG code for a given icon.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @param string $group The icon group.
     * @param string $icon  The icon.
     * @param int    $size  The icon size in pixels.
     * @return string
     */
    public static function get_icon_svg($group, $icon, $size = 24) {
        return AN_SVG_Icons::get_svg($group, $icon, $size);
    }

    /**
     * Adds a title to posts and pages that are missing titles.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @param string $title The title.
     * @return string
     */
    function an_post_title($title) {
        return '' === $title ? esc_html_x('Untitled', 'Added to posts and pages that are missing titles', 'twentytwentyone') : $title;
    }


    /**
     * Creates the continue reading link.
     *
     * @since Twenty Twenty-One 1.0
     */
    function an_continue_reading_link() {
        if (!is_admin()) {
            return '<div class="more-link-container"><a class="more-link" href="' . esc_url(get_permalink()) . '#more-' . esc_attr(get_the_ID()) . '">' . twenty_twenty_one_continue_reading_text() . '</a></div>';
        }
    }

    /**
     * Creates the continue reading link for excerpt.
     *
     * @since Twenty Twenty-One 1.0
     */
    public function an_continue_reading_link_excerpt() {
        if (!is_admin()) {
            return '&hellip; <a class="more-link" href="' . esc_url(get_permalink()) . '">' . twenty_twenty_one_continue_reading_text() . '</a>';
        }
    }

    /**
     * Creates continue reading text.
     *
     * @since Twenty Twenty-One 1.0
     */
    public static function continue_reading_text() {
        $continue_reading = sprintf(
            /* translators: %s: Post title. Only visible to screen readers. */
            esc_html__('Continue reading %s', 'twentytwentyone'),
            the_title('<span class="screen-reader-text">', '</span>', false)
        );

        return $continue_reading;
    }

    /**
     * Returns the size for avatars used in the theme.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @return int
     */
    public static function get_avatar_size() {
        return 60;
    }

    /**
     * Determines if post thumbnail can be displayed.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @return bool
     */
    public static function can_show_post_thumbnail() {
        /**
         * Filters whether post thumbnail can be displayed.
         *
         * @since Twenty Twenty-One 1.0
         *
         * @param bool $show_post_thumbnail Whether to show post thumbnail.
         */
        return apply_filters(
            'twenty_twenty_one_can_show_post_thumbnail',
            !post_password_required() && !is_attachment() && has_post_thumbnail()
        );
    }

    /**
     * Changes comment form default fields.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @param array $defaults The form defaults.
     * @return array
     */
    public function an_comment_form_defaults($defaults) {

        // Adjust height of comment form.
        $defaults['comment_field'] = preg_replace('/rows="\d+"/', 'rows="5"', $defaults['comment_field']);

        return $defaults;
    }

    /**
     * Remove the `no-js` class from body if JS is supported.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @return void
     */
    public function an_supports_js() {
        echo '<script>document.body.classList.remove("no-js");</script>';
    }

    /**
     * Add a pingback url auto-discovery header for single posts, pages, or attachments.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @return void
     */
    public function an_pingback_header() {
        if (is_singular() && pings_open()) {
            echo '<link rel="pingback" href="', esc_url(get_bloginfo('pingback_url')), '">';
        }
    }

    /**
     * Adds custom class to the array of posts classes.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @param array $classes An array of CSS classes.
     * @return array
     */
    public function an_post_classes($classes) {
        $classes[] = 'entry';

        return $classes;
    }

    /**
     * Adds custom classes to the array of body classes.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @param array $classes Classes for the body element.
     * @return array
     */
    public function an_body_classes($classes) {

        // Helps detect if JS is enabled or not.
        $classes[] = 'no-js';

        // Adds `singular` to singular pages, and `hfeed` to all other pages.
        $classes[] = is_singular() ? 'singular' : 'hfeed';

        // Add a body class if main navigation is active.
        if (has_nav_menu('primary')) {
            $classes[] = 'has-main-navigation';
        }

        // Add a body class if there are no footer widgets.
        if (!is_active_sidebar('sidebar-1')) {
            $classes[] = 'no-widgets';
        }

        return $classes;
    }

    /**
     * Get custom CSS.
     *
     * Return CSS for non-latin language, if available, or null
     *
     * @since Twenty Twenty-One 1.0
     *
     * @param string $type Whether to return CSS for the "front-end", "block-editor", or "classic-editor".
     * @return string
     */
    public static function get_non_latin_css($type = 'front-end') {

        // Fetch site locale.
        $locale = get_bloginfo('language');

        /**
         * Filters the fallback fonts for non-latin languages.
         *
         * @since Twenty Twenty-One 1.0
         *
         * @param array $font_family An array of locales and font families.
         */
        $font_family = apply_filters(
            'twenty_twenty_one_get_localized_font_family_types',
            array(

                // Arabic.
                'ar'    => array('Tahoma', 'Arial', 'sans-serif'),
                'ary'   => array('Tahoma', 'Arial', 'sans-serif'),
                'azb'   => array('Tahoma', 'Arial', 'sans-serif'),
                'ckb'   => array('Tahoma', 'Arial', 'sans-serif'),
                'fa-IR' => array('Tahoma', 'Arial', 'sans-serif'),
                'haz'   => array('Tahoma', 'Arial', 'sans-serif'),
                'ps'    => array('Tahoma', 'Arial', 'sans-serif'),

                // Chinese Simplified (China) - Noto Sans SC.
                'zh-CN' => array('\'PingFang SC\'', '\'Helvetica Neue\'', '\'Microsoft YaHei New\'', '\'STHeiti Light\'', 'sans-serif'),

                // Chinese Traditional (Taiwan) - Noto Sans TC.
                'zh-TW' => array('\'PingFang TC\'', '\'Helvetica Neue\'', '\'Microsoft YaHei New\'', '\'STHeiti Light\'', 'sans-serif'),

                // Chinese (Hong Kong) - Noto Sans HK.
                'zh-HK' => array('\'PingFang HK\'', '\'Helvetica Neue\'', '\'Microsoft YaHei New\'', '\'STHeiti Light\'', 'sans-serif'),

                // Cyrillic.
                'bel'   => array('\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif'),
                'bg-BG' => array('\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif'),
                'kk'    => array('\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif'),
                'mk-MK' => array('\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif'),
                'mn'    => array('\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif'),
                'ru-RU' => array('\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif'),
                'sah'   => array('\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif'),
                'sr-RS' => array('\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif'),
                'tt-RU' => array('\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif'),
                'uk'    => array('\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif'),

                // Devanagari.
                'bn-BD' => array('Arial', 'sans-serif'),
                'hi-IN' => array('Arial', 'sans-serif'),
                'mr'    => array('Arial', 'sans-serif'),
                'ne-NP' => array('Arial', 'sans-serif'),

                // Greek.
                'el'    => array('\'Helvetica Neue\', Helvetica, Arial, sans-serif'),

                // Gujarati.
                'gu'    => array('Arial', 'sans-serif'),

                // Hebrew.
                'he-IL' => array('\'Arial Hebrew\'', 'Arial', 'sans-serif'),

                // Japanese.
                'ja'    => array('sans-serif'),

                // Korean.
                'ko-KR' => array('\'Apple SD Gothic Neo\'', '\'Malgun Gothic\'', '\'Nanum Gothic\'', 'Dotum', 'sans-serif'),

                // Thai.
                'th'    => array('\'Sukhumvit Set\'', '\'Helvetica Neue\'', 'Helvetica', 'Arial', 'sans-serif'),

                // Vietnamese.
                'vi'    => array('\'Libre Franklin\'', 'sans-serif'),

            )
        );

        // Return if the selected language has no fallback fonts.
        if (empty($font_family[$locale])) {
            return '';
        }

        /**
         * Filters the elements to apply fallback fonts to.
         *
         * @since Twenty Twenty-One 1.0
         *
         * @param array $elements An array of elements for "front-end", "block-editor", or "classic-editor".
         */
        $elements = apply_filters(
            'twenty_twenty_one_get_localized_font_family_elements',
            array(
                'front-end'      => array('body', 'input', 'textarea', 'button', '.button', '.faux-button', '.wp-block-button__link', '.wp-block-file__button', '.has-drop-cap:not(:focus)::first-letter', '.entry-content .wp-block-archives', '.entry-content .wp-block-categories', '.entry-content .wp-block-cover-image', '.entry-content .wp-block-latest-comments', '.entry-content .wp-block-latest-posts', '.entry-content .wp-block-pullquote', '.entry-content .wp-block-quote.is-large', '.entry-content .wp-block-quote.is-style-large', '.entry-content .wp-block-archives *', '.entry-content .wp-block-categories *', '.entry-content .wp-block-latest-posts *', '.entry-content .wp-block-latest-comments *', '.entry-content p', '.entry-content ol', '.entry-content ul', '.entry-content dl', '.entry-content dt', '.entry-content cite', '.entry-content figcaption', '.entry-content .wp-caption-text', '.comment-content p', '.comment-content ol', '.comment-content ul', '.comment-content dl', '.comment-content dt', '.comment-content cite', '.comment-content figcaption', '.comment-content .wp-caption-text', '.widget_text p', '.widget_text ol', '.widget_text ul', '.widget_text dl', '.widget_text dt', '.widget-content .rssSummary', '.widget-content cite', '.widget-content figcaption', '.widget-content .wp-caption-text'),
                'block-editor'   => array('.editor-styles-wrapper > *', '.editor-styles-wrapper p', '.editor-styles-wrapper ol', '.editor-styles-wrapper ul', '.editor-styles-wrapper dl', '.editor-styles-wrapper dt', '.editor-post-title__block .editor-post-title__input', '.editor-styles-wrapper .wp-block h1', '.editor-styles-wrapper .wp-block h2', '.editor-styles-wrapper .wp-block h3', '.editor-styles-wrapper .wp-block h4', '.editor-styles-wrapper .wp-block h5', '.editor-styles-wrapper .wp-block h6', '.editor-styles-wrapper .has-drop-cap:not(:focus)::first-letter', '.editor-styles-wrapper cite', '.editor-styles-wrapper figcaption', '.editor-styles-wrapper .wp-caption-text'),
                'classic-editor' => array('body#tinymce.wp-editor', 'body#tinymce.wp-editor p', 'body#tinymce.wp-editor ol', 'body#tinymce.wp-editor ul', 'body#tinymce.wp-editor dl', 'body#tinymce.wp-editor dt', 'body#tinymce.wp-editor figcaption', 'body#tinymce.wp-editor .wp-caption-text', 'body#tinymce.wp-editor .wp-caption-dd', 'body#tinymce.wp-editor cite', 'body#tinymce.wp-editor table'),
            )
        );

        // Return if the specified type doesn't exist.
        if (empty($elements[$type])) {
            return '';
        }

        // Include file if function doesn't exist.
        // if (!function_exists('twenty_twenty_one_generate_css')) {
        //     require_once get_theme_file_path('inc/custom-css.php'); // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
        // }

        // Return the specified styles.
        return AN_Template_Function_View::generate_css( // @phpstan-ignore-line.
            implode(',', $elements[$type]),
            'font-family',
            implode(',', $font_family[$locale]),
            null,
            null,
            false
        );
    }
}
