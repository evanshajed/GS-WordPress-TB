<?php get_header(); ?>

        <!-- Tweet Call -->
            <aside class="query">

            </aside>
        <div id="indexContainer">
          <div id="content indexContent" role="main">
            <div class="row">
                <div class="span5">
                    <div class="row">
                        <div class="index-post-content">
                            <h4 class="span3 widget-title">LAATSTE NIEUWS</h4>
                            <?php 
                                 query_posts('cat=1&posts_per_page=1');
                                if(have_posts()) :
                            ?>
                             <?php while(have_posts()): the_post(); ?>
                             <div class="span5">
                                <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                                <ul class="entry-meta">
                                    <li><?php echo get_the_date();?></li>
                                    <li><?php echo get_the_category_list( ', ' );?></li>
                                </ul>
                             </div>
                            <div class="span5">
                                <?php the_excerpt();?>
                            </div>
                            <?php endwhile;?>
                            <?php else:?>
                            <?php endif; wp_reset_query();?>
                        </div>
                        <div class="clearfix"></div>
                        <div class="index-photo-post">
                            <?php 
                                 query_posts('tag=photo&posts_per_page=1');
                                if(have_posts()) :
                            ?>
                             <?php while(have_posts()): the_post(); ?>
                             <div class="span2">
                                     <?php 
                                        //This must be in one loop
                                         if(has_post_thumbnail()) {?>
              
                                        <a class="thumb" href="<?php the_permalink();?>" title="<?php the_title();?>"><?php the_post_thumbnail('blogThumb'); ?></a>
                                         <?php } else {
                                             echo '';
                                         }
                                        ?>
                             </div>
                             <div class="span2">
                                <h3 class="widget-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                                <ul class="entry-meta">
                                    <li><?php echo get_the_date();?></li>
                                    <li><?php echo get_the_tag_list();?></li>
                                </ul>
                             </div>
                            
                            <?php endwhile;?>
                            <?php else:?>
                            <?php endif; wp_reset_query();?>
                        </div>
                        <div class="clearfix"></div>
                        <div class="index-video-post">
                            <?php 
                                 query_posts('tag=video&posts_per_page=1');
                                if(have_posts()) :
                            ?>
                             <?php while(have_posts()): the_post(); ?>
                             <div class="span2">
                                     <?php 
                                        //This must be in one loop
                                         if(has_post_thumbnail()) {?>
              
                                        <a class="thumb" href="<?php the_permalink();?>" title="<?php the_title();?>"><?php the_post_thumbnail('blogThumb'); ?></a>
                                         <?php } else {
                                             echo '';
                                         }
                                        ?>
                             </div>
                             <div class="span2">
                                <h3 class="widget-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                                <ul class="entry-meta">
                                    <li><?php echo get_the_date();?></li>
                                    <li><?php echo get_the_tag_list();?></li>
                                </ul>
                             </div>
                            
                            <?php endwhile;?>
                            <?php else:?>
                            <?php endif; wp_reset_query();?>
                        </div>
                    </div>
                </div>
                <div class="span3 index-agenda">
                    <h4 class="widget-title">AGENDA</h4>
                    <?php 
                                 query_posts('cat=4&posts_per_page=2');
                                if(have_posts()) :
                            ?>
                             <?php while(have_posts()): the_post(); ?>
                             
                             <div class="row agenda-post">
                                <div class="span1 columns">
                                    <?php echo get_the_date(); ?>
                                </div>
                                <div class="span2 columns">
                                    <h3 class="agenda-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                                    <?php
                                        $terms = get_the_terms( $post->ID, 'location' );
                                                                
                                        if ( $terms && ! is_wp_error( $terms ) ) : 

                                            $draught_links = array();

                                            foreach ( $terms as $term ) {
                                                $draught_links[] = $term->name;
                                            }
                                                                
                                            $on_draught = join( ", ", $draught_links );
                                        ?>

                                        <p class="agenda-location">
                                            @<?php echo $on_draught; ?>
                                        </p>

                                        <?php endif; ?>
                                </div>
                             </div>
                             <div class="clearfix"></div>
                            
                            <?php endwhile;?>
                            <?php else:?>
                            <?php endif; wp_reset_query();?>
                </div>
            </div>
          </div> <!-- #Content -->
        </div><!--#Container -->
<?php get_footer(); ?>