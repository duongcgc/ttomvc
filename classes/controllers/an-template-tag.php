<?php

/** 
 * Định nghĩa class chứa các thành phần hỗ trợ sử dụng chung
 * Các template tags
 */

class AN_Template_Tag {

    // Thuộc tính

    // Phương thức

    public function __construct() {

        // Thao tác khi bắt đầu
    }

    /**
     * Custom template tags for this theme
     *
     * @package WordPress
     * @subpackage Twenty_Twenty_One
     * @since Twenty Twenty-One 1.0
     */

    /**
     * Print the next and previous posts navigation.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @return void
     */
    public static function the_posts_navigation() {
        the_posts_pagination(
            array(
                'before_page_number' => esc_html__('Page', 'twentytwentyone') . ' ',
                'mid_size'           => 0,
                'prev_text'          => sprintf(
                    '%s <span class="nav-prev-text">%s</span>',
                    is_rtl() ? AN_Template_Function::get_icon_svg('ui', 'arrow_right') : AN_Template_Function::get_icon_svg('ui', 'arrow_left'),
                    wp_kses(
                        __('Newer <span class="nav-short">posts</span>', 'twentytwentyone'),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    )
                ),
                'next_text'          => sprintf(
                    '<span class="nav-next-text">%s</span> %s',
                    wp_kses(
                        __('Older <span class="nav-short">posts</span>', 'twentytwentyone'),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    is_rtl() ? AN_Template_Function::get_icon_svg('ui', 'arrow_left') : AN_Template_Function::get_icon_svg('ui', 'arrow_right')
                ),
            )
        );
    }

    /**
     * Displays an optional post thumbnail.
     *
     * Wraps the post thumbnail in an anchor element on index views, or a div
     * element when on single views.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @return void
     */
    public static function post_thumbnail() {
        if (!AN_Template_Function::can_show_post_thumbnail()) {
            return;
        }
?>

        <?php if (is_singular()) : ?>

            <figure class="post-thumbnail">
                <?php
                // Lazy-loading attributes should be skipped for thumbnails since they are immediately in the viewport.
                the_post_thumbnail('post-thumbnail', array('loading' => false));
                ?>
                <?php if (wp_get_attachment_caption(get_post_thumbnail_id())) : ?>
                    <figcaption class="wp-caption-text"><?php echo wp_kses_post(wp_get_attachment_caption(get_post_thumbnail_id())); ?></figcaption>
                <?php endif; ?>
            </figure><!-- .post-thumbnail -->

        <?php else : ?>

            <figure class="post-thumbnail">
                <a class="post-thumbnail-inner alignwide" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                    <?php the_post_thumbnail('post-thumbnail'); ?>
                </a>
                <?php if (wp_get_attachment_caption(get_post_thumbnail_id())) : ?>
                    <figcaption class="wp-caption-text"><?php echo wp_kses_post(wp_get_attachment_caption(get_post_thumbnail_id())); ?></figcaption>
                <?php endif; ?>
            </figure><!-- .post-thumbnail -->

        <?php endif; ?>
<?php
    }

    /**
     * Prints HTML with meta information for the current post-date/time.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @return void
     */
    public static function posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

        $time_string = sprintf(
            $time_string,
            esc_attr(get_the_date(DATE_W3C)),
            esc_html(get_the_date())
        );
        echo '<span class="posted-on">';
        printf(
            /* translators: %s: Publish date. */
            esc_html__('Published %s', 'twentytwentyone'),
            $time_string // phpcs:ignore WordPress.Security.EscapeOutput
        );
        echo '</span>';
    }

    /**
     * Prints HTML with meta information about theme author.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @return void
     */
    public static function posted_by() {
        if (!get_the_author_meta('description') && post_type_supports(get_post_type(), 'author')) {
            echo '<span class="byline">';
            printf(
                /* translators: %s: Author name. */
                esc_html__('By %s', 'twentytwentyone'),
                '<a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '" rel="author">' . esc_html(get_the_author()) . '</a>'
            );
            echo '</span>';
        }
    }

    /**
     * Prints HTML with meta information for the categories, tags and comments.
     * Footer entry meta is displayed differently in archives and single posts.
     *
     * @since Twenty Twenty-One 1.0
     *
     * @return void
     */
    public static function entry_meta_footer() {

        // Early exit if not a post.
        if ('post' !== get_post_type()) {
            return;
        }

        // Hide meta information on pages.
        if (!is_single()) {

            if (is_sticky()) {
                echo '<p>' . esc_html_x('Featured post', 'Label for sticky posts', 'twentytwentyone') . '</p>';
            }

            $post_format = get_post_format();
            if ('aside' === $post_format || 'status' === $post_format) {
                echo '<p><a href="' . esc_url(get_permalink()) . '">' . twenty_twenty_one_continue_reading_text() . '</a></p>'; // phpcs:ignore WordPress.Security.EscapeOutput
            }

            // Posted on.
            self::posted_on();

            // Edit post link.
            edit_post_link(
                sprintf(
                    /* translators: %s: Post title. Only visible to screen readers. */
                    esc_html__('Edit %s', 'twentytwentyone'),
                    '<span class="screen-reader-text">' . get_the_title() . '</span>'
                ),
                '<span class="edit-link">',
                '</span><br>'
            );

            if (has_category() || has_tag()) {

                echo '<div class="post-taxonomies">';

                $categories_list = get_the_category_list(wp_get_list_item_separator());
                if ($categories_list) {
                    printf(
                        /* translators: %s: List of categories. */
                        '<span class="cat-links">' . esc_html__('Categorized as %s', 'twentytwentyone') . ' </span>',
                        $categories_list // phpcs:ignore WordPress.Security.EscapeOutput
                    );
                }

                $tags_list = get_the_tag_list('', wp_get_list_item_separator());
                if ($tags_list) {
                    printf(
                        /* translators: %s: List of tags. */
                        '<span class="tags-links">' . esc_html__('Tagged %s', 'twentytwentyone') . '</span>',
                        $tags_list // phpcs:ignore WordPress.Security.EscapeOutput
                    );
                }
                echo '</div>';
            }
        } else {

            echo '<div class="posted-by">';
            // Posted on.
            self::posted_on();
            // Posted by.
            self::posted_by();
            // Edit post link.
            edit_post_link(
                sprintf(
                    /* translators: %s: Post title. Only visible to screen readers. */
                    esc_html__('Edit %s', 'twentytwentyone'),
                    '<span class="screen-reader-text">' . get_the_title() . '</span>'
                ),
                '<span class="edit-link">',
                '</span>'
            );
            echo '</div>';

            if (has_category() || has_tag()) {

                echo '<div class="post-taxonomies">';

                $categories_list = get_the_category_list(AN_Helper::wp_get_list_item_separator());
                if ($categories_list) {
                    printf(
                        /* translators: %s: List of categories. */
                        '<span class="cat-links">' . esc_html__('Categorized as %s', 'twentytwentyone') . ' </span>',
                        $categories_list // phpcs:ignore WordPress.Security.EscapeOutput
                    );
                }

                $tags_list = get_the_tag_list('', AN_Helper::wp_get_list_item_separator());
                if ($tags_list) {
                    printf(
                        /* translators: %s: List of tags. */
                        '<span class="tags-links">' . esc_html__('Tagged %s', 'twentytwentyone') . '</span>',
                        $tags_list // phpcs:ignore WordPress.Security.EscapeOutput
                    );
                }
                echo '</div>';
            }
        }
    }
}
