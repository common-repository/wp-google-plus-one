<?php
/**
 * Handles public functionality.
 */
class wpgpo_PublicPages {
	var $data;
	var $codec;

	function wpgpo_PublicPages () { $this->__construct(); }

	function __construct () {
		$this->data = new wpgpo_Options;
		$this->codec = new wpgpo_Codec;
	}

	/**
	 * Main entry point.
	 *
	 * @static
	 */
	function serve () {
		$me = new wpgpo_PublicPages;
		$me->add_hooks();
	}

	function js_load_scripts () {
		$lang = $this->data->get_option('language');
		echo '<script type="text/javascript" src="https://apis.google.com/js/plusone.js">';
		if ($lang) {
			echo '{lang: "' . $lang . '"}';
		}
		echo '</script>';
	}
/*
	function css_load_styles () {
		wp_enqueue_style('wpgpo_voting_style', wpgpo_PLUGIN_URL . '/css/plusone.css');
	}
*/

	function inject_plusone_buttons ($body) {
		if (
			(is_home() && !$this->data->get_option('front_page'))
			||
			(!is_home() && !is_singular())
		) return $body;
		$position = $this->data->get_option('position');
		if ('top' == $position || 'both' == $position) {
			$body = $this->codec->get_code('plusone') . ' ' . $body;
		}
		if ('bottom' == $position || 'both' == $position) {
			$body .= " " . $this->codec->get_code('plusone');
		}
		return $body;
	}

	function add_hooks () {
		add_action('wp_print_scripts', array($this, 'js_load_scripts'));
		//add_action('wp_print_styles', array($this, 'css_load_styles'));

		// Automatic +1 buttons
		if ('manual' != $this->data->get_option('position')) {
			add_filter('the_content', array($this, 'inject_plusone_buttons'), 1); // Do this VERY early in content processing
		}

		$this->codec->register();
	}
}