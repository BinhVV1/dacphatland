<?php
/**
 * The template for displaying search results pages.
 *
 * @package WordPress
 * @subpackage Nerf
 * @since Nerf 1.0
 */

get_header();
$sidebar_configs = nerf_get_blog_layout_configs();

$columns = nerf_get_config('blog_columns', 1);
$bscol = floor( 12 / $columns );
$checksidebar = (nerf_get_config('blog_single_layout') == 'main') ? 'blog-only-main style-' . ($layout ?? "") : 'has-sidebar';
nerf_render_breadcrumbs();

// Custom query to only get 'post' type results
$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
$custom_query = new WP_Query( array(
    'post_type' => 'post',
    'paged'     => $paged,
    's'         => get_search_query(),
) );
?>
<section id="main-container" class="main-content <?php echo esc_attr($checksidebar); ?> <?php echo apply_filters('nerf_blog_content_class', 'container'); ?> inner">
    
    <a href="javascript:void(0)" class="mobile-sidebar-btn d-lg-none btn-right"> <i class="ti-menu-alt"></i></a>
    <div class="mobile-sidebar-panel-overlay"></div>
    <div class="row responsive-medium">
        <div id="main-content" class="col-12 <?php echo esc_attr(is_active_sidebar('sidebar-default') ? 'col-lg-8' : ''); ?>">
            <main id="main" class="site-main layout-blog" role="main">

            <?php if ( $custom_query->have_posts() ) : ?>

                <header class="page-header hidden">
                    <?php
                        the_archive_title( '<h1 class="page-title">', '</h1>' );
                        the_archive_description( '<div class="taxonomy-description">', '</div>' );
                    ?>
                </header><!-- .page-header -->
                <div class="layout-posts-list list-search">
                    <?php
                    // Start the Loop.
                    while ( $custom_query->have_posts() ) : $custom_query->the_post();

                        if ( get_post_type() === 'post' ) {
                            get_template_part( 'content', 'search' );
                        }
                    endwhile;
                    ?>
                </div>

                <?php 
                // Previous/next page navigation.
                nerf_paging_nav( $custom_query );

                // Reset postdata after the loop
                wp_reset_postdata();

            else :
                get_template_part( 'template-posts/content', 'none' );

            endif;
            ?>

            </main><!-- .site-main -->
        </div><!-- .content-area -->
        <?php if ( is_active_sidebar( 'sidebar-default' ) ): ?>
            <div class="col-lg-4 col-12 sidebar-wrapper sidebar-blog">
                <div class="sidebar sidebar-right">
                    
                    <?php dynamic_sidebar('sidebar-default'); ?>
                    
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php get_footer(); ?>