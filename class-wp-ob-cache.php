<?php

class WordPressOBCache {

	private $cache_filename;
	private $cache_dir;

	public function __construct() {
		$this->cache_dir = ABSPATH . 'wp-content/wp-ob-cache/';
	}

	public function load_plugin_hook() {
		add_action('init', array($this, 'init'));
	}

	public function init() {
		if (!is_dir($this->cache_dir)) {
			$result = mkdir($this->cache_dir, 0777);
			if (!$result) {
				return;
			}
			chmod($this->cache_dir, 0777);
		}

		if (is_user_logged_in()) {
			return;
		}

		$url = $_SERVER['REQUEST_URI'];
		if ($this->is_skip_url($url)) {
			return;
		}

		$this->cache_filename = $this->cache_dir . md5($url);
		if ($this->is_available_cache_file($this->cache_filename)) {
			echo file_get_contents($this->cache_filename);
			exit;
		}

		ob_start(array($this, 'ob_callback'));
	}

	public function ob_callback($buffer) {
		$format = date('Y/m/d H:i:s');
		$buffer = str_replace('</body>', "<!-- {$format} : Cached by WordPress OB Cache -->\n</body>", $buffer);
		file_put_contents($this->cache_filename, $buffer);
		return $buffer;
	}

	public function is_skip_url($url) {
		$skip_url_array = array(
			'/wp-admin/',
			'/wp-login.php',
		);

		foreach ($skip_url_array as $skip_url) {
			if (strpos($url, $skip_url) !== false) {
				return true;
			}
		}

		return false;
	}

	public function is_available_cache_file($filename) {
		return boolval(
			is_file($filename) &&
			filemtime($filename) > time() - 60
		);
	}
	
	/**
	 * プラグインアンインストール時に、作成したファイルとフォルダを削除する
	 */
	public function uninstall() {
		foreach (scandir($this->cache_dir) as $filename) {
			if ($filename == '.' || $filename == '..') {
				continue;
			}
			unlink($this->cache_dir . $filename);
		}
		rmdir($this->cache_dir);
	}
}