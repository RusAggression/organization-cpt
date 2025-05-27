<?php
/*
 * Plugin Name: Organization CPT
 * Version: 1.0.0
 * Author: Prometheus
 * License: MIT
 * Text Domain: org-cpt
 * Domain Path: /lang
 */

use RusAggression\OrganizationCPT\Plugin;

if ( defined( 'ABSPATH' ) ) {
	$autoload_path = 'vendor/autoload.php';
	
	if ( file_exists( __DIR__ . '/' . $autoload_path ) ) {
		require_once __DIR__ . '/' . $autoload_path;
	} elseif ( file_exists( ABSPATH . $autoload_path ) ) {
		require_once ABSPATH . $autoload_path;
	}

	Plugin::get_instance();
}
