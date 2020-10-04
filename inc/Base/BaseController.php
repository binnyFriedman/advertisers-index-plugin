<?php
/**
 * @package AdvertisersIndex
 */


namespace Inc\Base;


class BaseController {
	public $managers = array();
	public function __construct(){
		$this->managers = [
			'cpt_manager'=>'Activate CPT Manager',
			'taxonomy_manager'=>'Activate Taxonomy Manager',
			'testimonial_manager'=>'Activate Testimonial Manager',
			'templates_manager'=>'Activate Templates Manager',
		];
	}

	public function activated($name){
		$checkbox = get_option( 'advertisers_plugin' );
		return isset( $checkbox[ $name ] ) ? $checkbox[ $name ] : false;
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
				'search_items'      => __( "Search $plural", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
				'all_items'         => __( "All $plural", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
				'parent_item'       => __( "Parent $single", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
				'parent_item_colon' => __( "Parent $single:", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
				'edit_item'         => __( "Edit $single", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
				'update_item'       => __( "Update $single", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
				'add_new_item'      => __( "Add New $single", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
				'new_item_name'     => __( "New $single Name", ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
				'menu_name'         => __( $single, ADVERTISERS_INDEX_PLUGIN_DOMAIN ),
			);

			$args = array(
				'hierarchical'      => $hierarchical,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_in_rest'      => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'expertise' ),
			);

			register_taxonomy( $slug, $supports, $args );
		}
	}

}
