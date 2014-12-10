<?php

if (!defined('WP_UNINSTALL_PLUGIN'))
	exit;

require_once(plugin_dir_path(__FILE__) . 'class-wp-ob-cache.php');

$wp_ob_cache = new WordPressOBCache();
$wp_ob_cache->uninstall();