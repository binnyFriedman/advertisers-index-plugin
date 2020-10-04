<?php
/**
 * @package  AdvertisersIndex
 */

namespace Inc\Controllers;



use Inc\Api\Callbacks\MediaWidgetCallbacks;
use Inc\Base\BaseController;
//use Inc\Api\SettingsApi;
use Inc\Api\Widgets\MediaWidget;


class WidgetController extends BaseController {
	/**
	 * @var SettingsApi
	 */
	public $settings;
	public $subpages =array();
	public $callbacks;

	public function register(){
		if(!$this->activated('widget_manager')){
			return;
		}
		$media_widget = new MediaWidget();
		$media_widget->register();
//		$this->callbacks = new MediaWidgetCallbacks();
//		$this->setSubPages();
//		$this->settings->addSubPages($this->subpages)->register();
	}



//	public function setSubPages() {
//
//		$this->subpages = array(
//			array(
//				'parent_slug' => 'advertisers_plugin',
//				'page_title'  => __( 'Media widget Manager', ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
//				'menu_title'  => __( 'Media widget Manager', ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
//				'capability'  => 'manage_options',
//				'menu_slug'   => 'advertisers_media_widget',
//				'callback'    => array($this->callbacks,'admin'),
//			),
//
//		);
//	}

}