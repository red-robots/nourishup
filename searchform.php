<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="search">
		<span class="screen-reader-text"><?php _e( 'Search for:', 'bellaworks' ); ?></span>
		<input type="search" id="search" class="search-field" placeholder="Search &hellip;" value="<?php echo get_search_query(); ?>" name="s" />
	</label>
	<input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'bellaworks' ); ?>" />
</form>
