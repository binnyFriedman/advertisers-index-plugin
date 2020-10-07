<?php
/**
 * @package  AdvertisersIndex
 */

namespace Inc;



final class Init {
	/**
	 * Store all the classes inside an array
	 * @return string[] of class names
	 */
	public static function get_services(){
		return [
			Pages\Dashboard::class,
			Base\Enqueue::class,
			Base\SettingsLinks::class,
			Controllers\Advertiser::class,
			Controllers\ReviewsController::class,
			Controllers\BannerController::class
		];
	}


	public function register_hooks(){
		$domain = ADVERTISERS_INDEX_PLUGIN_DOMAIN;
		load_plugin_textdomain( $domain, false,dirname(ADVERTISERS_INDEX_PLUGIN_ID) . '/languages/' );
	}

	/**
	 * Loop through the classes and initialize all of them and call their register method.
	 */
	public static function register_services(){
		( new Init )->register_hooks();
		foreach (self::get_services() as $class){
			$service = self::instantiate($class);
			if(method_exists( $service,"register")){
				$service->register();
			}
		}
	}

	/**
	 * @param string  $class ClassName from services array
	 *
	 * @return class instance of $class
	 */
	private static function instantiate($class){
			return new $class();
	}
}