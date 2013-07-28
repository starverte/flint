<?php
/**
 * Flint functions and definitions
 *
 * @package Flint
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

/*
 * Load Jetpack compatibility file.
 */
require( get_template_directory() . '/inc/jetpack.php' );

if ( ! function_exists( 'flint_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function flint_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/extras.php' );

	/**
	 * Customizer additions
	 */
	require( get_template_directory() . '/inc/customizer.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Flint, use a find and replace
	 * to change 'flint' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'flint', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'flint' ),
	) );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );
}
endif; // flint_setup
add_action( 'after_setup_theme', 'flint_setup' );

/**
 * Setup the WordPress core custom background feature.
 *
 * Use add_theme_support to register support for WordPress 3.4+
 * as well as provide backward compatibility for WordPress 3.3
 * using feature detection of wp_get_theme() which was introduced
 * in WordPress 3.4.
 *
 * @todo Remove the 3.3 support when WordPress 3.6 is released.
 *
 * Hooks into the after_setup_theme action.
 */
function flint_register_custom_background() {
	$args = array(
		'default-color' => 'ffffff',
		'default-image' => '',
	);

	$args = apply_filters( 'flint_custom_background_args', $args );

	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-background', $args );
	} else {
		define( 'BACKGROUND_COLOR', $args['default-color'] );
		if ( ! empty( $args['default-image'] ) )
			define( 'BACKGROUND_IMAGE', $args['default-image'] );
		add_custom_background();
	}
}
add_action( 'after_setup_theme', 'flint_register_custom_background' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function flint_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'flint' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'flint_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function flint_scripts() {
	
	// Load Twitter Bootstrap 2.3.2
	wp_enqueue_script( 'bootstrap', '//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js', array('jquery'), '2.3.2', true );
	wp_enqueue_style( 'bootstrap-css', '//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css', array() , '2.3.2' );
	
	//Load Font Awesome 3.1.1
	wp_enqueue_style( 'font-awesome', '//netdna.bootstrapcdn.com/font-awesome/3.2.0/css/font-awesome.css', array(), '3.2.0' );

	wp_enqueue_script( 'flint-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'flint-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
	
	//Load Google Font 'Open Sans'
	wp_enqueue_style( 'open-sans', 'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,600,700', array(), '' );
	
	//Load theme stylesheet
	wp_enqueue_style( 'flint-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'flint_scripts' );

/**
 * Implement the Custom Header feature
 */
require( get_template_directory() . '/inc/custom-header.php' );

/**
 * Extended Walker class for use with the
 * Twitter Bootstrap toolkit Dropdown menus in Wordpress.
 * Edited to support n-levels submenu.
 * @author johnmegahan https://gist.github.com/1597994, Emanuele 'Tex' Tessore https://gist.github.com/3765640
 */
class Flint_Bootstrap_Menu extends Walker_Nav_Menu {
	function start_lvl( &$output, $depth ) {

		$indent = str_repeat( "\t", $depth );
		$submenu = ($depth > 0) ? ' sub-menu' : '';
		$output	   .= "\n$indent<ul class=\"dropdown-menu$submenu depth_$depth\">\n";

	}

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {


		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$li_attributes = '';
		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		
		// managing divider: add divider class to an element to get a divider before it.
		$divider_class_position = array_search('divider', $classes);
		if($divider_class_position !== false){
			$output .= "<li class=\"divider\"></li>\n";
			unset($classes[$divider_class_position]);
		}
		
		$classes[] = ($args->has_children) ? 'dropdown' : '';
		$classes[] = ($item->current || $item->current_item_ancestor) ? 'active' : '';
		$classes[] = 'menu-item-' . $item->ID;
		if($depth && $args->has_children){
			$classes[] = 'dropdown-submenu';
		}


		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		$attributes .= ($args->has_children) 	    ? ' class="dropdown-toggle" data-toggle="dropdown"' : '';

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= ($depth == 0 && $args->has_children) ? ' <b class="caret"></b></a>' : '</a>';
		$item_output .= $args->after;


		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
	

	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
		//v($element);
		if ( !$element )
			return;

		$id_field = $this->db_fields['id'];

		//display this element
		if ( is_array( $args[0] ) )
			$args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );
		else if ( is_object( $args[0] ) )
			$args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array(&$this, 'start_el'), $cb_args);

		$id = $element->$id_field;

		// descend only when the depth is right and there are childrens for this element
		if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {

			foreach( $children_elements[ $id ] as $child ){

				if ( !isset($newlevel) ) {
					$newlevel = true;
					//start the child delimiter
					$cb_args = array_merge( array(&$output, $depth), $args);
					call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
				}
				$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
			}
			unset( $children_elements[ $id ] );
		}

		if ( isset($newlevel) && $newlevel ){
			//end the child delimiter
			$cb_args = array_merge( array(&$output, $depth), $args);
			call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
		}

		//end this element
		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array(&$this, 'end_el'), $cb_args);

	}
}

/*
 * Create options page for metadata
 */
