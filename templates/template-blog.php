<?php
/**
 * Template Name: Blog Posts
 * Description: Template for displaying all published blog posts
 *
 * @package TavaLED
 */

get_header();

// Query published posts
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$blog_query = new WP_Query(array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 9,
    'paged' => $paged,
    'orderby' => 'date',
    'order' => 'DESC',
));
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="blog-loop-container container">
            <?php
            set_query_var('tavaled_blog_query', $blog_query);
            set_query_var('tavaled_blog_pagination', array(
                'prev_text' => __('&laquo; Trước', 'tavaled-theme'),
                'next_text' => __('Sau &raquo;', 'tavaled-theme'),
                'end_size' => 2,
                'mid_size' => 1,
            ));
            get_template_part('template-parts/blog', 'loop');
            ?>
        </div><!-- .container -->
    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();

