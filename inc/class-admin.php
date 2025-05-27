<?php

namespace RusAggression\OrganizationCPT;

use WP_Post;
use WP_Term;

final class Admin {
	/** @var self|null */
	private static $instance;

	public static function get_instance(): self {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
		$this->init();
	}

	public function init(): void {
		add_action( 'admin_init', [ $this, 'admin_init' ] );
	}

	public function admin_init(): void {
		add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );
		add_filter( 'wp_insert_post_data', [ $this, 'wp_insert_post_data' ] );
		add_action( 'post_updated', [ $this, 'post_updated' ], 10, 3 );
		add_action( 'save_post_organization', [ $this, 'save_post_organization' ], 10, 2 );
		add_action( 'delete_post_organization', [ $this, 'delete_post_organization' ], 10, 2 );
	}

	public function add_meta_boxes(): void {
		add_meta_box(
			'org_details',
			__( 'Organization Details', 'org-cpt' ),
			[ $this, 'org_meta_box_callback' ],
			'organization',
			'normal',
			'high'
		);
	}

	public function org_meta_box_callback( WP_Post $post ): void {
		$params = [
			'id'          => $post->ID,
			'description' => get_post_field( 'post_content', $post->ID, 'edit' ),
		];

		self::render( 'org-metabox', $params );
	}

	public function wp_insert_post_data( array $data ): array {
		if ( ! isset( $_POST['org_meta_box_nonce'] ) ||
			! is_string( $_POST['org_meta_box_nonce'] ) ||
			! wp_verify_nonce( sanitize_text_field( $_POST['org_meta_box_nonce'] ), 'org_meta_box' )
		) {
			return $data;
		}

		if ( isset( $_POST['org_description'] ) && is_string( $_POST['org_description'] ) ) {
			$data['post_content'] = wp_kses_post( $_POST['org_description'] );
		}

		return $data;
	}

	public function post_updated( int $post_id, WP_Post $post_after, WP_Post $post_before ): void {
		$post_type = get_post_type( $post_id );
		if ( 'organization' === $post_type ) {
			$old_title = $post_before->post_title;
			$new_title = $post_after->post_title;

			if ( $old_title !== $new_title && term_exists( $old_title, 'org' ) ) {
				$term = get_term_by( 'name', $old_title, 'org' );
				if ( $term instanceof WP_Term ) {
					/** @psalm-suppress InvalidArgument -- name *is* allowed */
					wp_update_term( $term->term_id, 'org', [ 'name' => $new_title ] );
				}
			}
		}
	}

	/**
	 * @psalm-suppress UnusedParam
	 */
	public function save_post_organization( int $post_id, WP_Post $post ): void /* NOSONAR */ {
		$post_title = $post->post_title;
		if ( ! term_exists( $post_title, 'org' ) ) {
			wp_insert_term( $post_title, 'org' );
		}
	}

	/**
	 * @psalm-suppress UnusedParam
	 */
	public function delete_post_organization( int $post_id, WP_Post $post ): void /* NOSONAR */ {
		$term = get_term_by( 'name', $post->post_title, 'org' );
		if ( $term instanceof WP_Term ) {
			wp_delete_term( $term->term_id, 'org' );
		}
	}

	/**
	 * @psalm-suppress UnusedParam
	 */
	// phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
	private static function render( string $template, array $params = [] ): void /* NOSONAR */ {
		/** @psalm-suppress UnresolvableInclude */
		require __DIR__ . '/../views/' . basename( $template ) . '.php'; // NOSONAR
	}
}
