<?php

namespace RusAggression\OrganizationCPT;

final class OrganizationTaxonomy {
	public static function register(): void {
		if ( taxonomy_exists( 'org' ) ) {
			return;
		}

		$labels = [
			'name'                       => _x( 'Organizations', 'Taxonomy General Name', 'org-cpt' ),
			'singular_name'              => _x( 'Organization', 'Taxonomy Singular Name', 'org-cpt' ),
			'menu_name'                  => __( 'Organizations', 'org-cpt' ),
			'all_items'                  => __( 'All Organizations', 'org-cpt' ),
			'new_item_name'              => __( 'New Organization Name', 'org-cpt' ),
			'add_new_item'               => __( 'Add Organization', 'org-cpt' ),
			'edit_item'                  => __( 'Edit Organization', 'org-cpt' ),
			'update_item'                => __( 'Update Organization', 'org-cpt' ),
			'view_item'                  => __( 'View Organization', 'org-cpt' ),
			'separate_items_with_commas' => __( 'Separate organizations with commas', 'org-cpt' ),
			'add_or_remove_items'        => __( 'Add or remove organizations', 'org-cpt' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'org-cpt' ),
			'popular_items'              => __( 'Popular Organizations', 'org-cpt' ),
			'search_items'               => __( 'Search Organizations', 'org-cpt' ),
			'not_found'                  => __( 'Not Found', 'org-cpt' ),
			'no_terms'                   => __( 'No organizations', 'org-cpt' ),
			'items_list'                 => __( 'Organizations list', 'org-cpt' ),
			'items_list_navigation'      => __( 'Organizations list navigation', 'org-cpt' ),
		];

		$args = [
			'labels'            => $labels,
			'hierarchical'      => false,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_menu'      => true,
			'show_in_nav_menus' => false,
			'show_in_rest'      => true,
			'show_tagcloud'     => false,
		];

		register_taxonomy( 'org', [ 'post' ], $args );
	}

	public static function unregister(): void {
		unregister_taxonomy( 'org' );
	}
}
