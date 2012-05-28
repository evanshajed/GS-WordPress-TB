<?php
/**
 * The Sidebar Containing Widgets for Contacts
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>

	<?php
	/* When we call the dynamic_sidebar() function, it'll spit out
	 * the widgets for that widget area. If it instead returns false,
	 * then the sidebar simply doesn't exist, so we'll hard-code in
	 * some default sidebar stuff just in case.
	 */
	if ( ! dynamic_sidebar( 'category-filter-widget' ) ) : ?>

				Please Add the Multi Category Widget!

		<?php endif; // end Contact Map widget area ?>