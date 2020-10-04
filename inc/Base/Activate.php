<?php
/**
 * @package AdvertisersIndex
 */

namespace Inc\Base;


class Activate {
	public static function activate(){
		flush_rewrite_rules();
		if(!get_option('advertisers_plugin')){
			$default_settings = array(
				'cpt_singular_name'=>'Advertiser',
				'cpt_plural_name'=>'Advertisers',
				'taxonomy_singular_name'=>'Expertise',
				'taxonomy_plural_name'=>'Expertises',
			);
			update_option('advertisers_plugin',$default_settings);
		}
		if(!get_option('advertisers_plugin_levels')){
			$default_levels = array(
				array(
					'slug' => 'level_1',
					'title' => 'Free'
				),
				array(
					'slug' => 'level_2',
					'title' => 'Paying'
				),
				array(
					'slug' => 'level_3',
					'title' => 'Premium'
				)
			);
			update_option('advertisers_plugin_levels',$default_levels);
		}
	}
}