<?php
/**
 * @package  AdvertisersIndex
 */

namespace inc\Controllers;



use Inc\Api\Callbacks\GalleryManagerCallBacks;
use Inc\Base\BaseController;
use Inc\Api\SettingsApi;

class GalleryManager extends BaseController {
	/**
	 * @var SettingsApi
	 */
	public $settings;
	public $subpages =array();
	public $callbacks;

	public function register(){
		if(!$this->activated('gallery_manager')){
			return;
		}
		$this->settings = new SettingsApi();
		$this->callbacks = new GalleryManagerCallBacks();
		$this->setSubPages();
		$this->settings->addSubPages($this->subpages)->register();
	}



	public function setSubPages() {

		$this->subpages = array(
			array(
				'parent_slug' => 'advertisers_plugin',
				'page_title'  => __( 'Gallery Manager', ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
				'menu_title'  => __( 'Gallery Manager', ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
				'capability'  => 'manage_options',
				'menu_slug'   => 'advertisers_gallery',
				'callback'    => array($this->callbacks,'admin'),
			),

		);
	}

}