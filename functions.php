<?php
/**
 * Omphaloskepsis functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * @package omphaloskepsis
 * @since Omphaloskepsis 1.0
 */

// This sets the correct background colour for any LaTeX.
global $themecolors;
$themecolors['bg']   = 'FFFFF0';
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
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 2256,
				'width'       => 1622,
				'flex-height' => true,
			)
		);

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		*/
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 1200, 9999 );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'primary' => __( 'Primary Menu', 'omphaloskepsis' ),
				'social'  => __( 'Social Links Menu', 'omphaloskepsis' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		*/
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		*/
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'status',
				'audio',
				'chat',
			)
		);

		/*
		 * This theme styles the visual editor to resemble the theme style,
		 * specifically font, colors, icons, and column width.
		*/
		add_editor_style(
			array(
				'css/editor-style.css',
				omphaloskepsis_fonts_url(),
			)
		);

		// Indicate widget sidebars can use selective refresh in the Customizer.
		add_theme_support( 'customize-selective-refresh-widgets' );
	}
endif;
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
	register_sidebar(
		array(
			'name'          => __( 'Sidebar', 'omphaloskepsis' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here to appear in your sidebar.', 'omphaloskepsis' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Content Bottom 1', 'omphaloskepsis' ),
			'id'            => 'sidebar-2',
			'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'omphaloskepsis' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Content Bottom 2', 'omphaloskepsis' ),
			'id'            => 'sidebar-3',
			'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'omphaloskepsis' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
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
			$fonts_url = add_query_arg(
				array(
					'family' => rawurlencode( implode( '|', $fonts ) ),
					'subset' => rawurlencode( $subsets ),
				),
				'https://fonts.googleapis.com/css'
			);
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
function omphaloskepsis_scripts() {     // phpcs:disable WordPress.WP.EnqueuedResourceParameters
	// Load the normalisation stylesheet.
	wp_enqueue_style( 'omphaloskepsis-reset', get_template_directory_uri() . '/css/reset.css', array() );

	wp_style_add_data( 'omphaloskepsis-ie', 'conditional', 'lt IE 10' );
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'omphaloskepsis-fonts', omphaloskepsis_fonts_url(), array() );

	// Add Genericons, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.4.1' );

	// Theme stylesheet.
	wp_enqueue_style( 'omphaloskepsis-style', get_stylesheet_uri() );

	wp_enqueue_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css' );

	wp_enqueue_style( 'montserrat', 'https://fonts.googleapis.com/css?family=Montserrat' );

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style(
		'omphaloskepsis-ie',
		get_template_directory_uri() . '/css/ie.css',
		array(
			'omphaloskepsis-style',
		),
		'20160412'
	);
	wp_style_add_data( 'omphaloskepsis-ie', 'conditional', 'lt IE 10' );

	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style(
		'omphaloskepsis-ie8',
		get_template_directory_uri() . '/css/ie8.css',
		array(
			'omphaloskepsis-style',
		),
		'20160412'
	);
	wp_style_add_data( 'omphaloskepsis-ie8', 'conditional', 'lt IE 9' );

	// Load the Internet Explorer 7 specific stylesheet.
	wp_enqueue_style(
		'omphaloskepsis-ie7',
		get_template_directory_uri() . '/css/ie7.css',
		array(
			'omphaloskepsis-style',
		),
		'20160412'
	);
	wp_style_add_data( 'omphaloskepsis-ie7', 'conditional', 'lt IE 8' );

	// Load the html5 shiv.
	wp_enqueue_script( 'omphaloskepsis-html5', get_template_directory_uri() . '/js/html5.js', array(), '3.7.3' );
	wp_script_add_data( 'omphaloskepsis-html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'omphaloskepsis-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20160412', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script(
			'omphaloskepsis-keyboard-image-navigation',
			get_template_directory_uri() . '/js/keyboard-image-navigation.js',
			array(
				'jquery',
			),
			'20160412'
		);
	}

	wp_enqueue_script(
		'omphaloskepsis-script',
		get_template_directory_uri() . '/js/functions.js',
		array(
			'jquery',
		),
		'20160412',
		true
	);

	wp_localize_script(
		'omphaloskepsis-script',
		'screenReaderText',
		array(
			'expand'   => __( 'expand child menu', 'omphaloskepsis' ),
			'collapse' => __( 'collapse child menu', 'omphaloskepsis' ),
		)
	);
    // phpcs:enable

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
		$r = hexdec( substr( $color, 0, 1 ) . substr( $color, 0, 1 ) );
		$g = hexdec( substr( $color, 1, 1 ) . substr( $color, 1, 1 ) );
		$b = hexdec( substr( $color, 2, 1 ) . substr( $color, 2, 1 ) );
	} elseif ( strlen( $color ) === 6 ) {
		$r = hexdec( substr( $color, 0, 2 ) );
		$g = hexdec( substr( $color, 2, 2 ) );
		$b = hexdec( substr( $color, 4, 2 ) );
	} else {
		return array();
	}

	return array(
		'red'   => $r,
		'green' => $g,
		'blue'  => $b,
	);
}

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

	$sizes = ( 840 <= $width ) ? '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px' : '';

	if ( 'page' === get_post_type() ) {
		$sizes = ( 840 > $width ) ? '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px' : '';
	} else {
		$sizes = ( 840 > $width && 600 <= $width ) ? '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px' : '';
		$sizes = ( 600 > $width ) ? '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px' : '';
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'omphaloskepsis_content_image_sizes_attr', 10, 2 );

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
		$attr['sizes'] = ( is_active_sidebar( 'sidebar-1' ) ) ? '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 60vw, (max-width: 1362px) 62vw, 840px' : '';
		$attr['sizes'] = ( is_active_sidebar( 'sidebar-1' ) ) ? '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 88vw, 1200px' : '';
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'omphaloskepsis_post_thumbnail_sizes_attr', 10, 3 );