add_action('admin_menu', 'flint_menu');
function flint_menu() {
	add_theme_page('Schema', 'Schema', 'edit_theme_options', 'flint-schema', 'flint_schema');
}
function flint_schema() { ?>
	<div class="wrap">
	<?php echo '<img width="32" height="32" src="' . plugins_url( 'img/sparks.png' , __FILE__ ) . '" style="margin-right: 10px; float: left; margin-top: 7px;" /><h2>Schema</h2>'; ?>
	<form action="options.php" method="post">
		<?php settings_fields('flint_options'); ?>
		<?php do_settings_sections('flint'); ?>
		<?php settings_errors(); ?>
		<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></p>
	</form>
	</div><?
}

/*
 * Register settings for metadata options page
 */
add_action('admin_init', 'flint_admin_init');
function flint_admin_init(){
	register_setting('flint_options', 'flint_options', 'flint_options_validate' );
	add_settings_section('flint_schema_organization', 'Organization', 'flint_schema_org', 'flint');
	add_settings_field('org_tel', 'Telephone Number', 'org_tel_setting', 'flint', 'flint_schema_organization' );
	add_settings_field('org_fax', 'Fax Number', 'org_fax_setting', 'flint', 'flint_schema_organization' );
	add_settings_field('org_email', 'Email Address', 'org_email_setting', 'flint', 'flint_schema_organization' );
	add_settings_field('org_addr', 'Street Address', 'org_addr_setting', 'flint', 'flint_schema_organization' );
	add_settings_field('org_desc', 'Description', 'org_desc_setting', 'flint', 'flint_schema_organization' );
}
function flint_schema_org() { echo 'For search engine optimization. Must be used by theme to work.'; }
function org_desc_setting() {
	$options = get_option('flint_options');
	if (isset($options['org_desc'])) { echo '<textarea id="org_desc" name="flint_options[org_desc]" rows="5" cols="50">' . $options["org_desc"] . '</textarea>'; }
	else { echo '<textarea id="org_desc" name="flint_options[org_desc]" rows="5" cols="50"></textarea>'; }
}
function org_addr_setting() {
	$options = get_option('flint_options');
	if (isset($options['org_addr'])) { echo '<input type="text" id="org_addr" name="flint_options[org_addr]" value="' . $options["org_addr"] . '" size="45">'; }
	else { echo '<input type="tel" id="org_addr" name="flint_options[org_addr]" value="" size="45">'; }
}
function org_tel_setting() {
	$options = get_option('flint_options');
	if (isset($options['org_tel'])) { echo '<input type="text" id="org_tel" name="flint_options[org_tel]" value="' . $options["org_tel"] . '">'; }
	else { echo '<input type="tel" id="org_tel" name="flint_options[org_tel]" value="">'; }
}
function org_email_setting() {
	$options = get_option('flint_options');
	if (isset($options['org_email'])) { echo '<input type="text" id="org_email" name="flint_options[org_email]" value="' . $options["org_email"] . '">'; }
	else { echo '<input type="email" id="org_email" name="flint_options[org_email]" value="">'; }
}
function org_fax_setting() {
	$options = get_option('flint_options');
	if (isset($options['org_fax'])) { echo '<input type="text" id="org_fax" name="flint_options[org_fax]" value="' . $options["org_fax"] . '">'; }
	else { echo '<input type="tel" id="org_fax" name="flint_options[org_fax]" value="">'; }
}
function flint_options_validate($input) {
	global $newinput;
	$org_tel_digits = preg_match_all( "/[0-9]/", $input['org_tel'] );
	if ($org_tel_digits == 10) {$newinput['org_tel'] = preg_replace("|\b(\d{3})(\d{3})(\d{4})\b|", "$1.$2.$3", $input['org_tel']);}
	elseif ($org_tel_digits == 7){$newinput['org_tel'] = preg_replace("|\b(\d{3})(\d{4})\b|", "$1.$2", $input['org_tel']);}
	else { $newinput['org_tel'] = preg_replace("/[^A-Za-z0-9]/", '', $input['org_tel']); }
	$org_fax_digits = preg_match_all( "/[0-9]/", $input['org_fax'] );
	if ($org_fax_digits == 10) {$newinput['org_fax'] = preg_replace("|\b(\d{3})(\d{3})(\d{4})\b|", "$1.$2.$3", $input['org_fax']);}
	elseif ($org_fax_digits == 7){$newinput['org_fax'] = preg_replace("|\b(\d{3})(\d{4})\b|", "$1.$2", $input['org_fax']);}
	else { $newinput['org_fax'] = preg_replace("/[^A-Za-z0-9]/", '', $input['org_fax']); }
	$newinput['org_email'] = $input['org_email'];
	$newinput['org_addr'] = $input['org_addr'];
	$newinput['org_desc'] = $input['org_desc'];
	return $newinput;
}
add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
		show_admin_bar(false);
	}
}

/**
 * Returns current theme version.
 */
function theme_version() {
    $theme = wp_get_theme();
    return $theme->Version;
}
