<?php
/*
Template Name: Contacten
*/
?>
<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />

  <title>
    <?php
    /*
     * Print the <title> tag based on what is being viewed.
     */
    global $page, $paged;

    wp_title( '|', true, 'right' );

    // Add the blog name.
    bloginfo( 'name' );

    // Add the blog description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) )
        echo " | $site_description";

    // Add a page number if necessary:
    if ( $paged >= 2 || $page >= 2 )
        echo ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );

    ?>
  </title>

  <!-- Mobile viewport optimized: h5bp.com/viewport -->
  <meta name="viewport" content="width=device-width">

  <!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/bootstrap-responsive.min.css">
  <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
  <?php wp_head(); ?>

  <!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->

  <!-- All JavaScript at the bottom, except this Modernizr build.
       Modernizr enables HTML5 elements & feature detects for optimal performance.
       Create your own custom Modernizr build: www.modernizr.com/download/ -->
  <script src="<?php bloginfo('template_url'); ?>/js/libs/modernizr-2.5.3.min.js"></script>
</head>
<body <?php body_class(); ?>>

  <div class="container contacten-container">
    
    <div class="row">

      <!-- Header Stardet -->
      <header id="header" class="span4">
        <hgroup>
          <h1 class="logo"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
          <h2><?php bloginfo( 'description' ); ?></h2>
        </hgroup>


        <nav role="navigation">
          <?php wp_nav_menu( array( 'container_class' => 'nav-header', 'theme_location' => 'primary' ) ); ?>
        </nav>
      </header><!-- #Header Ended-->

      <!-- Main -->
      <div id="main" class="span8">

		<div id="container">
			<div id="content" role="main">

			<?php
			/* Run the loop to output the page.
			 * If you want to overload this in a child theme then include a file
			 * called loop-page.php and that will be used instead.
			 */
			get_template_part( 'loop', 'page' );
			?>

			</div><!-- #content -->
		</div><!-- #container -->

      </div> <!-- #End Main -->
    </div><!--#End of Row -->

    <!-- Footer -->
    <footer>
      <h1 class="visuallyhidden"><?php bloginfo( 'name' );?></h1>
      <div class="row">
        <div class="span10">
          <h6>Partners</h6>
          <ul class="partner-list">
            <li class="">
            <a href="#">Productiehuis <em>Het 5e Huis</em></a>
            </li>
            <li class="">
            <a href="#">Inspiratiehuis <em>Arnhem</em></a>
            </li>
            <li class="">
            <a href="#">Fotographer <em>Lenneke Mietes</em></a>
            </li>
          </ul>     
        </div>
        <div class="span2">
          <div class="copyright">
            <h6>Copyright by</h6>
            <p>&copy; <a href="layout_contacts.html">Grigori Sarolea</a></p>
            <h6>Produced by</h6>
            <p><a href="http://mediaprojects.biz" target="_blank">mediaprojects.biz</a></p>
          </div>
        </div>
      </div>
    </footer><!-- #End of Footer -->
  </div><!--#End of Container -->

  <?php wp_footer(); ?>

  <!-- scripts concatenated and minified via build script -->
  <script src="<?php bloginfo('template_url'); ?>/js/libs/bootstrap.min.js"></script>
  <script src="<?php bloginfo('template_url'); ?>/js/plugins.js"></script>
  <script src="<?php bloginfo('template_url'); ?>/js/script.js"></script>

</body>
</html>
