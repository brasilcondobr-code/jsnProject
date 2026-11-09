<?php
/**
 * Endpoints REST do plugin.
 *
 * @package JSN_Widgets_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Rotas /wp-json/jsn/v1/*.
 */
final class JSN_Widgets_Core_REST {

	/**
	 * Registra as rotas.
	 *
	 * @return void
	 */
	public static function register_routes() {
		register_rest_route(
			'jsn/v1',
			'/widgets',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( __CLASS__, 'widgets' ),
				'permission_callback' => '__return_true',
			)
		);

		register_rest_route(
			'jsn/v1',
			'/servicos',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( __CLASS__, 'servicos' ),
				'permission_callback' => '__return_true',
			)
		);

		register_rest_route(
			'jsn/v1',
			'/noticias',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( __CLASS__, 'noticias' ),
				'permission_callback' => '__return_true',
			)
		);
	}

	/**
	 * Índice global de widgets.
	 *
	 * @return WP_REST_Response
	 */
	public static function widgets() {
		return rest_ensure_response( JSN_Widgets_Core::instance()->get_widget_index() );
	}

	/**
	 * Lista de serviços publicados.
	 *
	 * @return WP_REST_Response
	 */
	public static function servicos() {
		return rest_ensure_response( self::get_posts( 'servico' ) );
	}

	/**
	 * Lista de notícias publicadas.
	 *
	 * @return WP_REST_Response
	 */
	public static function noticias() {
		return rest_ensure_response( self::get_posts( 'noticia_condominio' ) );
	}

	/**
	 * Serializa posts de um CPT.
	 *
	 * @param string $post_type Post type.
	 * @return array<int,array<string,mixed>>
	 */
	private static function get_posts( $post_type ) {
		$posts = get_posts(
			array(
				'post_type'      => $post_type,
				'post_status'    => 'publish',
				'posts_per_page' => 20,
				'orderby'        => 'date',
				'order'          => 'DESC',
			)
		);

		return array_map(
			static function ( $post ) {
				return array(
					'id'      => $post->ID,
					'title'   => get_the_title( $post ),
					'excerpt' => wp_strip_all_tags( get_the_excerpt( $post ) ),
					'link'    => get_permalink( $post ),
					'date'    => get_the_date( DATE_W3C, $post ),
				);
			},
			$posts
		);
	}
}
