<?php
/**
 * Handles all Admin access functionality.
 */
class wpgpo_AdminPages {

	var $data;

	function wpgpo_AdminPages () { $this->__construct(); }

	function __construct () {
		$this->data = new wpgpo_Options;
	}

	/**
	 * Main entry point.
	 *
	 * @static
	 */
	function serve () {
		$me = new wpgpo_AdminPages;
		$me->add_hooks();
	}

	function create_site_admin_menu_entry () {
		if (@$_POST && isset($_POST['option_page']) && 'wpgpo' == @$_POST['option_page']) {
			if (isset($_POST['wpgpo'])) {
				$this->data->set_options($_POST['wpgpo']);
			}
			$goback = add_query_arg('settings-updated', 'true',  wp_get_referer());
			wp_redirect($goback);
		}
		add_submenu_page('settings.php', 'Google +1', 'Google +1', 'manage_network_options', 'wpgpo', array($this, 'create_admin_page'));
	}

	function register_settings () {
		$form = new wpgpo_AdminFormRenderer;

		register_setting('wpgpo', 'wpgpo');
		add_settings_section('wpgpo_settings', __('Google +1 settings', 'wpgpo'), create_function('', ''), 'wpgpo_options_page');
		add_settings_field('wpgpo_appearance', __('Appearance', 'wpgpo'), array($form, 'create_appearance_box'), 'wpgpo_options_page', 'wpgpo_settings');
		add_settings_field('wpgpo_show_cout', __('Show +1s count', 'wpgpo'), array($form, 'create_show_count_box'), 'wpgpo_options_page', 'wpgpo_settings');
		add_settings_field('wpgpo_position', __('Google +1 box position', 'wpgpo'), array($form, 'create_position_box'), 'wpgpo_options_page', 'wpgpo_settings');
		add_settings_field('wpgpo_skip_post_types', __('Do <strong>NOT</strong> Google +1 box for these post types', 'wpgpo'), array($form, 'create_skip_post_types_box'), 'wpgpo_options_page', 'wpgpo_settings');
		add_settings_field('wpgpo_language', __('Language', 'wpgpo'), array($form, 'create_language_box'), 'wpgpo_options_page', 'wpgpo_settings');
		add_settings_field('wpgpo_front_page', __('Show +1 on Front Page', 'wpgpo'), array($form, 'create_front_page_box'), 'wpgpo_options_page', 'wpgpo_settings');
	}

	function create_blog_admin_menu_entry () {
		add_options_page('Google +1', 'Google +1', 'manage_options', 'wpgpo', array($this, 'create_admin_page'));
	}

	function create_admin_page () {
		include(wpgpo_PLUGIN_BASE_DIR . '/lib/forms/plugin_settings.php');
	}

	function add_hooks () {
		// Step0: Register options and menu
		add_action('admin_init', array($this, 'register_settings'));
		if (WP_NETWORK_ADMIN) {
			add_action('network_admin_menu', array($this, 'create_site_admin_menu_entry'));
		} else {
			add_action('admin_menu', array($this, 'create_blog_admin_menu_entry'));
		}


	}
}