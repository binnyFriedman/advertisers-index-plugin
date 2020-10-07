<?php
/**
 * @package AdvertisersIndex
 */
/*
Plugin Name: Advertisers Index
Version: 1.0.0
Author: Nekuda
Author URI: https://nekuda.co.il
License: GPLv2 or later
Text Domain: advertisers-index
Domain Path: /languages/
*/

defined( 'ABSPATH' ) or die( 'Hey, what are you doing here? You silly human!' );

if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

define( 'ADVERTISERS_INDEX_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'ADVERTISERS_INDEX_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'ADVERTISERS_INDEX_PLUGIN_ID', plugin_basename( __FILE__ ) );
define( 'ADVERTISERS_INDEX_PLUGIN_DOMAIN', 'advertisers-index');

use Inc\Base\Activate;
use Inc\Base\Deactivate;

function activate_advertisers_plugin(){
	Activate::activate();
}

function deactivate_advertisersIndex_plugin(){
	Deactivate::deactivate();
}

register_activation_hook(__FILE__, "activate_advertisers_plugin" );
register_deactivation_hook(__FILE__,"deactivate_advertisersIndex_plugin");


if ( class_exists( 'Inc\\Init' ) ) {
	Inc\Init::register_services();
}