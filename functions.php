<?php
/**
 * Omphaloskepsis functions and definitions
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
 * @subpackage omphaloskepsis
 * @since Omphaloskepsis 1.0
 */

/**
 * Omphaloskepsis only works in WordPress 4.4 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.4-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

// This sets the correct background colour for any LaTeX.
global $themecolors;
$themecolors['bg'] = 'FFFFF0';
$themecolors['text'] = '020202';

if ( ! function_exists( 'omphaloskepsis_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @since Omphaloskepsis 1.0
	 */
	function omphaloskepsis_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Omphaloskepsis, use a find and replace
		 * to change 'omphaloskepsis' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'omphaloskepsis', get_template_directory() . '/languages' );
		
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for custom logo.
		 *
		 *  @since Omphaloskepsis 1.2
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 2256,
			'width'       => 1622,
			'flex-height' => true,
		) );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 1200, 9999 );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
			'primary' => __( 'Primary Menu', 'omphaloskepsis' ),
			'social'  => __( 'Social Links Menu', 'omphaloskepsis' ),
		) );
		
		function omphaloskepsis_infinite_scroll_init() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => 'omphaloskepsis_infinite_scroll_render',
		'footer'    => 'colophon',
	) );
}

add_action( 'init', 'omphaloskepsis_infinite_scroll_init' );
/**
 * Custom render function for Infinite Scroll.
 */
function omphaloskepsis_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		if ( is_search() ) {
			get_template_part( 'template-parts/content', 'search' );
		} else {
			get_template_part( 'template-parts/content', get_post_format() );
		}
	}
}

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
			'gallery',
			'status',
			'audio',
			'chat',
		) );

		/*
		 * This theme styles the visual editor to resemble the theme style,
		 * specifically font, colors, icons, and column width.
		 */
		add_editor_style( array( 'css/editor-style.css', omphaloskepsis_fonts_url() ) );

		// Indicate widget sidebars can use selective refresh in the Customizer.
		add_theme_support( 'customize-selective-refresh-widgets' );
	}
endif; // omphaloskepsis_setup
add_action( 'after_setup_theme', 'omphaloskepsis_setup' );

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 *
 * @since Omphaloskepsis 1.0
 */
function omphaloskepsis_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'omphaloskepsis_content_width', 840 );
}
add_action( 'after_setup_theme', 'omphaloskepsis_content_width', 0 );

/**
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 * @since Omphaloskepsis 1.0
 */
function omphaloskepsis_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'omphaloskepsis' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'omphaloskepsis' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Content Bottom 1', 'omphaloskepsis' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'omphaloskepsis' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Content Bottom 2', 'omphaloskepsis' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'omphaloskepsis' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'omphaloskepsis_widgets_init' );

if ( ! function_exists( 'omphaloskepsis_fonts_url' ) ) :
	/**
	 * Register Google fonts for Omphaloskepsis.
	 *
	 * Create your own omphaloskepsis_fonts_url() function to override in a child theme.
	 *
	 * @since Omphaloskepsis 1.0
	 *
	 * @return string Google fonts URL for the theme.
	 */
	function omphaloskepsis_fonts_url() {
		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin,latin-ext';

		/* translators: If there are characters in your language that are not supported by Merriweather, translate this to 'off'. Do not translate into your own language. */
		if ( 'off' !== _x( 'on', 'Merriweather font: on or off', 'omphaloskepsis' ) ) {
			$fonts[] = 'Merriweather:400,700,900,400italic,700italic,900italic';
		}

		/* translators: If there are characters in your language that are not supported by Montserrat, translate this to 'off'. Do not translate into your own language. */
		if ( 'off' !== _x( 'on', 'Montserrat font: on or off', 'omphaloskepsis' ) ) {
			$fonts[] = 'Montserrat:400,700';
		}

		/* translators: If there are characters in your language that are not supported by Inconsolata, translate this to 'off'. Do not translate into your own language. */
		if ( 'off' !== _x( 'on', 'Inconsolata font: on or off', 'omphaloskepsis' ) ) {
			$fonts[] = 'Inconsolata:400';
		}

		if ( $fonts ) {
			$fonts_url = add_query_arg( array(
				'family' => urlencode( implode( '|', $fonts ) ),
				'subset' => urlencode( $subsets ),
			), 'https://fonts.googleapis.com/css' );
		}

		return $fonts_url;
	}
