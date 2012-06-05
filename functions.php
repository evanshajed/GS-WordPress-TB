<?php

// 1. Custom Post Type Registration (Events)

add_action( 'init', 'create_event_postype' );

function create_event_postype() {

$labels = array(
    'name' => _x('Agenda', 'post type general name'),
    'singular_name' => _x('Agenda', 'post type singular name'),
    'add_new' => _x('Add New', 'Agenda'),
    'add_new_item' => __('Add New Agenda'),
    'edit_item' => __('Edit Agenda'),
    'new_item' => __('New Agenda'),
    'view_item' => __('View Agenda'),
    'search_items' => __('Search Agenda'),
    'not_found' =>  __('No Agenda found'),
    'not_found_in_trash' => __('No agenda found in Trash'),
    'parent_item_colon' => '',
);

$args = array(
    'label' => __('Agenda'),
    'labels' => $labels,
    'public' => true,
    'can_export' => true,
    'show_ui' => true,
    '_builtin' => false,
    'capability_type' => 'post',
    'menu_icon' => get_bloginfo('template_url').'/images/icon-datepicker.png',
    'hierarchical' => false,
    'rewrite' => array( "slug" => "agenda" ),
    'supports'=> array('title', 'thumbnail', 'excerpt', 'editor') ,
    'show_in_nav_menus' => true,
    'taxonomies' => array( 'tf_eventcategory', 'post_tag')
);

register_post_type( 'tf_events', $args);

}

