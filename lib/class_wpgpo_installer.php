<?php
/**
 * Installs the database, if it's not already present.
 */
class wpgpo_Installer {

	/**
	 * @public
	 * @static
	 */
	function check () {
		$is_installed = get_site_option('wpgpo', false);
		$is_installed = $is_installed ? $is_installed : get_option('wpgpo', false);
		if (!$is_installed) wpgpo_Installer::install();
	}

	/**
	 * @private
	 * @static
	 */
	function install () {
		$me = new wpgpo_Installer;
		$me->create_default_options();
	}

	/**
	 * @private
	 */
	function create_default_options () {
		update_site_option('wpgpo', array (
			'show_count' => 1,
			'front_page' => 1,
			'position' => 'top',
			'appearance' => 'standard',
		));
	}
}