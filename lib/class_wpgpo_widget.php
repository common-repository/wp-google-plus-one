<?php
/**
 * Shows Google +1 box
 */
class wpgpo_WidgetPlusone extends WP_Widget {

	function wpgpo_WidgetPlusone () {
		$widget_ops = array('classname' => __CLASS__, 'description' => __('Shows "Google +1" box on your post pages', 'wpgpo'));
		parent::WP_Widget(__CLASS__, 'Google +1 Widget', $widget_ops);
	}

	function form($instance) {
		$title = esc_attr($instance['title']);
		$appearance = esc_attr($instance['appearance']);
		$show_count = esc_attr($instance['show_count']);

		$appearances = array (
			'small' => __('Small: %s', 'wpgpo'),
			'medium' => __('Medium: %s', 'wpgpo'),
			'standard' => __('Standard: %s', 'wpgpo'),
			'tall' => __('Tall: %s', 'wpgpo'),
		);

		// Set defaults
		// ...
		$appearance = $appearance ? $appearance : 'medium';
		$show_count = $instance['show_count'] ? $show_count : false;

		$html = '<p>';
		$html .= '<label for="' . $this->get_field_id('title') . '">' . __('Title:', 'wpgpo') . '</label>';
		$html .= '<input type="text" name="' . $this->get_field_name('title') . '" id="' . $this->get_field_id('title') . '" class="widefat" value="' . $title . '"/>';
		$html .= '</p>';

		$html .= '<p>';
		$html .= '<label for="' . $this->get_field_id('appearance') . '">' . __('Appearance:', 'wpgpo') . '</label><br />';
		foreach ($appearances as $app => $label) {
			$img = "<br /><img src='" . wpgpo_PLUGIN_URL . "/img/{$app}.png' /> <img src='" . wpgpo_PLUGIN_URL . "/img/{$app}-count.png' />";
			$html .= '<input type="radio" name="' . $this->get_field_name('appearance') . '" id="' . $this->get_field_id('appearance') . '-' . $app . '" value="' . $app . '" ' . (($app==$appearance) ? 'checked="checked"' : '') . ' /> ';
			$html .= '<label for="' . $this->get_field_id('appearance') . '-' . $app . '">' . sprintf($label, $img) . '</label><br />';
		}
		$html .= '</p>';

		$html .= '<p>';
		$html .= '<label for="' . $this->get_field_id('show_count') . '">' . __('Show count:', 'wpgpo') . '</label>';
		$html .= '<input type="checkbox" name="' . $this->get_field_name('show_count') . '" id="' . $this->get_field_id('show_count') . '" value="1" ' . ($show_count ? 'checked="checked"' : '') . ' />';
		$html .= '</p>';

		echo $html;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['appearance'] = strip_tags($new_instance['appearance']);
		$instance['show_count'] = strip_tags($new_instance['show_count']);

		return $instance;
	}

	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);

		$appearance = $instance['appearance'];
		$appearance = $appearance ? $appearance : 'medium';

		$show_count = (int)@$instance['show_count'];
		$show_count = $show_count ? true : false;

		if (is_singular()) { // Show widget only on votable pages
			$codec = new wpgpo_Codec;
			echo $before_widget;
			if ($title) echo $before_title . $title . $after_title;

			echo $codec->process_plusone_code(array(
				'appearance' => $appearance,
				'show_count' => ($show_count ? 'yes' : 'no'),
			));

			echo $after_widget;
		}
	}
}