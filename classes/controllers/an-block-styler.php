<?php

/** 
 * Định nghĩa class base cho các block style 
 * Các block style tạo ra các tùy chọn cho block
 */

class AN_Block_Styler {

    // Thuộc tính
    protected $model;       // data của block style
    protected $view;        // view của block style


    // Khởi tạo
    public function __construct() {

        // Thao tác khi khởi tạo block style   
        /**
         * Block Styles
         *
         * @link https://developer.wordpress.org/reference/functions/register_block_style/
         *
         * @package WordPress
         * @subpackage Twenty_Twenty_One
         * @since Twenty Twenty-One 1.0
         */

        if (function_exists('register_block_style')) {
            /**
             * Register block styles.
             *
             * @since Twenty Twenty-One 1.0
             *
             * @return void
             */

            add_action('init', array($this, 'an_register_block_styles'));
        }
    }

    // Đăng ký block styles
    function an_register_block_styles() {
        // Columns: Overlap.
        register_block_style(
            'core/columns',
            array(
                'name'  => 'twentytwentyone-columns-overlap',
                'label' => esc_html__('Overlap', 'ttomvc'),
            )
        );

        // Cover: Borders.
        register_block_style(
            'core/cover',
            array(
                'name'  => 'twentytwentyone-border',
                'label' => esc_html__('Borders', 'ttomvc'),
            )
        );

        // Group: Borders.
        register_block_style(
            'core/group',
            array(
                'name'  => 'twentytwentyone-border',
                'label' => esc_html__('Borders', 'ttomvc'),
            )
        );

        // Image: Borders.
        register_block_style(
            'core/image',
            array(
                'name'  => 'twentytwentyone-border',
                'label' => esc_html__('Borders', 'ttomvc'),
            )
        );

        // Image: Frame.
        register_block_style(
            'core/image',
            array(
                'name'  => 'twentytwentyone-image-frame',
                'label' => esc_html__('Frame', 'ttomvc'),
            )
        );

        // Latest Posts: Dividers.
        register_block_style(
            'core/latest-posts',
            array(
                'name'  => 'twentytwentyone-latest-posts-dividers',
                'label' => esc_html__('Dividers', 'ttomvc'),
            )
        );

        // Latest Posts: Borders.
        register_block_style(
            'core/latest-posts',
            array(
                'name'  => 'twentytwentyone-latest-posts-borders',
                'label' => esc_html__('Borders', 'ttomvc'),
            )
        );

        // Media & Text: Borders.
        register_block_style(
            'core/media-text',
            array(
                'name'  => 'twentytwentyone-border',
                'label' => esc_html__('Borders', 'ttomvc'),
            )
        );

        // Separator: Thick.
        register_block_style(
            'core/separator',
            array(
                'name'  => 'twentytwentyone-separator-thick',
                'label' => esc_html__('Thick', 'ttomvc'),
            )
        );

        // Social icons: Dark gray color.
        register_block_style(
            'core/social-links',
            array(
                'name'  => 'twentytwentyone-social-icons-color',
                'label' => esc_html__('Dark gray', 'ttomvc'),
            )
        );
    }
}