endif;

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Omphaloskepsis 1.0
 */
function omphaloskepsis_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'omphaloskepsis_javascript_detection', 0 );

/**
 * Enqueues scripts and styles.
 *
 * @since Omphaloskepsis 1.0
 */
function omphaloskepsis_scripts() {
	// Load the normalisation stylesheet.
	wp_enqueue_style( 'omphaloskepsis-reset', get_template_directory_uri() . '/css/reset.css', array( ), null );
	
	wp_style_add_data( 'omphaloskepsis-ie', 'conditional', 'lt IE 10' );
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'omphaloskepsis-fonts', omphaloskepsis_fonts_url(), array(), null );

	// Add Genericons, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.4.1' );

	// Theme stylesheet.
	wp_enqueue_style( 'omphaloskepsis-style', get_stylesheet_uri() );
	
	wp_enqueue_style('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'); 
	
	wp_enqueue_style( 'montserrat', "https://fonts.googleapis.com/css?family=Montserrat" );

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'omphaloskepsis-ie', get_template_directory_uri() . '/css/ie.css', array( 'omphaloskepsis-style' ), '20160412' );
	wp_style_add_data( 'omphaloskepsis-ie', 'conditional', 'lt IE 10' );

	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style( 'omphaloskepsis-ie8', get_template_directory_uri() . '/css/ie8.css', array( 'omphaloskepsis-style' ), '20160412' );
	wp_style_add_data( 'omphaloskepsis-ie8', 'conditional', 'lt IE 9' );

	// Load the Internet Explorer 7 specific stylesheet.
	wp_enqueue_style( 'omphaloskepsis-ie7', get_template_directory_uri() . '/css/ie7.css', array( 'omphaloskepsis-style' ), '20160412' );
	wp_style_add_data( 'omphaloskepsis-ie7', 'conditional', 'lt IE 8' );

	// Load the html5 shiv.
	wp_enqueue_script( 'omphaloskepsis-html5', get_template_directory_uri() . '/js/html5.js', array(), '3.7.3' );
	wp_script_add_data( 'omphaloskepsis-html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'omphaloskepsis-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20160412', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'omphaloskepsis-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20160412' );
	}

	wp_enqueue_script( 'omphaloskepsis-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20160412', true );

	wp_localize_script( 'omphaloskepsis-script', 'screenReaderText', array(
		'expand'   => __( 'expand child menu', 'omphaloskepsis' ),
		'collapse' => __( 'collapse child menu', 'omphaloskepsis' ),
	) );
}
add_action( 'wp_enqueue_scripts', 'omphaloskepsis_scripts' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @since Omphaloskepsis 1.0
 *
 * @param array $classes Classes for the body element.
 * @return array (Maybe) filtered body classes.
 */
function omphaloskepsis_body_classes( $classes ) {
	// Adds a class of custom-background-image to sites with a custom background image.
	if ( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}

	// Adds a class of group-blog to sites with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of no-sidebar to sites without active sidebar.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'omphaloskepsis_body_classes' );

/**
 * Converts a HEX value to RGB.
 *
 * @since Omphaloskepsis 1.0
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 * @return array Array containing RGB (red, green, and blue) values for the given
 *               HEX code, empty array otherwise.
 */
function omphaloskepsis_hex2rgb( $color ) {
	$color = trim( $color, '#' );

	if ( strlen( $color ) === 3 ) {
		$r = hexdec( substr( $color, 0, 1 ).substr( $color, 0, 1 ) );
		$g = hexdec( substr( $color, 1, 1 ).substr( $color, 1, 1 ) );
		$b = hexdec( substr( $color, 2, 1 ).substr( $color, 2, 1 ) );
	} else if ( strlen( $color ) === 6 ) {
		$r = hexdec( substr( $color, 0, 2 ) );
		$g = hexdec( substr( $color, 2, 2 ) );
		$b = hexdec( substr( $color, 4, 2 ) );
	} else {
		return array();
	}

	return array( 'red' => $r, 'green' => $g, 'blue' => $b );
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images
 *
 * @since Omphaloskepsis 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function omphaloskepsis_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	840 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px';

	if ( 'page' === get_post_type() ) {
		840 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
	} else {
		840 > $width && 600 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
		600 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'omphaloskepsis_content_image_sizes_attr', 10 , 2 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails
 *
 * @since Omphaloskepsis 1.0
 *
 * @param array $attr Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function omphaloskepsis_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( 'post-thumbnail' === $size ) {
		is_active_sidebar( 'sidebar-1' ) && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 60vw, (max-width: 1362px) 62vw, 840px';
		! is_active_sidebar( 'sidebar-1' ) && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 88vw, 1200px';
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'omphaloskepsis_post_thumbnail_sizes_attr', 10 , 3 );

/**
 * Modifies tag cloud widget arguments to have all tags in the widget same font size.
 *
 * @since Omphaloskepsis 1.1
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array A new modified arguments.
 */
function omphaloskepsis_widget_tag_cloud_args( $args ) {
    $args['largest'] = 1;
    $args['smallest'] = 1;
    $args['unit'] = 'em';
    return $args;
}
add_filter( 'widget_tag_cloud_args', 'omphaloskepsis_widget_tag_cloud_args' );

function omphaloskepsis_the_content($content) {
    global $post;
    if ($post->post_type == "program") {
	$links = '<h2 class="subheading">Links</h2>';
	if ($meta = get_post_meta($post->ID, 'Link', true))
	    $links = $links . '<a class="hyperlink-button" target="_blank" href="'.$meta.'">Download</a>';
	if ($meta = get_post_meta($post->ID, 'Documentation', true))
	    $links = $links . '<a class="hyperlink-button" target="_blank" href="'.$meta.'">Documentation</a>';
	if ($meta = get_post_meta($post->ID, 'Repo', true))
	    $links = $links . '<a class="hyperlink-button" target="_blank" href="'.$meta.'">Repo</a>';
	if ($meta = get_post_meta($post->ID, 'Licence', true))
	    $links = $links . '<a class="hyperlink-button" target="_blank" href="'.$meta.'">Licence</a>';
	if ($meta = get_post_meta($post->ID, 'MD5', true))
	    $links = $links . '<p class="checksum">MD5 checksum: '.$meta.'</p>';
	return $content . $links;
    } elseif ($post->post_type == "website") {
	$links = '<h2 class="subheading">Links</h2>';
	if ($meta = get_post_meta($post->ID, 'Link', true))
	    $links = $links . '<a class="hyperlink-button" target="_blank" href="'.$meta.'">Visit</a>';
	if ($meta = get_post_meta($post->ID, 'Repo', true))
	    $links = $links . '<a class="hyperlink-button" target="_blank" href="'.$meta.'">Repo</a>';
	if ($meta = get_post_meta($post->ID, 'Licence', true))
	    $links = $links . '<a class="hyperlink-button" target="_blank" href="'.$meta.'">Licence</a>';
	return '<h2 class="subheading">Summary</h2>' . $content . $links;
    } elseif ($post->post_type == "writing") {
	$links = '<h2 class="subheading">Links</h2>';
	if ($meta = get_post_meta($post->ID, 'Link', true))
	    $links = $links . '<a class="hyperlink-button" target="_blank" href="'.$meta.'">Read</a>';
	if ($meta = get_post_meta($post->ID, 'Licence', true))
	    $links = $links . '<a class="hyperlink-button" target="_blank" href="'.$meta.'">Licence</a>';
	return '<h2 class="subheading">Summary</h2>' . $content . $links;
    } elseif ($post->post_type == "other") {
	$links = '<h2 class="subheading">Links</h2>';
	if ($meta = get_post_meta($post->ID, 'Link', true))
	    $links = $links . '<a class="hyperlink-button" target="_blank" href="'.$meta.'">Download</a>';
	return '<h2 class="subheading">Summary</h2>' . $content . $links;
    }
    return $content;
}
add_filter('the_content', 'omphaloskepsis_the_content', 10);

add_action( 'wp_enqueue_scripts', 'load_dashicons_front_end' );
function load_dashicons_front_end() {
    wp_enqueue_style( 'dashicons' );
}

function display_companies() {
    echo "<ul>";
    if ($_POST['toplevel'] == "true") {
	// Gets all of the top-level company terms.
	$terms = apply_filters("taxonomy-images-get-terms", "", array('having_images' => false, 'taxonomy' => 'company', 'term_args' => array('parent' => 0)));
	$include = 1;
    } else {
	// Gets all of the company terms.
	$terms = apply_filters("taxonomy-images-get-terms", "", array('having_images' => false, 'taxonomy' => 'company',));
	$include = 0;
    }
    if(!empty($terms)) {
	foreach($terms as $term) {
	    $term_children = get_term_children($term->term_id, "company");
	 
	    // 0 = Jobs
	    // 1 = Blog Posts
	    // 2 = Websites
	    // 3 = Programs
	    // 4 = Writings
	    // 5 = Videos
	    // 6 = Others
	    // 7 = Qualifications
	    // 8 = Awards
	    $post_types = array('job', 'post', 'website', 'program', 'writing', 'video', 'other', 'qualification', 'award');
	    $dashicons = array('hammer', 'admin-post', 'schedule', 'desktop', 'format-aside', 'video-alt', 'archive', 'id', 'awards');
	    $term_items = array();
	    $term_item_counts = array();

	    foreach ($post_types as $post_type) {
		$args = array(  
		    'posts_per_page' => -1, 
		    'post_type' => $post_type, 
		    'tax_query' => array(
			array(
			    'taxonomy' => 'company', 
			    'field' => 'slug', 
			    'terms' => $term->slug,
			    'include_children' => $include,
			),
		    ),
		    'meta_query' => array(),
		);
		     
		if ($_POST['currentjobs'] == "true" && $post_type == "job") {
		    $args['meta_query'] = array(
			array(
			    'key' => 'end-date',
			    'compare' => 'NOT EXISTS',
			    'value'   => '1',
			),
		    );
		}
		
		if ($_POST['showexpired'] != "true" && $post_type == "qualification") {
		    $args['meta_query'] = array(
			array(
			    'key' => 'Expired',
			    'compare' => 'NOT EXISTS',
			    'value'   => '1',
			),
		    );
		}

		$posts = get_posts($args);

		array_push($term_items, $posts);
		array_push($term_item_counts, count($posts));
	    }

	    if(($_POST['job'] == "true" && $term_item_counts[0] > 0) ||
		($_POST['post'] == "true" && $term_item_counts[1] > 0) ||
		($_POST['website'] == "true" && $term_item_counts[2] > 0) ||
		($_POST['program'] == "true" && $term_item_counts[3] > 0) ||
		($_POST['writing'] == "true" && $term_item_counts[4] > 0) ||
		($_POST['video'] == "true" && $term_item_counts[5] > 0) ||
		($_POST['other'] == "true" && $term_item_counts[6] > 0) ||
		($_POST['qualification'] == "true" && $term_item_counts[7] > 0) ||
		($_POST['award'] == "true" && $term_item_counts[8] > 0)) {
		   
		$imgURL = wp_get_attachment_image_src($term->image_id, 'full')[0];
		$bgImg = (!$imgURL) ? "" : " background-image: url(".strtok($imgURL, '?').");";
		$colour = get_term_meta($term->term_id, 'color', true);
		$colour = ($colour != "") ? $colour : "transparent";
		
		echo '<a href="'.esc_url(get_term_link($term, $term->taxonomy)).'">';
		    echo '<li class="col-2 col-m-4" style="background-color: '.$colour.'; '.$bgImg.'">';
			echo '<div class="company-info-container left">';
			if (count($term_children) > 0) {
			    echo '<div class="company-info children">';
				echo count($term_children).'<br><span class="dashicons dashicons-groups"></span>';
			    echo '</div>';
			}
			echo '</div>';
		      
			echo '<div class="company-info-container right">';
			$i = 0;
			foreach ($post_types as $post_type) {
			    if ($_POST[$post_type] == "true") {
				echo '<div class="company-info jobs">';
				echo $term_item_counts[$i].'<span class="dashicons dashicons-'.$dashicons[$i].'"></span>';
				echo '</div>';
			    }
			    $i++;
			}
			echo '</div>';
			if (!$imgURL) echo '<p class="company-name">'.$term->name.'</p>';
		    echo '</li>';
		echo '</a>';
	    }
	}
    } else {
	echo '<p>No companies found</p>';
    }
    echo '</ul>';

    die();
}
add_action('wp_ajax_display_companies', 'display_companies');
add_action('wp_ajax_nopriv_display_companies', 'display_companies');
