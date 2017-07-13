<?php
/*
Plugin Name: WP Cloaker
plugin URI:http://www.wwgate.net
Description: WP Cloaker gives you the ability to shorten your affiliate ugly links and keep track of how many clicks/Hits on each link.
Version:1.4.0
Author: Fadi Ismail
Author URI: http://www.wwgate.net
*/

define('wp_cloaker_url', plugins_url('',__FILE__) );
define('wp_cloaker_path', WP_PLUGIN_DIR.DIRECTORY_SEPARATOR.'wp-cloaker'.DIRECTORY_SEPARATOR );
define('wp_cloaker_version', '1.4.0' );

// if the file is called directly, abort
if(! defined('WPINC')){
	die();
}	
require_once( wp_cloaker_path .'classes/class-wp-cloaker.php');
require_once( wp_cloaker_path .'classes/class-wp-cloaker-clicks.php');
require_once( wp_cloaker_path .'classes/class-wp-cloaker-admin.php');
require_once( wp_cloaker_path .'classes/class-wp-cloaker-reports.php');
function wp_Cloaker_Start(){
	$wp_cloaker = new WP_Cloaker();
	
	$wp_cloaker_clicks = new WP_Cloaker_Clicks();
	
	$wp_cloaker_admin = new WP_Cloaker_Admin();
	
	register_activation_hook(__FILE__,array(&$wp_cloaker_clicks,'wp_cloaker_create_clicks_table'));
	
}
wp_Cloaker_Start();