/**
 * Modifies tag cloud widget arguments to have all tags in the widget same font size.
 *
 * @since Omphaloskepsis 1.1
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array A new modified arguments.
 */
function omphaloskepsis_widget_tag_cloud_args( $args ) {
	$args['largest']  = 1;
	$args['smallest'] = 1;
	$args['unit']     = 'em';
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'omphaloskepsis_widget_tag_cloud_args' );

/**
 * Cleans up script tags.
 *
 * @param string $input The script tag.
 * @return sting The cleaned-up script tag.
 */
function clean_script_tag( $input ) {
	$input = str_replace( "type='text/javascript' ", '', $input );
	return str_replace( "'", '"', $input );
}
add_filter( 'script_loader_tag', 'clean_script_tag' );

/**
 * Renders the content of a post.
 *
 * @param string $content The post content.
 * @return string The rendered post content.
 */
function omphaloskepsis_the_content( $content ) {
	global $post;
	if ( 'program' === $post->post_type ) {
        // phpcs:disable Squiz.PHP.DisallowMultipleAssignments.FoundInControlStructure
        // phpcs:disable WordPress.CodeAnalysis.AssignmentInCondition.Found
		if ( $meta = get_post_meta( $post->ID, 'Link', true ) ) {
			$links = $links . '<a class="hyperlink-button" target="_blank" href="' . $meta . '">Download</a>';
		}
		if ( $meta = get_post_meta( $post->ID, 'Documentation', true ) ) {
			$links = $links . '<a class="hyperlink-button" target="_blank" href="' . $meta . '">Documentation</a>';
		}
		if ( $meta = get_post_meta( $post->ID, 'Repo', true ) ) {
			$links = $links . '<a class="hyperlink-button" target="_blank" href="' . $meta . '">Repo</a>';
		}
		if ( $meta = get_post_meta( $post->ID, 'Licence', true ) ) {
			$links = $links . '<a class="hyperlink-button" target="_blank" href="' . $meta . '">Licence</a>';
		}
		if ( $meta = get_post_meta( $post->ID, 'MD5', true ) ) {
			$links = $links . '<p class="checksum">MD5 checksum: ' . $meta . '</p>';
		}
		return $content . $links;
	} elseif ( 'website' === $post->post_type ) {
		if ( $meta = get_post_meta( $post->ID, 'Link', true ) ) {
			$links = $links . '<a class="hyperlink-button" target="_blank" href="' . $meta . '">Visit</a>';
		}
		if ( $meta = get_post_meta( $post->ID, 'Repo', true ) ) {
			$links = $links . '<a class="hyperlink-button" target="_blank" href="' . $meta . '">Repo</a>';
		}
		if ( $meta = get_post_meta( $post->ID, 'Licence', true ) ) {
			$links = $links . '<a class="hyperlink-button" target="_blank" href="' . $meta . '">Licence</a>';
		}
		return $content . $links;
	} elseif ( 'writing' === $post->post_type ) {
		if ( $meta = get_post_meta( $post->ID, 'Link', true ) ) {
			$links = $links . '<a class="hyperlink-button" target="_blank" href="' . $meta . '">Read</a>';
		}
		if ( $meta = get_post_meta( $post->ID, 'Licence', true ) ) {
			$links = $links . '<a class="hyperlink-button" target="_blank" href="' . $meta . '">Licence</a>';
		}
		return $content . $links;
	} elseif ( 'other' === $post->post_type ) {
		if ( $meta = get_post_meta( $post->ID, 'Link', true ) ) {
			$links = $links . '<a class="hyperlink-button" target="_blank" href="' . $meta . '">Download</a>';
		}
		return $content . $links;
	}
    // phpcs:enable
	return $content;
}
add_filter( 'the_content', 'omphaloskepsis_the_content', 10 );

