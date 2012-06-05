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
              $args = array( 'post_type' => 'tf_events', 'posts_per_page' => 2 );
$loop = new WP_Query( $args );
while ( $loop->have_posts() ) : $loop->the_post();


                // - custom variables -
                $custom = get_post_custom(get_the_ID());
                $sd = $custom["tf_events_startdate"][0];
                $ed = $custom["tf_events_enddate"][0];

                $longdate = date("F j, Y", $sd);
                ?>
                             
                             <div class="row agenda-post">
                                <div class="span1 columns">
                                    <?php echo $longdate; ?>
                                </div>
                                <div class="span2 columns">
                                    <h3 class="agenda-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                                   

                                        <p class="agenda-location">
                                           <?php
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
                                            ?>
                                        </p>

                                       
                                </div>
                             </div>
                             <div class="clearfix"></div>
                          <?php endwhile; ?>    
                </div>
            </div>
          </div> <!-- #Content -->
        </div><!--#Container -->
<?php get_footer(); ?>