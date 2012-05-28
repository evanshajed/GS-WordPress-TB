<?php 
/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
/** * Locations taxonomy archive */ 
get_header(); 
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 
?>

		<div id="container">
			<div id="content" role="main">

				<h1 class="page-title">
					Archive <?php echo apply_filters( 'the_title', $term->name ); ?>
				</h1>
				<?php get_sidebar('category'); ?>

				<?php if ( !empty( $term->description ) ): ?> 
					<div class="archive-meta"> 
						<?php echo esc_html($term->description); ?> 
					</div> 
				<?php endif; ?> 
						
				<?php
				/* Run the loop for the category page to output the posts.
				 * If you want to overload this in a child theme then include a file
				 * called loop-category.php and that will be used instead.
				 */
				get_template_part( 'loop', 'location' );
				?>

			</div><!-- #content -->
		</div><!-- #container -->

<?php get_footer(); ?>