// phpcs:disable Squiz.Commenting.FunctionComment.Missing
add_action( 'wp_enqueue_scripts', 'load_dashicons_front_end' );
function load_dashicons_front_end() {
	wp_enqueue_style( 'dashicons' );
}
// phpcs:enable

/**
 * Display a table of all the available organisations.
 *
 * @return void
 */
function display_companies() {
	echo '<tr>';
	echo '<th colspan="2">Organisation</th>';
	echo '<th>Children</th>';
	echo '<th>Associated Items</th>';
	echo '</tr>';

	if ( isset( $_SERVER['REQUEST_METHOD'] ) && ( 'POST' === $_SERVER['REQUEST_METHOD'] ) ) {
		if ( ! isset( $_POST['settings_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( filter_input( INPUT_POST, 'settings_nonce' ) ), 'experience' ) ) {
			echo '<tr><td>Error</td></tr>';
			wp_die( 'Invalid nonce' );
		}

        // phpcs:disable WordPress.NamingConventions.ValidHookName.UseUnderscores
		if ( isset( $_POST['toplevel'] ) && 'true' === $_POST['toplevel'] ) {
			// Gets all of the top-level company terms.
			$terms   = apply_filters(
				'taxonomy-images-get-terms',
				'',
				array(
					'having_images' => false,
					'taxonomy'      => 'company',
					'term_args'     => array(
						'parent' => 0,
					),
				)
			);
			$include = 1;
		} else {
			// Gets all of the company terms.
			$terms   = apply_filters(
				'taxonomy-images-get-terms',
				'',
				array(
					'having_images' => false,
					'taxonomy'      => 'company',
				)
			);
			$include = 0;
		}
        // phpcs:enable
		if ( ! empty( $terms ) ) {
			foreach ( $terms as $term ) {
				$term_children = get_term_children( $term->term_id, 'company' );

				// 0 = Jobs
				// 1 = Blog Posts
				// 2 = Websites
				// 3 = Programs
				// 4 = Writings
				// 5 = Videos
				// 6 = Others
				// 7 = Qualifications
				// 8 = Awards
				$post_types       = array(
					'job',
					'post',
					'website',
					'program',
					'writing',
					'video',
					'other',
					'qualification',
					'award',
				);
				$dashicons        = array(
					'hammer',
					'admin-post',
					'schedule',
					'desktop',
					'format-aside',
					'video-alt',
					'archive',
					'id',
					'awards',
				);
				$term_items       = array();
				$term_item_counts = array();

                // phpcs:disable WordPress.DB.SlowDBQuery.slow_db_query_tax_query
                // phpcs:disable WordPress.DB.SlowDBQuery.slow_db_query_meta_query
				foreach ( $post_types as $post_type ) {
					$args = array(
						'posts_per_page' => - 1,
						'post_type'      => $post_type,
						'tax_query'      => array(
							array(
								'taxonomy'         => 'company',
								'field'            => 'slug',
								'terms'            => $term->slug,
								'include_children' => $include,
							),
						),
						'meta_query'     => array(),
					);

					if ( isset( $_POST['currentjobs'] ) && 'true' === $_POST['currentjobs'] && 'job' === $post_type ) {
						$args['meta_query'] = array(
							array(
								'key'     => 'end-date',
								'compare' => 'NOT EXISTS',
								'value'   => '1',
							),
						);
					}

					if ( isset( $_POST['showexpired'] ) && 'true' !== $_POST['showexpired'] && 'qualification' === $post_type ) {
						$args['meta_query'] = array(
							array(
								'key'     => 'Expired',
								'compare' => 'NOT EXISTS',
								'value'   => '1',
							),
						);
					}
                    // phpcs:enable
					$posts = get_posts( $args );

					array_push( $term_items, $posts );
					array_push( $term_item_counts, count( $posts ) );
				}

				if ( ( isset( $_POST['job'] ) && 'true' === $_POST['job'] && $term_item_counts[0] > 0 ) || ( isset( $_POST['post'] ) && 'true' === $_POST['post'] && $term_item_counts[1] > 0 ) || ( isset( $_POST['website'] ) && 'true' === $_POST['website'] && $term_item_counts[2] > 0 ) || ( isset( $_POST['program'] ) && 'true' === $_POST['program'] && $term_item_counts[3] > 0 ) || ( isset( $_POST['writing'] ) && 'true' === $_POST['writing'] && $term_item_counts[4] > 0 ) || ( isset( $_POST['video'] ) && 'true' === $_POST['video'] && $term_item_counts[5] > 0 ) || ( isset( $_POST['other'] ) && 'true' === $_POST['other'] && $term_item_counts[6] > 0 ) || ( isset( $_POST['qualification'] ) && 'true' === $_POST['qualification'] && $term_item_counts[7] > 0 ) || ( isset( $_POST['award'] ) && 'true' === $_POST['award'] && $term_item_counts[8] > 0 ) ) {
					$img_url = wp_get_attachment_image_src( $term->image_id, 'full' ) [0];
					$bg_img  = ( ! $img_url ) ? '' : ' background-image: url(' . strtok( $img_url, '?' ) . ');';
					$colour  = get_term_meta( $term->term_id, 'color', true );
					$colour  = ( '' !== $colour ) ? $colour : 'transparent';

					echo '<tr class="organisation">';
					echo '<td class="organisation-logo">';
					echo '<a href="' . esc_url( get_term_link( $term, $term->taxonomy ) ) . '">';
					echo wp_kses_post( '<img style="background-color: ' . $colour . ';" src="' . strtok( $img_url, '?' ) . '" alt="' . $term->name . ' logo">' );
					echo '</a>';
					echo '</td>';

					echo '<td class="organisation-name">';
					echo '<a href="' . esc_url( get_term_link( $term, $term->taxonomy ) ) . '">';
					echo wp_kses_post( '<p>' . $term->name . '</p>' );
					echo '</a>';
					echo '</td>';

					echo '<td class="organisation-items organisation-children">';
					$num = ( count( $term_children ) > 0 ) ? '' : 'none';
					echo '<div class="organisation-item ' . esc_attr( $num ) . '">';
					echo wp_kses_post( '<span class="dashicons dashicons-groups"></span><br>' . count( $term_children ) );
					echo '</div>';
					echo '</td>';

					echo '<td class="organisation-items">';
					$i = 0;
					foreach ( $post_types as $post_type ) {
						$num = ( $term_item_counts[ $i ] > 0 ) ? '' : 'none';
						echo '<div class="organisation-item ' . esc_attr( $num ) . '">';
						echo wp_kses_post( '<span class="dashicons dashicons-' . esc_attr( $dashicons[ $i ] ) . '"></span><br>' . $term_item_counts[ $i ] );
						echo '</div>';
						$i++;
					};
					echo '</td>';
					echo '</tr>';
				}
			}
		} else {
			echo '<p>No companies found</p>';
		}
	}
	die();
}
add_action( 'wp_ajax_display_companies', 'display_companies' );
add_action( 'wp_ajax_nopriv_display_companies', 'display_companies' );

// allow HTML in category and taxonomy descriptions.
remove_filter( 'pre_term_description', 'wp_filter_kses' );
remove_filter( 'pre_link_description', 'wp_filter_kses' );
remove_filter( 'pre_link_notes', 'wp_filter_kses' );
remove_filter( 'term_description', 'wp_kses_data' );

// honour user DNT header.
add_filter( 'jetpack_honor_dnt_header_for_stats', '__return_true' );


