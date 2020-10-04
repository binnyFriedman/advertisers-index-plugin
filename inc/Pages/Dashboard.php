<?php
/**
 * @package AdvertisersIndex
 */

namespace Inc\Pages;
use Inc\Base\BaseController;
use Inc\Api\SettingsApi;
use Inc\Api\Callbacks\DashboardCallbacks;
use Inc\Api\Callbacks\ManagerCallbacks;

class Dashboard extends BaseController {
	public $settings;
	public $pages = array();
	public $callbacks;
	public $callbacks_mngr;

	public function register() {
		$this->settings       = new SettingsApi();
		$this->callbacks      = new DashboardCallbacks();
		$this->callbacks_mngr = new ManagerCallbacks();

		$this->setPages();
		$this->setSettings();
		$this->setSections();
		$this->setFields();
		$this->settings->addPages( $this->pages )->withSubPage( __( 'Dashboard', ADVERTISERS_INDEX_PLUGIN_DOMAIN ) )->register();
	}

	public function setPages() {
		$this->pages = array(
			array(

				'page_title' => __( 'Advertisers', ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
				'menu_title' => __( 'Advertiser Settings', ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
				'capability' => 'manage_options',
				'menu_slug'  => 'advertisers_plugin',
				'callback'   => array( $this->callbacks, 'adminDashboard' ),
				'icon_url'   => 'dashicons-store',
				'position'   => 110
			)
		);
	}


	public function setSettings() {
		$args = array(
			array(
			'option_group' => 'advertisers_plugin_settings',
			'option_name'  => 'advertisers_plugin',
			'callback'     => array( $this->callbacks_mngr, 'checkboxSanitize' )
			),
			array(
			'option_group' => 'advertisers_plugin_taxonomy',
			'option_name'  => 'advertisers_plugin_taxonomy',
			'callback'     => array( $this->callbacks_mngr, 'checkboxSanitize' )
			),
			array(
			'option_group' => 'advertisers_plugin_levels_settings',
			'option_name'  => 'advertisers_plugin_levels',
			'callback'     => array( $this->callbacks_mngr, 'levelsFieldSanitize' )
			),
			array(
			'option_group' => 'advertisers_plugin_facebook_settings',
			'option_name'  => 'advertisers_facebook_settings',
			'callback'     => array( $this->callbacks_mngr, 'facebookSettingsFieldsSanitize' )
			),
		);

		$this->settings->setSettings( $args );
	}

	public function setSections() {
		$args = array(
			array(
				'id'       => 'advertisers_admin_cpt',
				'title'    => __( 'Settings Manager', ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
				'callback' => array( $this->callbacks_mngr, 'adminSectionManager' ),
				'page'     => 'advertisers_plugin'
			),
			array(
				'id'       => 'advertisers_admin_taxonomy',
				'title'    => __( 'Taxonomy Manager', ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
				'callback' => array( $this->callbacks_mngr, 'adminTaxonomyManager' ),
				'page'     => 'advertisers_plugin'
			),
			array(
				'id'       => 'advertisers_admin_levels',
				'title'    => __( 'Advertisers Levels Manager', ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
				'callback' => array( $this->callbacks_mngr, 'adminLevelsManager' ),
				'page'     => 'advertisers_plugin'
			),
			array(
				'id'       => 'advertisers_facebook_settings',
				'title'    => __( 'Facebook app settings', ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
				'callback' => array( $this->callbacks_mngr, 'facebookAppSettings' ),
				'page'     => 'advertisers_plugin'
			)
		);
		$this->settings->setSections( $args );
	}

	public function setFields() {
		$args = array();
		// add fields to set cpt name sing and plural, and hieratical
		$fields = array(
			'cpt_singular_name' => array(
				'title'=>'Cpt singular name.',
				'input_type'=>'text',
				'description'=>'Name of the index item in singular form e.g Advertiser',
				'section'=> 'advertisers_admin_cpt',
				'place_holder'=>'Advertiser'

			),
			'cpt_plural_name' => array(
				'title'=>'Cpt plural name',
				'input_type'=>'text',
				'description'=>'Name of the index item in plural form e.g Advertisers',
				'section'=> 'advertisers_admin_cpt',
				'place_holder'=>'Advertisers'


			),
			'cpt_is_hierarchical' => array(
				'title'=>'Hierarchical?',
				'input_type'=>'checkbox',
				'section'=> 'advertisers_admin_cpt',
				'description'=>'',
				'place_holder'=>''

			),
			'taxonomy_singular_name' => array(
				'title'=>'Taxonomy singular name.',
				'input_type'=>'text',
				'description'=>'Name of the taxonomy in singular form e.g Expertise',
				'section'=> 'advertisers_admin_taxonomy',
				'place_holder'=>'Expertise'

			),
			'taxonomy_plural_name' => array(
				'title'=>'Taxonomy plural name',
				'input_type'=>'text',
				'description'=>'Name of the taxonomy in plural form e.g Expertises',
				'section'=> 'advertisers_admin_taxonomy',
				'place_holder'=>'Expertises'


			),'app_id' => array(
				'title'=>'Facebook app id',
				'input_type'=>'text',
				'description'=>'The app id given by facebook',
				'section'=> 'advertisers_facebook_settings',
				'place_holder'=>'app-id',
				'option_name' => 'advertisers_facebook_settings',

			),'app_secret' => array(
				'title'=>'Facebook app secret',
				'input_type'=>'text',
				'description'=>'The app secret given by facebook',
				'section'=> 'advertisers_facebook_settings',
				'place_holder'=>'app-secret',
				'option_name' => 'advertisers_facebook_settings',
			),
		);
		foreach ($fields as $key=>$value){
			$callback = isset($value['callback'])?$value['callback']:array( $this->callbacks_mngr, 'checkboxField' );
			$option_name = isset($value['option_name'])?$value['option_name']:'advertisers_plugin';
			$args[] = array(
				'id'       => $key,
				'title'    => __( $value['title'], ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
				'callback' => $callback,
				'page'     => 'advertisers_plugin',
				'section'  => $value['section'],
				'args'     => array(
					'option_name' => $option_name,
					'label_for' => $key,
					'class'     => 'ui_toggle',
					'input_type'=> $value['input_type'],
					'description'=>$value['description'],
					'place_holder' => $value['place_holder']
				)
			);
		}

		$args[] = array(
			'id'=>      'advertisers_plugin_levels',
			'title'    => __( 'Manage Levels', ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			'callback' => array( $this->callbacks_mngr, 'levelsField' ),
			'page'     => 'advertisers_plugin',
			'section'  => 'advertisers_admin_levels',
			'args' => array()

		);




		$this->settings->setFields( $args );
	}


}