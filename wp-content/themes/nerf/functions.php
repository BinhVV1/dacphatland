<?php
/**
 * nerf functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Nerf
 * @since Nerf 1.0.4
 */

define( 'NERF_THEME_VERSION', '1.0.4' );
define( 'NERF_DEMO_MODE', false );

if ( ! isset( $content_width ) ) {
	$content_width = 660;
}

if ( ! function_exists( 'nerf_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Nerf 1.0
 */
function nerf_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on nerf, use a find and replace
	 * to change 'nerf' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'nerf', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	add_theme_support( 'post-thumbnails' );
	add_image_size( 'nerf-apartment', 450, 400, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'nerf' ),
		'mobile-primary' => esc_html__( 'Primary Mobile Menu', 'nerf' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	add_theme_support( "woocommerce", array('gallery_thumbnail_image_width' => 410) );
	
	add_theme_support( 'wc-product-gallery-slider' );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );

	$color_scheme  = nerf_get_color_scheme();
	$default_color = trim( $color_scheme[0], '#' );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'nerf_custom_background_args', array(
		'default-color'      => $default_color,
		'default-attachment' => 'fixed',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add support for Block Styles.
	add_theme_support( 'wp-block-styles' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Add support for editor styles.
	add_theme_support( 'editor-styles' );

	// Add support for responsive embeds.
	add_theme_support( 'responsive-embeds' );

	// Enqueue editor styles.
	add_editor_style('css/style-editor.css');

	nerf_get_load_plugins();
}
endif; // nerf_setup
add_action( 'after_setup_theme', 'nerf_setup' );

/**
 * Load Google Front
 */
function nerf_get_fonts_url() {
    $fonts_url = '';

    $main_font = nerf_get_config('main-font');
	$main_font = !empty($main_font) ? json_decode($main_font, true) : array();
	if (  !empty($main_font['fontfamily']) ) {
		$main_font_family = $main_font['fontfamily'];
		$main_font_weight = !empty($main_font['fontweight']) ? $main_font['fontweight'] : '400,500,600,700,800,900';
		$main_font_subsets = !empty($main_font['subsets']) ? $main_font['subsets'] : 'latin,latin-ext';
	} else {
		$main_font_family = 'Jost';
		$main_font_weight = '400,500,600,700,800,900';
		$main_font_subsets = 'latin,latin-ext';
	}

	$heading_font = nerf_get_config('heading-font');
	$heading_font = !empty($heading_font) ? json_decode($heading_font, true) : array();
	if (  !empty($heading_font['fontfamily']) ) {
		$heading_font_family = $heading_font['fontfamily'];
		$heading_font_weight = !empty($heading_font['fontweight']) ? $heading_font['fontweight'] : '400,500,600,700,800,900';
		$heading_font_subsets = !empty($heading_font['subsets']) ? $heading_font['subsets'] : 'latin,latin-ext';
	} else {
		$heading_font_family = 'Jost';
		$heading_font_weight = '400,500,600,700,800,900';
		$heading_font_subsets = 'latin,latin-ext';
	}

	if ( $main_font_family == $heading_font_family ) {
		$font_weight = $main_font_weight.','.$heading_font_weight;
		$font_subsets = $main_font_subsets.','.$heading_font_subsets;
		$fonts = array(
			$main_font_family => array(
				'weight' => $font_weight,
				'subsets' => $font_subsets,
			),
		);
	} else {
		$fonts = array(
			$main_font_family => array(
				'weight' => $main_font_weight,
				'subsets' => $main_font_subsets,
			),
			$heading_font_family => array(
				'weight' => $heading_font_weight,
				'subsets' => $heading_font_subsets,
			),
		);
	}

	$font_families = array();
	$subset = array();

	foreach ($fonts as $key => $opt) {
		$font_families[] = $key.':'.$opt['weight'];
		$subset[] = $opt['subsets'];
	}



    $query_args = array(
        'family' => implode( '|', $font_families ),
        'subset' => urlencode( implode( ',', $subset ) ),
    );
		
		$protocol = is_ssl() ? 'https:' : 'http:';
    $fonts_url = add_query_arg( $query_args, $protocol .'//fonts.googleapis.com/css' );
    
 
    return esc_url( $fonts_url );
}

/**
 * Enqueue styles.
 *
 * @since Nerf 1.0
 */
function nerf_enqueue_styles() {
	$theme_version = '1.1.11';

	// load font
	wp_enqueue_style( 'nerf-theme-fonts', nerf_get_fonts_url(), array(), null );

	//load font awesome
	wp_enqueue_style( 'all-awesome', get_template_directory_uri() . '/css/all-awesome.css', array(), $theme_version );

	//load font flaticon
	wp_enqueue_style( 'flaticon', get_template_directory_uri() . '/css/flaticon.css', array(), $theme_version );

	// load font themify icon
	wp_enqueue_style( 'themify-icons', get_template_directory_uri() . '/css/themify-icons.css', array(), $theme_version );
			
	// load animate version 3.6.0
	wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.css', array(), $theme_version );

	// load bootstrap style
	if( is_rtl() ){
		wp_enqueue_style( 'bootstrap-rtl', get_template_directory_uri() . '/css/bootstrap.rtl.css', array(), $theme_version );
	} else {
		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), $theme_version );
	}
	// slick
	wp_enqueue_style( 'slick', get_template_directory_uri() . '/css/slick.css', array(), $theme_version );
	// magnific-popup
	wp_enqueue_style( 'magnific-popup', get_template_directory_uri() . '/css/magnific-popup.css', array(), $theme_version );
	// perfect scrollbar
	wp_enqueue_style( 'perfect-scrollbar', get_template_directory_uri() . '/css/perfect-scrollbar.css', array(), $theme_version );
	
	// mobile menu
	wp_enqueue_style( 'sliding-menu', get_template_directory_uri() . '/css/sliding-menu.min.css', array(), $theme_version );

	// main style
	if( is_rtl() ){
		wp_enqueue_style( 'nerf-template', get_template_directory_uri() . '/css/template.rtl.css', array(), $theme_version );
	} else {
		wp_enqueue_style( 'nerf-template', get_template_directory_uri() . '/css/template.css', array(), $theme_version );
	}
	
	$custom_style = nerf_custom_styles();
	if ( !empty($custom_style) ) {
		wp_add_inline_style( 'nerf-template', $custom_style );
	}
	wp_enqueue_style( 'nerf-style', get_template_directory_uri() . '/style.css', array(), $theme_version );
}
add_action( 'wp_enqueue_scripts', 'nerf_enqueue_styles', 1000 );

function nerf_admin_enqueue_styles() {
	$theme_version = '1.1.11';
	//load font flaticon
	wp_enqueue_style( 'flaticon', get_template_directory_uri() . '/css/flaticon.css', array(), $theme_version );
}
add_action( 'admin_enqueue_scripts', 'nerf_admin_enqueue_styles', 1000 );

/**
 * Enqueue scripts.
 *
 * @since Nerf 1.0
 */
function nerf_enqueue_scripts() {
	$theme_version = '1.1.11';

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	// bootstrap
	wp_enqueue_script( 'bootstrap-bundle', get_template_directory_uri() . '/js/bootstrap.bundle.min.js', array( 'jquery' ), $theme_version, true );
	// slick
	wp_enqueue_script( 'slick', get_template_directory_uri() . '/js/slick.min.js', array( 'jquery' ), $theme_version, true );
	// countdown
	wp_register_script( 'countdown', get_template_directory_uri() . '/js/countdown.js', array( 'jquery' ), $theme_version, true );
	wp_localize_script( 'countdown', 'nerf_countdown_opts', array(
		'days' => esc_html__('Days', 'nerf'),
		'hours' => esc_html__('Hrs', 'nerf'),
		'mins' => esc_html__('Mins', 'nerf'),
		'secs' => esc_html__('Secs', 'nerf'),
	));
	wp_enqueue_script( 'countdown' );
	
	// popup
	wp_enqueue_script( 'jquery-magnific-popup', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array( 'jquery' ), $theme_version, true );
	// unviel
	wp_enqueue_script( 'jquery-unveil', get_template_directory_uri() . '/js/jquery.unveil.js', array( 'jquery' ), $theme_version, true );
	
	// perfect scrollbar
	wp_enqueue_script( 'perfect-scrollbar', get_template_directory_uri() . '/js/perfect-scrollbar.min.js', array( 'jquery' ), $theme_version, true );
	
	if ( nerf_get_config('keep_header') ) {
		wp_enqueue_script( 'sticky', get_template_directory_uri() . '/js/sticky.min.js', array( 'jquery', 'elementor-waypoints' ), $theme_version, true );
	}

	// mobile menu script
	wp_enqueue_script( 'sliding-menu', get_template_directory_uri() . '/js/sliding-menu.min.js', array( 'jquery' ), $theme_version, true );

	// main script
	wp_register_script( 'nerf-functions', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), $theme_version, true );
	wp_localize_script( 'nerf-functions', 'nerf_opts', array(
		'ajaxurl' => esc_url(admin_url( 'admin-ajax.php' )),
		'previous' => esc_html__('Previous', 'nerf'),
		'next' => esc_html__('Next', 'nerf'),
		'menu_back_text' => esc_html__('Back', 'nerf')
	));
	wp_enqueue_script( 'nerf-functions' );
	
	wp_add_inline_script( 'nerf-functions', "(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);" );
}
add_action( 'wp_enqueue_scripts', 'nerf_enqueue_scripts', 1 );

