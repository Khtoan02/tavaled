<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 *
 * @package TavaLED
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php if (!is_front_page()) : ?>
            <div class="blog-archive-header">
                <div class="container">
                    <?php tavaled_breadcrumbs(); ?>
                    <p class="archive-eyebrow"><?php esc_html_e('Tin tức & chia sẻ', 'tavaled-theme'); ?></p>
                    <h1 class="archive-title">
                        <?php
                        if (is_home() && !is_front_page()) {
                            echo esc_html(single_post_title('', false));
                        } elseif (is_archive()) {
                            the_archive_title();
                        } elseif (is_search()) {
                            echo wp_kses(
                                sprintf(
                                    __('Kết quả tìm kiếm cho: %s', 'tavaled-theme'),
                                    '<span>' . esc_html(get_search_query()) . '</span>'
                                ),
                                array('span' => array())
                            );
                        } elseif (is_404()) {
                            esc_html_e('Oops! Không tìm thấy trang.', 'tavaled-theme');
                        } else {
                            echo esc_html(get_bloginfo('name'));
                        }
                        ?>
                    </h1>
                    <?php if (is_archive()) : ?>
                        <div class="archive-description">
                            <?php the_archive_description(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="container blog-loop-container">
            <?php
            set_query_var('tavaled_blog_pagination', array(
                'prev_text' => __('&laquo; Trước', 'tavaled-theme'),
                'next_text' => __('Sau &raquo;', 'tavaled-theme'),
            ));
            get_template_part('template-parts/blog', 'loop');
            ?>
        </div><!-- .container -->
    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();