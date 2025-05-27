<?php

namespace RusAggression\OrganizationCPT;

final class OrganizationPostType {
	public static function register(): void {
		if ( post_type_exists( 'organization' ) ) {
			return;
		}

		$labels = [
			'name'               => _x( 'Organizations', 'post type general name', 'org-cpt' ),
			'singular_name'      => _x( 'Organization', 'post type singular name', 'org-cpt' ),
			'menu_name'          => _x( 'Organizations', 'admin menu', 'org-cpt' ),
			'add_new'            => _x( 'Add New', 'database', 'org-cpt' ),
			'add_new_item'       => __( 'Add New Organization', 'org-cpt' ),
			'edit_item'          => __( 'Edit Organization', 'org-cpt' ),
			'new_item'           => __( 'New Organization', 'org-cpt' ),
			'view_item'          => __( 'View Organization', 'org-cpt' ),
			'search_items'       => __( 'Search Organizations', 'org-cpt' ),
			'not_found'          => __( 'No organizations found', 'org-cpt' ),
			'not_found_in_trash' => __( 'No organizations found in trash', 'org-cpt' ),
		];

		$args = [
			'labels'             => $labels,
			'public'             => true,
			'has_archive'        => true,
			'publicly_queryable' => true,
			'query_var'          => true,
			'rewrite'            => [ 'slug' => 'organization' ],
			'capability_type'    => 'post',
			'hierarchical'       => false,
			'supports'           => [ 'title', 'thumbnail' ],
			'menu_position'      => 5,
			'menu_icon'          => 'dashicons-building',
			'show_in_rest'       => true,
			'rest_base'          => 'organizations',
		];

		register_post_type( 'organization', $args );
	}

	public static function unregister(): void {
		unregister_post_type( 'organization' );
	}
}
