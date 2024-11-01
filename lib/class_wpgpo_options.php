<?php
/**
 * Handles options access.
 */
class wpgpo_Options {
	/**
	 * Gets a single option from options storage.
	 */
	function get_option ($key) {
		$opts = get_option('wpgpo');
		return @$opts[$key];
	}

	/**
	 * Sets all stored options.
	 */
	function set_options ($opts) {
		return WP_NETWORK_ADMIN ? update_site_option('wpgpo', $opts) : update_option('wpgpo', $opts);
	}

	/**
	 * Populates options key for storage.
	 *
	 * @static
	 */
	function populate () {
		$site_opts = get_site_option('wpgpo');
		$site_opts = is_array($site_opts) ? $site_opts : array();

		$opts = get_option('wpgpo');
		$opts = is_array($opts) ? $opts : array();

		$res = array_merge($site_opts, $opts);
		update_option('wpgpo', $res);
	}

}