<?php
/**
 * The template for displaying category archive pages
 *
 * @package TavaLED
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="container blog-loop-container">
            <div class="category-simple-header">
                <?php tavaled_breadcrumbs(); ?>
                <h1 class="category-simple-title"><?php single_cat_title(); ?></h1>
                <?php
                $category_description = category_description();
                if (!empty($category_description)) :
                    ?>
                    <div class="category-simple-description">
                        <?php echo wp_kses_post($category_description); ?>
                    </div>
                    <?php
                endif;
                ?>
            </div>

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