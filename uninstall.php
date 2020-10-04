<?php


if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) )
	die;

global $wpdb;

$wpdb->query("DELETE FROM wp_posts where post_type = 'advertiser'");
$wpdb->query("DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts) ");
