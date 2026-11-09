<?php
/**
 * Endpoints REST internos do tema.
 *
 * @package JSN
 */

defined( 'ABSPATH' ) || exit;

/**
 * Endpoints internos consumidos por widgets e pelo portal.
 */
final class JSN_REST {

	/**
	 * Liga os hooks REST.
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'rest_api_init', array( __CLASS__, 'register_routes' ) );
	}

	/**
	 * Registra as rotas.
	 *
	 * @return void
	 */
	public static function register_routes() {
		register_rest_route(
			'jsn/v1',
			'/theme',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( __CLASS__, 'theme' ),
				'permission_callback' => '__return_true',
			)
		);

		register_rest_route(
			'jsn/v1',
			'/dashboard',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( __CLASS__, 'dashboard' ),
				'permission_callback' => array( __CLASS__, 'can_view_dashboard' ),
			)
		);
	}

	/**
	 * Dados públicos do tema.
	 *
	 * @return WP_REST_Response
	 */
	public static function theme() {
		$widgets = JSN_Widget_Registry::instance()->get_widgets();

		return rest_ensure_response(
			array(
				'name'      => get_bloginfo( 'name' ),
				'version'   => JSN_THEME_VERSION,
				'home'      => home_url( '/' ),
				'restricted' => get_permalink( get_page_by_path( 'area-restrita' ) ),
				'widgets'   => array_keys( $widgets ),
			)
		);
	}

	/**
	 * Dados do dashboard para usuários autenticados.
	 *
	 * @return WP_REST_Response
	 */
	public static function dashboard() {
		$user = wp_get_current_user();

		return rest_ensure_response(
			array(
				'user'    => array(
					'id'    => $user->ID,
					'name'  => $user->display_name,
					'roles' => array_values( (array) $user->roles ),
				),
				'message' => __( 'Dashboard Condomínio — estrutura pronta para a fase 2.', 'jsn' ),
			)
		);
	}

	/**
	 * Permissão do endpoint de dashboard.
	 *
	 * @return bool
	 */
	public static function can_view_dashboard() {
		return is_user_logged_in();
	}
}