/**
 * Add a `screen-reader-text` class to the search form's submit button.
 *
 * @since Nerf 1.0
 *
 * @param string $html Search form HTML.
 * @return string Modified search form HTML.
 */
function nerf_search_form_modify( $html ) {
	return str_replace( 'class="search-submit"', 'class="search-submit screen-reader-text"', $html );
}
add_filter( 'get_search_form', 'nerf_search_form_modify' );


function nerf_get_config($name, $default = '') {
	global $nerf_theme_options;
	
	if ( empty($nerf_theme_options) ) {
		$nerf_theme_options = get_option('nerf_theme_options');
	}

    if ( isset($nerf_theme_options[$name]) ) {
        return $nerf_theme_options[$name];
    }
    return $default;
}

function nerf_set_exporter_ocdi_settings_option_keys($option_keys) {
	return array(
		'nerf_theme_options',
		'elementor_disable_color_schemes',
		'elementor_disable_typography_schemes',
		'elementor_allow_tracking',
		'elementor_cpt_support',
		'tutor_option'
	);
}
add_filter( 'apus_exporter_ocdi_settings_option_keys', 'nerf_set_exporter_ocdi_settings_option_keys' );

function nerf_disable_one_click_import() {
	return false;
}
add_filter('apus_frammework_enable_one_click_import', 'nerf_disable_one_click_import');

