<?php
/**
 * @package AdvertisersIndex
 */


namespace Inc\Base;


class BaseController {
	public $managers = array();
	public  $cpts = array();
	public  $taxes = array();
	private $prefix = "";
	public function __construct(){
		$this->cpts = [
			'advertiser'=>$this->prefix."advertiser",
			'banner'=> $this->prefix ."banner",
			'review' => $this->prefix ."review"
		];
		$this->taxes = [
			'banner_zones'=>$this->prefix."banner_zones",
			'expertise' => $this->prefix."expertise",
			'profession' => $this->prefix."profession"
		];
	}



	public function registerTaxes(array $taxonomies){
		foreach ($taxonomies as $slug => $taxonomy){
			$single =$taxonomy['single'];
			$plural = $taxonomy['plural'];
			$hierarchical =  $taxonomy['hierarchical'];
			$supports = $taxonomy['supports'];
			$labels = array(
				'name'              => _x( $plural, 'taxonomy general name', ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
				'singular_name'     => _x( $single, 'taxonomy singular name', ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
				'search_items'      => sprintf(__( "Search %s", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),$plural),
				'all_items'         => sprintf(__( "All %s", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),$plural),
				'parent_item'       => sprintf(__( "Parent %s", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),$single),
				'parent_item_colon' => sprintf(__( "Parent %s:", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),$single),
				'edit_item'         => sprintf(__( "Edit %s", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),$single),
				'update_item'       => sprintf(__( "Update %s", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),$single),
				'add_new_item'      => sprintf(__( "Add New %s", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),$single),
				'new_item_name'     => sprintf(__( "New %s Name", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),$single),
				'menu_name'         => _x( $plural, 'taxonomy general name', ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			);

			$args = array(
				'hierarchical'      => $hierarchical,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_in_rest'      => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => $slug ),
			);

			register_taxonomy( $slug, $supports, $args );
		}
	}

}
