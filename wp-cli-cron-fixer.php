<?php
/**
 * Plugin Name: WP CLI Cron Fixer
 * Plugin URI:  https://github.com/ocean90/wp-cli-cron-fixer
 * Description: Using wp cli, remove broken entries from the cron array.
 * Version:     0.1.0
 * Author:      Dominik Schilling
 * Author URI:  https://dominikschilling.de
 * License:     GPL v2.0+
 */

if ( ! class_exists( 'WP_CLI' ) ) {
	return;
}

/**
 * Removes broken entries from the cron array.
 *
 * ## OPTIONS
 *
 * [--dry-run]
 * : Run the fix and show report, but don't fix the broken cron.
 */
function ds_wpcli_cron_fixer( $args, $assoc_args ) {
	$dry_run = ( isset( $assoc_args['dry-run'] ) && (bool) $assoc_args['dry-run'] );

	$cron_array = _get_cron_array();

	// https://core.trac.wordpress.org/ticket/33423
	if ( isset( $cron_array['wp_batch_split_terms'] ) ) {
		WP_CLI::log( sprintf( 'The cron hook for "wp_batch_split_terms" contains %d entries.', count( $cron_array['wp_batch_split_terms'] ) ) );

		if ( ! $dry_run ) {
			unset( $cron_array['wp_batch_split_terms'] );
			_set_cron_array( $cron_array );
			WP_CLI::success( 'The cron hook "wp_batch_split_terms" was removed.' );
		}
	}
}

/**
for SITE in $(wp site list --field=url); do \
    echo "$SITE"; \
    wp cron event fixer --url=$SITE; \
done
 */
WP_CLI::add_command( 'cron event fixer', 'ds_wpcli_cron_fixer' );