function nerf_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Default', 'nerf' ),
		'id'            => 'sidebar-default',
		'description'   => esc_html__( 'Add widgets here to appear in your Sidebar.', 'nerf' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Fixed', 'nerf' ),
		'id'            => 'sidebar-fixed',
		'description'   => esc_html__( 'Add widgets here to appear in your home 4.', 'nerf' ),
		'before_widget' => '<aside class="%2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	
	register_sidebar( array(
		'name'          => esc_html__( 'Blog sidebar', 'nerf' ),
		'id'            => 'blog-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'nerf' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );
}
add_action( 'widgets_init', 'nerf_widgets_init' );

function nerf_get_load_plugins() {
	$plugins[] = array(
		'name'                     => esc_html__( 'Apus Framework For Themes', 'nerf' ),
        'slug'                     => 'apus-frame',
        'required'                 => true ,
        'source'				   => get_template_directory() . '/inc/plugins/apus-frame.zip'
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'Elementor Page Builder', 'nerf' ),
	    'slug'                     => 'elementor',
	    'required'                 => true,
	);
	
	$plugins[] = array(
		'name'                     => esc_html__( 'Revolution Slider', 'nerf' ),
        'slug'                     => 'revslider',
        'required'                 => true ,
        'source'				   => get_template_directory() . '/inc/plugins/revslider.zip'
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'Apus Nerf', 'nerf' ),
        'slug'                     => 'apus-nerf',
        'required'                 => true ,
        'source'				   => get_template_directory() . '/inc/plugins/apus-nerf.zip'
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'Image Hotspot by DevVN', 'nerf' ),
	    'slug'                     => 'devvn-image-hotspot',
	    'required'                 => true,
	);
	
	$plugins[] = array(
		'name'                     => esc_html__( 'Cmb2', 'nerf' ),
	    'slug'                     => 'cmb2',
	    'required'                 => true,
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'MailChimp for WordPress', 'nerf' ),
	    'slug'                     => 'mailchimp-for-wp',
	    'required'                 =>  true
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'Contact Form 7', 'nerf' ),
	    'slug'                     => 'contact-form-7',
	    'required'                 => true,
	);

	$plugins[] = array(
        'name'                  => esc_html__( 'One Click Demo Import', 'nerf' ),
        'slug'                  => 'one-click-demo-import',
        'required'              => false,
    );

	$plugins[] = array(
        'name'                  => esc_html__( 'SVG Support', 'nerf' ),
        'slug'                  => 'svg-support',
        'required'              => false,
        'force_activation'      => false,
        'force_deactivation'    => false,
    );

	tgmpa( $plugins );
}

