<form role="search" method="get" id="searchform" action="<?php bloginfo('siteurl'); ?>">
  <div>
    <label class="screen-reader-text" for="s">Search for:</label>
    <input type="text" value="" name="s" id="s" />
    in <?php wp_dropdown_categories( 'show_option_all=All Categories' ); ?>
    <select name="archive-dropdown">
  <option value=""><?php echo esc_attr( __( 'Select Month' ) ); ?></option> 
  <?php wp_get_archives( 'type=monthly&format=option&show_post_count=1' ); ?>
</select>
    <input type="submit" id="searchsubmit" value="Search" />
  </div>
</form>