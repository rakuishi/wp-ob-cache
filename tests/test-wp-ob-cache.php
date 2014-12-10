<?php

class WordPressOBCacheTest extends WP_UnitTestCase {

	function test_is_skip_url() {
		$wp_ob_cache = new WordPressOBCache();

		$url = 'http://localhost:8888/';
		$this->assertFalse($wp_ob_cache->is_skip_url($url));

		$url = 'http://localhost:8888/wp-login.php';
		$this->assertTrue($wp_ob_cache->is_skip_url($url));

		$url = 'http://localhost:8888/wp-admin/edit.php';
		$this->assertTrue($wp_ob_cache->is_skip_url($url));
	}
}

