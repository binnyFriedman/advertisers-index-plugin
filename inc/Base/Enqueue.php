<?php
/**
 * @package AdvertisersIndex
 */

namespace Inc\Base;


class Enqueue {
	public function register() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
	}

	function enqueue() {
		// enqueue all our scripts
		wp_enqueue_script('media_upload');
		wp_enqueue_media();
		wp_enqueue_style( 'advertisersStyle', ADVERTISERS_INDEX_PLUGIN_URL . 'assets/style.css' );
		wp_enqueue_script( 'advertisersBackendScript', ADVERTISERS_INDEX_PLUGIN_URL . 'assets/src/js/app.js' );
	}
}