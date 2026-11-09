<?php
/**
 * Bootstrap principal do tema JSN.
 *
 * @package JSN
 */

defined( 'ABSPATH' ) || exit;

/**
 * Orquestra os recursos do tema.
 */
final class JSN_Theme {

	/**
	 * Instância única.
	 *
	 * @var JSN_Theme|null
	 */
	private static $instance = null;

	/**
	 * Retorna a instância única.
	 *
	 * @return JSN_Theme
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Construtor privado.
	 */
	private function __construct() {
		add_action( 'after_setup_theme', array( $this, 'setup' ) );
		add_action( 'init', array( $this, 'register_pattern_category' ), 9 );
		add_action( 'init', array( $this, 'register_block_styles' ), 15 );
		add_action( 'init', array( 'JSN_Roles', 'register' ), 20 );
		add_action( 'after_switch_theme', array( 'JSN_Roles', 'register' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		add_action( 'template_redirect', array( $this, 'guard_restricted_pages' ) );
		add_action( 'login_enqueue_scripts', array( $this, 'login_styles' ) );
		add_filter( 'login_headerurl', array( $this, 'login_header_url' ) );
		add_filter( 'login_headertext', array( $this, 'login_header_text' ) );
		add_filter( 'body_class', array( $this, 'body_class' ) );

		JSN_Widget_Registry::instance()->init();
		JSN_REST::init();
	}

	/**
	 * Registra suportes, menus, traduções e estilos de editor.
	 *
	 * @return void
	 */
	public function setup() {
		load_theme_textdomain( 'jsn', JSN_THEME_DIR . '/i18n' );

		$supports = require JSN_THEME_DIR . '/inc/setup/theme-supports.php';
		foreach ( $supports as $feature => $args ) {
			if ( true === $args ) {
				add_theme_support( $feature );
				continue;
			}

			add_theme_support( $feature, $args );
		}

		$menus = require JSN_THEME_DIR . '/inc/setup/menus.php';
		register_nav_menus( $menus );

		add_editor_style( 'assets/dist/base.css' );
	}

	/**
	 * Categoria de padrões Gutenberg dos widgets.
	 *
	 * @return void
	 */
	public function register_pattern_category() {
		if ( ! function_exists( 'register_block_pattern_category' ) ) {
			return;
		}

		register_block_pattern_category(
			'jsn-widgets',
			array( 'label' => __( 'JSN — Widgets', 'jsn' ) )
		);
	}

	/**
	 * Estilos de bloco do editor.
	 *
	 * @return void
	 */
	public function register_block_styles() {
		$file = JSN_THEME_DIR . '/inc/setup/block-styles.php';
		if ( is_readable( $file ) ) {
			require_once $file;
			if ( function_exists( 'jsn_register_block_styles' ) ) {
				jsn_register_block_styles();
			}
		}
	}

	/**
	 * Assets globais do tema.
	 *
	 * @return void
	 */
	public function enqueue_assets() {
		wp_enqueue_style(
			'jsn-base',
			JSN_THEME_URI . '/assets/dist/base.css',
			array(),
			JSN_THEME_VERSION
		);

		wp_enqueue_script(
			'jsn-app',
			JSN_THEME_URI . '/assets/dist/app.js',
			array(),
			JSN_THEME_VERSION,
			true
		);
	}

	/**
	 * Protege páginas marcadas com _jsn_is_restricted.
	 *
	 * @return void
	 */
	public function guard_restricted_pages() {
		if ( is_admin() || is_user_logged_in() || ! is_singular() ) {
			return;
		}

		$post_id    = get_queried_object_id();
		$restricted = (bool) get_post_meta( $post_id, '_jsn_is_restricted', true );
		$template   = (string) get_page_template_slug( $post_id );

		if ( ! $restricted && 'page-templates/dashboard-condominio.php' !== $template ) {
			return;
		}

		$login_url = wp_login_url( get_permalink( $post_id ) );
		wp_safe_redirect( $login_url );
		exit;
	}

	/**
	 * Rebrand visual da tela de login.
	 *
	 * @return void
	 */
	public function login_styles() {
		$css = '
			body.login { background: #0b1f2a; }
			body.login::before {
				content: "";
				position: fixed;
				inset: 0;
				background:
					radial-gradient(circle at 20% 20%, rgba(26, 188, 156, .30), transparent 42%),
					radial-gradient(circle at 85% 75%, rgba(52, 152, 219, .22), transparent 40%);
				pointer-events: none;
			}
			#login { position: relative; z-index: 1; padding-top: 7vh; }
			.login h1 a {
				background-image: none;
				width: auto;
				height: auto;
				text-indent: 0;
				font-size: 28px;
				font-weight: 700;
				color: #ffffff;
				letter-spacing: -.02em;
			}
			.login form {
				border-radius: 16px;
				border: 1px solid rgba(255,255,255,.14);
				background: rgba(255,255,255,.97);
				box-shadow: 0 24px 60px rgba(0,0,0,.35);
				padding: 28px;
			}
			.login label { color: #17313d; font-weight: 600; }
			.login input[type="text"], .login input[type="password"] {
				border-radius: 10px;
				border-color: #cfd8dc;
				padding: 10px 12px;
				box-shadow: none;
			}
			.login input:focus { border-color: #1abc9c; box-shadow: 0 0 0 1px #1abc9c; }
			.wp-core-ui .button-primary {
				background: #1abc9c;
				border-color: #16a085;
				border-radius: 10px;
				text-shadow: none;
				box-shadow: none;
				padding: 4px 18px;
			}
			.wp-core-ui .button-primary:hover { background: #16a085; }
			.login #nav a, .login #backtoblog a { color: #d7f5ee !important; }
			.login .message, .login .success, .login .notice {
				border-left-color: #1abc9c;
				border-radius: 10px;
			}
		';

		wp_register_style( 'jsn-login', false, array(), JSN_THEME_VERSION );
		wp_enqueue_style( 'jsn-login' );
		wp_add_inline_style( 'jsn-login', $css );
	}

	/**
	 * URL do logo na tela de login.
	 *
	 * @return string
	 */
	public function login_header_url() {
		return home_url( '/' );
	}

	/**
	 * Texto do logo na tela de login.
	 *
	 * @return string
	 */
	public function login_header_text() {
		return get_bloginfo( 'name' );
	}

	/**
	 * Classes extras no body.
	 *
	 * @param array<int,string> $classes Classes.
	 * @return array<int,string>
	 */
	public function body_class( $classes ) {
		$classes[] = 'jsn-theme';
		if ( is_user_logged_in() ) {
			$classes[] = 'jsn-logged-in';
		}

		return $classes;
	}
}
