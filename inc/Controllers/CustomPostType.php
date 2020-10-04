<?php
/**
 * @package  AdvertisersIndex
 */

namespace inc\Controllers;



use Inc\Api\Callbacks\CustomPostTypesCallBacks;
use Inc\Base\BaseController;
use Inc\Api\SettingsApi;

class CustomPostType extends BaseController {
	/**
	 * @var SettingsApi
	 */
	public $settings;
	public $subpages =array();
	public $callbacks;

	public function register(){
		if(!$this->activated('cpt_manager')){
			return;
		}
		$this->settings = new SettingsApi();
		$this->callbacks = new CustomPostTypesCallBacks();
		$this->setSubPages();
		$this->settings->addSubPages($this->subpages)->register();
		add_action('init',array($this,'activate'));
	}

	public function activate(){

		$labels = [
			"name" => __( "Advertisers", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			"singular_name" => __( "Advertiser", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			"menu_name" => __( "Advertisers", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			"all_items" => __( "All Advertisers", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			"add_new" => __( "Add new", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			"add_new_item" => __( "Add new Advertiser", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			"edit_item" => __( "Edit Advertiser", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			"new_item" => __( "New Advertiser", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			"view_item" => __( "View Advertiser", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			"view_items" => __( "View Advertisers", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			"search_items" => __( "Search Advertisers", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			"not_found" => __( "No Advertisers found", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			"not_found_in_trash" => __( "No Advertisers found in trash", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			"parent" => __( "Parent Advertiser:", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			"featured_image" => __( "Featured image for this Advertiser", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			"set_featured_image" => __( "Set featured image for this Advertiser", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			"remove_featured_image" => __( "Remove featured image for this Advertiser", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			"use_featured_image" => __( "Use as featured image for this Advertiser", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			"archives" => __( "Advertiser archives", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			"insert_into_item" => __( "Insert into Advertiser", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			"uploaded_to_this_item" => __( "Upload to this Advertiser", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			"filter_items_list" => __( "Filter Advertisers list", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			"items_list_navigation" => __( "Advertisers list navigation", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			"items_list" => __( "Advertisers list", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			"attributes" => __( "Advertisers attributes", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			"name_admin_bar" => __( "Advertiser", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			"item_published" => __( "Advertiser published", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			"item_published_privately" => __( "Advertiser published privately.", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			"item_reverted_to_draft" => __( "Advertiser reverted to draft.", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			"item_scheduled" => __( "Advertiser scheduled", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			"item_updated" => __( "Advertiser updated.", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			"parent_item_colon" => __( "Parent Advertiser:", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
		];

		$args = array(
			"label" => __( "Advertisers", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			"labels" => $labels,
			"description" => "",
			"public" => true,
			"publicly_queryable" => true,
			"show_ui" => true,
			"show_in_rest" => true,
			"rest_base" => "",
			"rest_controller_class" => "WP_REST_Posts_Controller",
			"has_archive" => false,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"delete_with_user" => false,
			"exclude_from_search" => false,
			"capability_type" => "post",
			"map_meta_cap" => true,
			"hierarchical" => false,
			"rewrite" => array( "slug" => "advertiser", "with_front" => true ),
			"query_var" => true,
			"menu_position" => 5,
			"supports" => array( "title", "editor", "thumbnail", "excerpt", "revisions", "author" ),
		);

		register_post_type( "advertiser", $args );
	}

	public function setSubPages() {

		$this->subpages = array(
			array(
				'parent_slug' => 'advertisers_plugin',
				'page_title'  => __( 'Costume post types', ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
				'menu_title'  => __( 'CPT', ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
				'capability'  => 'manage_options',
				'menu_slug'   => 'advertisers_cpt',
				'callback'    => array($this->callbacks,'CPT'),
			),

		);
	}

}