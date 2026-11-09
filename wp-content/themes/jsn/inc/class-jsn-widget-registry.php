<?php
/**
 * Registro central de widgets independentes.
 *
 * @package JSN
 */

defined( 'ABSPATH' ) || exit;

/**
 * Descobre, registra e renderiza os widgets do tema.
 */
final class JSN_Widget_Registry {

	/**
	 * Instância única.
	 *
	 * @var JSN_Widget_Registry|null
	 */
	private static $instance = null;

	/**
	 * Widgets descobertos.
	 *
	 * @var array<string, array<string, mixed>>
	 */
	private $widgets = array();

	/**
	 * Handles já enfileirados.
	 *
	 * @var array<string, bool>
	 */
	private $enqueued = array();

	/**
	 * Indica se a descoberta já rodou.
	 *
	 * @var bool
	 */
	private $discovered = false;

	/**
	 * Retorna a instância única.
	 *
	 * @return JSN_Widget_Registry
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
	private function __construct() {}

	/**
	 * Liga os hooks do registro.
	 *
	 * @return void
	 */
	public function init() {
		add_action( 'init', array( $this, 'discover' ), 20 );
		add_shortcode( 'jsn_widget', array( $this, 'render_shortcode' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_for_current_post' ), 20 );
	}

	/**
	 * Varre widgets/* e carrega cada widget autocontido.
	 *
	 * @return void
	 */
	public function discover() {
		if ( $this->discovered ) {
			return;
		}

		$this->discovered = true;
		$directories      = glob( JSN_THEME_DIR . '/widgets/*', GLOB_ONLYDIR );

		if ( empty( $directories ) ) {
			return;
		}

		foreach ( $directories as $directory ) {
			$slug     = basename( $directory );
			$metadata = $directory . '/widget.json';

			if ( ! is_readable( $metadata ) ) {
				continue;
			}

			$meta = json_decode( (string) file_get_contents( $metadata ), true ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
			if ( ! is_array( $meta ) ) {
				continue;
			}

			$class_name = 'JSN_Widget_' . str_replace( '-', '_', ucwords( $slug, '-' ) );
			$class_file = $directory . '/class-widget-' . $slug . '.php';
			if ( ! is_readable( $class_file ) ) {
				$candidates = glob( $directory . '/class-widget-*.php' );
				$class_file = ! empty( $candidates ) ? $candidates[0] : '';
			}

			if ( '' !== $class_file && is_readable( $class_file ) ) {
				require_once $class_file;
			}

			if ( class_exists( $class_name ) && is_callable( array( $class_name, 'registers' ) ) ) {
				call_user_func( array( $class_name, 'registers' ) );
			}

			$this->widgets[ $slug ] = array(
				'slug'        => $slug,
				'title'       => isset( $meta['title'] ) ? (string) $meta['title'] : ucwords( str_replace( '-', ' ', $slug ) ),
				'description' => isset( $meta['description'] ) ? (string) $meta['description'] : '',
				'version'     => isset( $meta['version'] ) ? (string) $meta['version'] : JSN_THEME_VERSION,
				'defaults'    => isset( $meta['defaults'] ) && is_array( $meta['defaults'] ) ? $meta['defaults'] : array(),
				'path'        => $directory,
				'uri'         => JSN_THEME_URI . '/widgets/' . $slug,
			);
		}
	}

	/**
	 * Lista os widgets descobertos.
	 *
	 * @return array<string, array<string, mixed>>
	 */
	public function get_widgets() {
		$this->discover();

		return $this->widgets;
	}

	/**
	 * Retorna os dados de um widget.
	 *
	 * @param string $slug Slug.
	 * @return array<string, mixed>|null
	 */
	public function get_widget( $slug ) {
		$this->discover();
		$slug = sanitize_key( $slug );

		return isset( $this->widgets[ $slug ] ) ? $this->widgets[ $slug ] : null;
	}

	/**
	 * Verifica se o widget está habilitado.
	 *
	 * @param string $slug Slug.
	 * @return bool
	 */
	public function is_enabled( $slug ) {
		return (bool) apply_filters( 'jsn_widget_is_enabled', true, $slug );
	}

	/**
	 * Enfileira os assets de um widget.
	 *
	 * @param string $slug Slug.
	 * @return void
	 */
	public function enqueue_assets( $slug ) {
		$widget = $this->get_widget( $slug );

		if ( ! $widget || isset( $this->enqueued[ $slug ] ) ) {
			return;
		}

		$style_file  = $widget['path'] . '/assets/style.css';
		$script_file = $widget['path'] . '/assets/script.js';

		if ( is_readable( $style_file ) ) {
			wp_enqueue_style(
				'jsn-widget-' . $slug,
				$widget['uri'] . '/assets/style.css',
				array(),
				$widget['version']
			);
		}

		if ( is_readable( $script_file ) ) {
			wp_enqueue_script(
				'jsn-widget-' . $slug,
				$widget['uri'] . '/assets/script.js',
				array(),
				$widget['version'],
				true
			);
		}

		$this->enqueued[ $slug ] = true;
	}

	/**
	 * Renderiza um widget pelo slug.
	 *
	 * @param string              $slug Slug.
	 * @param array<string,mixed> $atts Atributos.
	 * @return string
	 */
	public function render( $slug, $atts = array() ) {
		$slug = sanitize_key( $slug );
		$widget = $this->get_widget( $slug );

		if ( ! $widget || ! $this->is_enabled( $slug ) ) {
			return '';
		}

		$defaults = is_array( $widget['defaults'] ) ? $widget['defaults'] : array();
		$args     = shortcode_atts( $defaults, is_array( $atts ) ? $atts : array(), 'jsn_widget_' . $slug );
		$template = $widget['path'] . '/template.php';

		if ( ! is_readable( $template ) ) {
			return '';
		}

		$this->enqueue_assets( $slug );

		do_action( 'jsn_widget_before_render', $slug, $args );

		ob_start();
		include $template;
		$html = (string) ob_get_clean();

		do_action( 'jsn_widget_after_render', $slug, $args );

		return $html;
	}

	/**
	 * Callback do shortcode [jsn_widget id="hero"].
	 *
	 * @param array<string,mixed>|string $atts Atributos.
	 * @return string
	 */
	public function render_shortcode( $atts ) {
		$atts = (array) $atts;
		$slug = isset( $atts['id'] ) ? sanitize_key( $atts['id'] ) : '';
		unset( $atts['id'] );

		if ( '' === $slug ) {
			return '';
		}

		return $this->render( $slug, $atts );
	}

	/**
	 * Enfileira apenas os widgets presentes na página atual.
	 *
	 * @return void
	 */
	public function enqueue_for_current_post() {
		if ( is_admin() ) {
			return;
		}

		if ( is_page_template( 'templates/front-page.php' ) ) {
			foreach ( array_keys( $this->get_widgets() ) as $slug ) {
				$this->enqueue_assets( $slug );
			}
			return;
		}

		if ( ! is_singular() ) {
			return;
		}

		$content = (string) get_post_field( 'post_content', get_queried_object_id() );

		foreach ( array_keys( $this->get_widgets() ) as $slug ) {
			$pattern = '/\[jsn_widget[^\]]*id\s*=\s*["\']?' . preg_quote( $slug, '/' ) . '["\']?/';
			if ( preg_match( $pattern, $content ) ) {
				$this->enqueue_assets( $slug );
			}
		}
	}
}
