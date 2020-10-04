<?php
/**
 * @package AdvertisersIndex
 */

namespace Inc\Api\Callbacks;


class DashboardCallbacks {
	public function adminDashboard(){
		return require_once(ADVERTISERS_INDEX_PLUGIN_PATH."templates/admin.php");
	}


}