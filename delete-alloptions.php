<?php
/**
 * Plugin Name: Clear alloptions cache.
 * Plugin URI: https://automattic.com
 * Description: Fix a race condition in alloptions caching
 * Version: 1.0.0
 * Author: Automattic
 * Author URI: https://automattic.com
 *
 * @see https://core.trac.wordpress.org/ticket/31245
 */
function jetpack_addons_maybe_clear_alloptions_cache( $option ) {
	if ( ! wp_installing() ) {
		$alloptions = wp_load_alloptions(); // alloptions should be cached at this point.
		if ( isset( $alloptions[ $option ] ) ) { // only if option is among alloptions.
			wp_cache_delete( 'alloptions', 'options' );
		}
	}
}
add_action( 'added_option',   'jetpack_addons_maybe_clear_alloptions_cache' );
add_action( 'updated_option', 'jetpack_addons_maybe_clear_alloptions_cache' );
add_action( 'deleted_option', 'jetpack_addons_maybe_clear_alloptions_cache' );
