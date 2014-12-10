<?php
/*
Plugin Name: WordPress OB Cache
Version: 0.1-alpha
Description: WordPress OB Cache
Author: rakuishi
Author URI: http://rakuishi.com
Text Domain: wp-ob-cache
Domain Path: /languages
*/

require_once(plugin_dir_path(__FILE__) . 'class-wp-ob-cache.php');

$wp_ob_cache = new WordPressOBCache();
$wp_ob_cache->load_plugin_hook();
