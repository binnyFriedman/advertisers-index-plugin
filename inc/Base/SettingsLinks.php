<?php


namespace Inc\Base;


class SettingsLinks {
	public function register(){
		add_filter( "plugin_action_links_" . ADVERTISERS_INDEX_PLUGIN_ID,array($this,'settings_link'));
	}

	public function settings_link($links){
		$settings_link = '<a href="admin.php?page=advertisers_plugin">'.__('Settings',ADVERTISERS_INDEX_PLUGIN_DOMAIN) . '</a>';
		array_push($links,$settings_link);
		return $links;
	}
}