function create_thong_tin_su_kien_post_type() {
    $labels = array(
        'name'                  => _x('Thông tin & Sự kiện', 'Post type general name', 'textdomain'),
        'singular_name'         => _x('Thông tin & Sự kiện', 'Post type singular name', 'textdomain'),
        'menu_name'             => _x('Thông tin & Sự kiện', 'Admin Menu text', 'textdomain'),
        'name_admin_bar'        => _x('Thông tin & Sự kiện', 'Add New on Toolbar', 'textdomain'),
        'add_new'               => __('Thêm mới', 'textdomain'),
        'add_new_item'          => __('Thêm mới Thông tin & Sự kiện', 'textdomain'),
        'new_item'              => __('Mới Thông tin & Sự kiện', 'textdomain'),
        'edit_item'             => __('Chỉnh sửa Thông tin & Sự kiện', 'textdomain'),
        'view_item'             => __('Xem Thông tin & Sự kiện', 'textdomain'),
        'all_items'             => __('Tất cả Thông tin & Sự kiện', 'textdomain'),
        'search_items'          => __('Tìm kiếm Thông tin & Sự kiện', 'textdomain'),
        'parent_item_colon'     => __('Thông tin & Sự kiện gốc:', 'textdomain'),
        'not_found'             => __('Không tìm thấy Thông tin & Sự kiện', 'textdomain'),
        'not_found_in_trash'    => __('Không tìm thấy Thông tin & Sự kiện trong thùng rác', 'textdomain'),
        'featured_image'        => _x('Ảnh đại diện', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain'),
        'set_featured_image'    => _x('Đặt ảnh đại diện', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain'),
        'remove_featured_image' => _x('Xóa ảnh đại diện', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain'),
        'use_featured_image'    => _x('Sử dụng làm ảnh đại diện', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain'),
        'archives'              => _x('Lưu trữ Thông tin & Sự kiện', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain'),
        'insert_into_item'      => _x('Chèn vào Thông tin & Sự kiện', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain'),
        'uploaded_to_this_item' => _x('Đã tải lên Thông tin & Sự kiện này', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain'),
        'filter_items_list'     => _x('Lọc danh sách Thông tin & Sự kiện', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”. Added in 4.4', 'textdomain'),
        'items_list_navigation' => _x('Điều hướng danh sách Thông tin & Sự kiện', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”. Added in 4.4', 'textdomain'),
        'items_list'            => _x('Danh sách Thông tin & Sự kiện', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”. Added in 4.4', 'textdomain'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'thong-tin-su-kien'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'show_in_rest'       => false,
    );

    register_post_type('thong_tin_su_kien', $args);
}

function create_thong_tin_su_kien_taxonomy() {
    $labels = array(
        'name'              => _x('Danh mục', 'taxonomy general name', 'textdomain'),
        'singular_name'     => _x('Danh mục', 'taxonomy singular name', 'textdomain'),
        'search_items'      => __('Tìm kiếm Danh mục', 'textdomain'),
        'all_items'         => __('Tất cả Danh mục', 'textdomain'),
        'parent_item'       => __('Danh mục cha', 'textdomain'),
        'parent_item_colon' => __('Danh mục cha:', 'textdomain'),
        'edit_item'         => __('Chỉnh sửa Danh mục', 'textdomain'),
        'update_item'       => __('Cập nhật Danh mục', 'textdomain'),
        'add_new_item'      => __('Thêm mới Danh mục', 'textdomain'),
        'new_item_name'     => __('Tên Danh mục mới', 'textdomain'),
        'menu_name'         => __('Danh mục', 'textdomain'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'danh-muc-thong-tin-su-kien'),
    );

    register_taxonomy('danh_muc_thong_tin_su_kien', array('thong_tin_su_kien'), $args);
}

add_action('init', 'create_thong_tin_su_kien_post_type');
add_action('init', 'create_thong_tin_su_kien_taxonomy');


require get_template_directory() . '/inc/plugins/class-tgm-plugin-activation.php';
get_template_part( '/inc/functions-helper' );
get_template_part( '/inc/functions-frontend' );

/**
 * Implement the Custom Header feature.
 *
 */
get_template_part( '/inc/custom-header' );
get_template_part( '/inc/classes/megamenu' );
get_template_part( '/inc/classes/mobilemenu' );

/**
 * Custom template tags for this theme.
 *
 */
get_template_part( '/inc/template-tags' );

/**
 * Customizer additions.
 *
 */
get_template_part( '/inc/customizer/font/custom-controls' );
get_template_part( '/inc/customizer/customizer-custom-control' );
get_template_part( '/inc/customizer/customizer' );


if( nerf_is_cmb2_activated() ) {
	get_template_part( '/inc/vendors/cmb2/page' );
}

if ( abolire_is_apus_nerf_activated() ) {
	get_template_part( '/inc/vendors/apus-nerf/functions' );
	get_template_part( '/inc/vendors/apus-nerf/customizer' );
}

function nerf_register_load_widget() {
	get_template_part( '/inc/widgets/custom_menu' );
	get_template_part( '/inc/widgets/recent_post' );
	get_template_part( '/inc/widgets/search' );
	get_template_part( '/inc/widgets/socials' );
	
	get_template_part( '/inc/widgets/elementor-template' );
	
}
add_action( 'widgets_init', 'nerf_register_load_widget' );


get_template_part( '/inc/vendors/elementor/functions' );
get_template_part( '/inc/vendors/one-click-demo-import/functions' );


/**
 * Custom Styles
 *
 */
get_template_part( '/inc/custom-styles' );

@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );

add_filter('site_transient_update_plugins', '__return_false');
add_filter('site_transient_update_themes', '__return_false');
// add_filter('use_block_editor_for_post', '__return_false', 10);
// add_filter('use_block_editor_for_post_type', '__return_false', 10);
