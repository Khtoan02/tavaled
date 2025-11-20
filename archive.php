<?php
/**
 * The template for displaying archive pages
 *
 * @package TavaLED
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="blog-archive-header">
            <div class="container">
                <?php tavaled_breadcrumbs(); ?>
                <p class="archive-eyebrow"><?php esc_html_e('Danh sách nội dung', 'tavaled-theme'); ?></p>
                <h1 class="archive-title">
                    <?php echo esc_html(tavaled_get_archive_title()); ?>
                </h1>
                <?php the_archive_description('<div class="archive-description">', '</div>'); ?>
            </div>
        </div>

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