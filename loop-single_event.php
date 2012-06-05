<?php
/**
 * The loop that displays a single post.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop-single.php.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.2
 */
?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div id="nav-above" class="navigation">
					<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'twentyten' ) . '</span> %title' ); ?></div>
					<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'twentyten' ) . '</span>' ); ?></div>
				</div><!-- #nav-above -->

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<h1 class="entry-title"><?php the_title(); ?></h1>


					<div class="event-location">
						Waar: 
						<?php
						$area_terms = wp_get_object_terms($post->ID, 'tf_eventarea');
							if(!empty($area_terms)){
							  if(!is_wp_error( $area_terms )){
							    foreach($area_terms as $term){
							      echo '<a href="'.get_term_link($term->slug, 'tf_eventarea').'">'.$term->name.'</a>,'; 
							    }
							  }
							}
						 ?>
						 <?php
						 $location_terms = wp_get_object_terms($post->ID, 'tf_eventcategory');
							if(!empty($location_terms)){
							  if(!is_wp_error( $location_terms )){
							    foreach($location_terms as $term){
							      echo '<a href="'.get_term_link($term->slug, 'tf_eventcategory').'">'.$term->name.'</a>'; 
							    }
							  }
							}
						 ?>
					</div><!-- .entry-meta -->
					<?php 
						// - custom variables -
						$custom = get_post_custom(get_the_ID());
						$sd = $custom["tf_events_startdate"][0];
						$ed = $custom["tf_events_enddate"][0];
						 
						// - determine if it's a new day -
						$longdate = date("F j, Y", $sd);
						$time_format = get_option('time_format');
						$stime = date($time_format, $sd);
						$etime = date($time_format, $ed);
					?>
					<div class="event-date">
						Wanneer: <?php echo $longdate . ', ' . $stime . ' - ' . $etime; ?>
					</div>

					<div class="entry-content">
						<?php the_content(); ?>
						<span class='st_facebook_buttons' st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>' displayText='share'></span><span class='st_twitter_buttons' st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>' displayText='share'></span><span class='st_email_buttons' st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>' displayText='share'></span><span class='st_sharethis_buttons' st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>' displayText='share'></span><span class='st_fblike_buttons' st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>' displayText='share'></span><span class='st_plusone_buttons' st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>' displayText='share'></span>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'twentyten' ), 'after' => '</div>' ) ); ?>
					</div><!-- .entry-content -->

<?php if ( get_the_author_meta( 'description' ) ) : // If a user has filled out their description, show a bio on their entries  ?>
					<div id="entry-author-info">
						<div id="author-avatar">
							<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'twentyten_author_bio_avatar_size', 60 ) ); ?>
						</div><!-- #author-avatar -->
						<div id="author-description">
							<h2><?php printf( __( 'About %s', 'twentyten' ), get_the_author() ); ?></h2>
							<?php the_author_meta( 'description' ); ?>
							<div id="author-link">
								<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" rel="author">
									<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'twentyten' ), get_the_author() ); ?>
								</a>
							</div><!-- #author-link	-->
						</div><!-- #author-description -->
					</div><!-- #entry-author-info -->
<?php endif; ?>

					<div class="entry-utility">
						<?php twentyten_posted_in(); ?>
						<?php edit_post_link( __( 'Edit', 'twentyten' ), '<span class="edit-link">', '</span>' ); ?>
					</div><!-- .entry-utility -->
				</div><!-- #post-## -->

				<div id="nav-below" class="navigation">
					<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'twentyten' ) . '</span> %title' ); ?></div>
					<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'twentyten' ) . '</span>' ); ?></div>
				</div><!-- #nav-below -->

				<?php comments_template( '', true ); ?>

<?php endwhile; // end of the loop. ?>