function create_eventcategory_taxonomy() {

$labels = array(
    'name' => _x( 'Locations', 'taxonomy general name' ),
    'singular_name' => _x( 'Location', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Locations' ),
    'popular_items' => __( 'Popular Locations' ),
    'all_items' => __( 'All Locations' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit Location' ),
    'update_item' => __( 'Update Location' ),
    'add_new_item' => __( 'Add Location' ),
    'new_item_name' => __( 'New Location Name' ),
    'separate_items_with_commas' => __( 'Separate locations with commas' ),
    'add_or_remove_items' => __( 'Add or remove locations' ),
    'choose_from_most_used' => __( 'Choose from the most used locations' ),
);

register_taxonomy('tf_eventcategory','tf_events', array(
    'label' => __('Agenda Location'),
    'labels' => $labels,
    'hierarchical' => true,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'agenda-category' ),
));
}

add_action( 'init', 'create_eventcategory_taxonomy', 0 );

function add_custom_taxonomies() { 
// Add new "Locations" taxonomy to Agenda 
register_taxonomy('tf_eventarea', 'tf_events', array( 
    // Hierarchical taxonomy (like categories) 
    'hierarchical' => true, 
    // This array of options controls the labels displayed in the WordPress Admin UI 
    'labels' => array( 
    'name' => _x( 'Area', 'taxonomy general name' ), 
    'singular_name' => _x( 'Area', 'taxonomy singular name' ), 
    'search_items' => __( 'Search Area' ), 
    'all_items' => __( 'All Area' ), 
    'parent_item' => __( 'Parent Area' ), 
    'parent_item_colon' => __( 'Parent Area:' ), 
    'edit_item' => __( 'Edit Area' ), 
    'update_item' => __( 'Update Area' ), 
    'add_new_item' => __( 'Add New Area' ), 
    'new_item_name' => __( 'New Area Name' ), 
    'menu_name' => __( 'Area' ), ), 
        // Control the slugs used for this taxonomy 
        'rewrite' => array( 
        'slug' => 'area', 
        // This controls the base slug that will display before each term 
        'with_front' => false, 
        // Don't display the category base before "/locations/" 
        'hierarchical' => true 
        // This will allow URL's like "/locations/boston/cambridge/" 
        ), 
    )); 
} 
add_action( 'init', 'add_custom_taxonomies', 0 );

// 3. Show Columns

add_filter ("manage_edit-tf_events_columns", "tf_events_edit_columns");
add_action ("manage_posts_custom_column", "tf_events_custom_columns");

function tf_events_edit_columns($columns) {

$columns = array(
    "cb" => "<input type=\"checkbox\" />",
    "tf_col_ev_cat" => "Location",
    "tf_col_ev_area" => "Area",
    "tf_col_ev_date" => "Dates",
    "tf_col_ev_times" => "Times",
    "tf_col_ev_thumb" => "Thumbnail",
    "title" => "Event",
    "tf_col_ev_desc" => "Description",
    );
return $columns;
}

function tf_events_custom_columns($column)
{
global $post;
$custom = get_post_custom();
switch ($column)
{
case "tf_col_ev_cat":
    // - show taxonomy terms -
    $eventcats = get_the_terms($post->ID, "tf_eventcategory");
    $eventcats_html = array();
    if ($eventcats) {
    foreach ($eventcats as $eventcat)
    array_push($eventcats_html, $eventcat->name);
    echo implode($eventcats_html, ", ");
    } else {
    _e('None', 'themeforce');;
    }
break;
case "tf_col_ev_area":
    // - show taxonomy terms -
    $eventarea = get_the_terms($post->ID, "tf_eventarea");
    $eventarea_html = array();
    if ($eventarea) {
    foreach ($eventarea as $eventar)
    array_push($eventarea_html, $eventar->name);
    echo implode($eventarea_html, ", ");
    } else {
    _e('None', 'themeforce');;
    }
break;
case "tf_col_ev_date":
    // - show dates -
    $startd = $custom["tf_events_startdate"][0];
    $endd = $custom["tf_events_enddate"][0];
    $startdate = date("F j, Y", $startd);
    $enddate = date("F j, Y", $endd);
    echo $startdate . '<br /><em>' . $enddate . '</em>';
break;
case "tf_col_ev_times":
    // - show times -
    $startt = $custom["tf_events_startdate"][0];
    $endt = $custom["tf_events_enddate"][0];
    $time_format = get_option('time_format');
    $starttime = date($time_format, $startt);
    $endtime = date($time_format, $endt);
    echo $starttime . ' - ' .$endtime;
break;
case "tf_col_ev_thumb":
    // - show thumb -
    $post_image_id = get_post_thumbnail_id(get_the_ID());
    if ($post_image_id) {
    $thumbnail = wp_get_attachment_image_src( $post_image_id, 'post-thumbnail', false);
    if ($thumbnail) (string)$thumbnail = $thumbnail[0];
    echo '<img src="';
    echo bloginfo('template_url');
    echo '/timthumb/timthumb.php?src=';
    echo $thumbnail;
    echo '&h=60&w=60&zc=1" alt="" />';
}
break;
case "tf_col_ev_desc";
    the_excerpt();
break;

}
}
// 4. Show Meta-Box

add_action( 'admin_init', 'tf_events_create' );

function tf_events_create() {
    add_meta_box('tf_events_meta', 'Events', 'tf_events_meta', 'tf_events');
}

function tf_events_meta () {

// - grab data -

global $post;
$custom = get_post_custom($post->ID);
$meta_sd = $custom["tf_events_startdate"][0];
$meta_ed = $custom["tf_events_enddate"][0];
$meta_st = $meta_sd;
$meta_et = $meta_ed;

// - grab wp time format -

$date_format = get_option('date_format'); // Not required in my code
$time_format = get_option('time_format');

// - populate today if empty, 00:00 for time -

if ($meta_sd == null) { $meta_sd = time(); $meta_ed = $meta_sd; $meta_st = 0; $meta_et = 0;}

// - convert to pretty formats -

$clean_sd = date("D, M d, Y", $meta_sd);
$clean_ed = date("D, M d, Y", $meta_ed);
$clean_st = date($time_format, $meta_st);
$clean_et = date($time_format, $meta_et);

// - security -

echo '<input type="hidden" name="tf-events-nonce" id="tf-events-nonce" value="' .
wp_create_nonce( 'tf-events-nonce' ) . '" />';

// - output -

?>
<div class="tf-meta">
<ul>
    <li><label>Start Date</label><input name="tf_events_startdate" class="tfdate" value="<?php echo $clean_sd; ?>" /></li>
    <li><label>Start Time</label><input name="tf_events_starttime" value="<?php echo $clean_st; ?>" /><em>Use 24h format (7pm = 19:00)</em></li>
    <li><label>End Date</label><input name="tf_events_enddate" class="tfdate" value="<?php echo $clean_ed; ?>" /></li>
    <li><label>End Time</label><input name="tf_events_endtime" value="<?php echo $clean_et; ?>" /><em>Use 24h format (7pm = 19:00)</em></li>
</ul>
</div>
<?php
}

// 5. Save Data

add_action ('save_post', 'save_tf_events');

function save_tf_events(){

global $post;

// - still require nonce

if ( !wp_verify_nonce( $_POST['tf-events-nonce'], 'tf-events-nonce' )) {
    return $post->ID;
}

if ( !current_user_can( 'edit_post', $post->ID ))
    return $post->ID;

// - convert back to unix & update post

if(!isset($_POST["tf_events_startdate"])):
return $post;
endif;
$updatestartd = strtotime ( $_POST["tf_events_startdate"] . $_POST["tf_events_starttime"] );
update_post_meta($post->ID, "tf_events_startdate", $updatestartd );

if(!isset($_POST["tf_events_enddate"])):
return $post;
endif;
$updateendd = strtotime ( $_POST["tf_events_enddate"] . $_POST["tf_events_endtime"]);
update_post_meta($post->ID, "tf_events_enddate", $updateendd );

}

// 6. Customize Update Messages

add_filter('post_updated_messages', 'events_updated_messages');

function events_updated_messages( $messages ) {

  global $post, $post_ID;

  $messages['tf_events'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Agenda updated. <a href="%s">View item</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Agenda updated.'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Agenda restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Agenda published. <a href="%s">View agenda</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Agenda saved.'),
    8 => sprintf( __('Agenda submitted. <a target="_blank" href="%s">Preview agenda</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Agenda scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview agenda</a>'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Agenda draft updated. <a target="_blank" href="%s">Preview agenda</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}
// 7. JS Datepicker UI

function events_styles() {
    global $post_type;
    if( 'tf_events' != $post_type )
        return;
    wp_enqueue_style('ui-datepicker', get_bloginfo('template_url') . '/css/jquery-ui-1.8.9.custom.css');
}

function events_scripts() {
    global $post_type;
    if( 'tf_events' != $post_type )
        return;
    wp_enqueue_script('jquery-ui', get_bloginfo('template_url') . '/js/jquery-ui-1.8.9.custom.min.js', array('jquery'));
    wp_enqueue_script('ui-datepicker', get_bloginfo('template_url') . '/js/jquery.ui.datepicker.min.js');
    wp_enqueue_script('custom_script', get_bloginfo('template_url').'/js/pubforce-admin.js', array('jquery'));
}



/**
 * Modified Twenty Ten Theme functions for GS WordPress Theme
 */


/** Calling JQuery from CDN with Fallback. 
	Source: http://www.renaissance-design.net/2012/load-jquery-from-googles-cdn-with-local-fallback-in-wordpress/
 **/


	function rd_bulletproof_jquery() {
$url = '//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js';
wp_deregister_script('jquery');
if (get_transient('google_jquery') == true) {	    
	wp_register_script('jquery', $url, array(), null, true);
} 
else {
	$resp = wp_remote_head($url);
	if (!is_wp_error($resp) && 200 == $resp['response']['code']) {
		set_transient('google_jquery', true, 60 * 5);
		wp_register_script('jquery', $url, array(), null, true);
	} 
	else {
		set_transient('google_jquery', false, 60 * 5);
		$url = get_bloginfo('wpurl') . '/wp-includes/js/jquery/jquery.js';
		wp_register_script('jquery', $url, array(), '1.7.1', true);
	}
}
wp_enqueue_script('jquery');
/* Any other Javascript would be enqueued here */
}
add_action('wp_enqueue_scripts', 'rd_bulletproof_jquery');

add_action( 'admin_print_styles-post.php', 'events_styles', 1000 );
add_action( 'admin_print_styles-post-new.php', 'events_styles', 1000 );

add_action( 'admin_print_scripts-post.php', 'events_scripts', 1000 );
add_action( 'admin_print_scripts-post-new.php', 'events_scripts', 1000 );

/*
Adding Custom Search Filter
Source: http://www.melandri.net/2009/08/05/add-a-category-filter-to-wordpress-search-form/
*/

function getCatSearchFilter($pre,$post){
  $category = "";
  $catId = htmlspecialchars($_GET["cat"]);
  $archiveId= htmlspecialchars($_GET["archive-dropdown"]);

  if ($catId != null && $catId != '' && $catId != '0' && $archiveId != null && $archiveId != '' && $archiveId != '0'){
    $category = $pre.get_cat_name($catId).$archiveID.$post;
  }

  return $category;

}


/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640;

/** Tell WordPress to run twentyten_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'twentyten_setup' );

if ( ! function_exists( 'twentyten_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override twentyten_setup() in a child theme, add your own twentyten_setup to your child theme's
 * functions.php file.
 *
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses add_custom_background() To add support for a custom background.
 * @uses add_editor_style() To style the visual editor.
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_custom_image_header() To add support for a custom header.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Post Format support. You can also use the legacy "gallery" or "asides" (note the plural) categories.
	add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );
	add_image_size('blogThumb',150,150,true);

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'twentyten', TEMPLATEPATH . '/languages' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'twentyten' ),
	) );

	// This theme allows users to set a custom background
	add_custom_background();

	// Your changeable header business starts here
	if ( ! defined( 'HEADER_TEXTCOLOR' ) )
		define( 'HEADER_TEXTCOLOR', '' );

	// No CSS, just IMG call. The %s is a placeholder for the theme template directory URI.
	if ( ! defined( 'HEADER_IMAGE' ) )
		define( 'HEADER_IMAGE', '%s/images/headers/path.jpg' );

	// The height and width of your custom header. You can hook into the theme's own filters to change these values.
	// Add a filter to twentyten_header_image_width and twentyten_header_image_height to change these values.
	define( 'HEADER_IMAGE_WIDTH', apply_filters( 'twentyten_header_image_width', 940 ) );
	define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'twentyten_header_image_height', 198 ) );

	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be 940 pixels wide by 198 pixels tall.
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );

	// Don't support text inside the header image.
	if ( ! defined( 'NO_HEADER_TEXT' ) )
		define( 'NO_HEADER_TEXT', true );

	// Add a way for the custom header to be styled in the admin panel that controls
	// custom headers. See twentyten_admin_header_style(), below.
	add_custom_image_header( '', 'twentyten_admin_header_style' );

	// ... and thus ends the changeable header business.

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
		'berries' => array(
			'url' => '%s/images/headers/berries.jpg',
			'thumbnail_url' => '%s/images/headers/berries-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Berries', 'twentyten' )
		),
		'cherryblossom' => array(
			'url' => '%s/images/headers/cherryblossoms.jpg',
			'thumbnail_url' => '%s/images/headers/cherryblossoms-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Cherry Blossoms', 'twentyten' )
		),
		'concave' => array(
			'url' => '%s/images/headers/concave.jpg',
			'thumbnail_url' => '%s/images/headers/concave-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Concave', 'twentyten' )
		),
		'fern' => array(
			'url' => '%s/images/headers/fern.jpg',
			'thumbnail_url' => '%s/images/headers/fern-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Fern', 'twentyten' )
		),
		'forestfloor' => array(
			'url' => '%s/images/headers/forestfloor.jpg',
			'thumbnail_url' => '%s/images/headers/forestfloor-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Forest Floor', 'twentyten' )
		),
		'inkwell' => array(
			'url' => '%s/images/headers/inkwell.jpg',
			'thumbnail_url' => '%s/images/headers/inkwell-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Inkwell', 'twentyten' )
		),
		'path' => array(
			'url' => '%s/images/headers/path.jpg',
			'thumbnail_url' => '%s/images/headers/path-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Path', 'twentyten' )
		),
		'sunset' => array(
			'url' => '%s/images/headers/sunset.jpg',
			'thumbnail_url' => '%s/images/headers/sunset-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Sunset', 'twentyten' )
		)
	) );
}
endif;

if ( ! function_exists( 'twentyten_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in twentyten_setup().
 *
 * @since Twenty Ten 1.0
 */
function twentyten_admin_header_style() {
?>
<style type="text/css">
/* Shows the same border as on front end */
#headimg {
	border-bottom: 1px solid #000;
	border-top: 4px solid #000;
}
/* If NO_HEADER_TEXT is false, you would style the text with these selectors:
	#headimg #name { }
	#headimg #desc { }
*/
</style>
<?php
}
endif;

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * To override this in a child theme, remove the filter and optionally add
 * your own function tied to the wp_page_menu_args filter hook.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'twentyten_page_menu_args' );

/**
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @since Twenty Ten 1.0
 * @return int
 */
function twentyten_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'twentyten_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since Twenty Ten 1.0
 * @return string "Continue Reading" link
 */
function twentyten_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyten' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and twentyten_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string An ellipsis
 */
function twentyten_auto_excerpt_more( $more ) {
	return ' &hellip;' . twentyten_continue_reading_link();
}
add_filter( 'excerpt_more', 'twentyten_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string Excerpt with a pretty "Continue Reading" link
 */
function twentyten_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= twentyten_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'twentyten_custom_excerpt_more' );

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in Twenty Ten's style.css. This is just
 * a simple filter call that tells WordPress to not use the default styles.
 *
 * @since Twenty Ten 1.2
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Deprecated way to remove inline styles printed when the gallery shortcode is used.
 *
 * This function is no longer needed or used. Use the use_default_gallery_style
 * filter instead, as seen above.
 *
 * @since Twenty Ten 1.0
 * @deprecated Deprecated in Twenty Ten 1.2 for WordPress 3.1
 *
 * @return string The gallery style filter, with the styles themselves removed.
 */
function twentyten_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
// Backwards compatibility with WordPress 3.0.
if ( version_compare( $GLOBALS['wp_version'], '3.1', '<' ) )
	add_filter( 'gallery_style', 'twentyten_remove_gallery_css' );

if ( ! function_exists( 'twentyten_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentyten_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php printf( __( '%s <span class="says">says:</span>', 'twentyten' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'twentyten' ); ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'twentyten' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'twentyten' ), ' ' );
			?>
		</div><!-- .comment-meta .commentmetadata -->

		<div class="comment-body"><?php comment_text(); ?></div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'twentyten' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'twentyten' ), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;

/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 *
 * To override twentyten_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 *
 * @since Twenty Ten 1.0
 * @uses register_sidebar
 */
function twentyten_widgets_init() {

	// Search By Category Widget
	register_sidebar( array(
		'name' => __( 'Category Filter Widget ', 'twentyten' ),
		'id' => 'category-filter-widget',
		'description' => __( 'Category Filter Widget Area', 'twentyten' ),
		'before_widget' => '<div id="%1$s" class="search-widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="search-widget-title">',
		'after_title' => '</h3>',
		));
}
/** Register sidebars by running twentyten_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'twentyten_widgets_init' );

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 *
 * To override this in a child theme, remove the filter and optionally add your own
 * function tied to the widgets_init action hook.
 *
 * This function uses a filter (show_recent_comments_widget_style) new in WordPress 3.1
 * to remove the default style. Using Twenty Ten 1.2 in WordPress 3.0 will show the styles,
 * but they won't have any effect on the widget in default Twenty Ten styling.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_remove_recent_comments_style() {
	add_filter( 'show_recent_comments_widget_style', '__return_false' );
}
add_action( 'widgets_init', 'twentyten_remove_recent_comments_style' );

if ( ! function_exists( 'twentyten_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_posted_on() {
	printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'twentyten' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'twentyten' ), get_the_author() ),
			get_the_author()
		)
	);
}
endif;

if ( ! function_exists( 'twentyten_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 * @since Twenty Ten 1.0
 */
function twentyten_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	} else {
		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;
