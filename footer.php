      </div> <!-- #End Main -->
    </div><!--#End of Row -->

    <!-- Footer -->
    <footer>
      <h1 class="visuallyhidden"><?php bloginfo( 'name' );?></h1>
      <div class="row">
        <div class="span10 partner-section">
          <h6>Partners</h6>
          <ul>
            <li>
            <a href="#">Productiehuis <em>Het 5e Huis</em></a>
            </li>
            <li>
            <a href="#">Inspiratiehuis <em>Arnhem</em></a>
            </li>
            <li>
            <a href="#">Fotographer <em>Lenneke Mietes</em></a>
            </li>
          </ul>     
        </div>
        <div class="span2">
          <div class="copyright">
            <h6>Copyright by</h6>
            <p>&copy; <a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
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
  <script src="<?php bloginfo('template_url'); ?>/js/script.js"></script>

</body>
</html>
