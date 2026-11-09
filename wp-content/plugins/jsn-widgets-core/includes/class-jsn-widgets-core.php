<?php
/**
 * Núcleo do plugin JSN Widgets Core.
 *
 * @package JSN_Widgets_Core
 */

defined( 'ABSPATH' ) || exit;

require_once JSN_WIDGETS_CORE_DIR . 'includes/class-jsn-cpt.php';
require_once JSN_WIDGETS_CORE_DIR . 'includes/class-jsn-rest.php';

/**
 * Orquestra a camada de dados e integração com o tema.
 */
final class JSN_Widgets_Core {

	/**
	 * Instância única.
	 *
	 * @var JSN_Widgets_Core|null
	 */
	private static $instance = null;

	/**
	 * Retorna a instância única.
	 *
	 * @return JSN_Widgets_Core
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
		add_action( 'init', array( $this, 'register_content_types' ), 5 );
		add_action( 'init', array( $this, 'register_patterns' ), 20 );
		add_action( 'rest_api_init', array( $this, 'register_rest' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_filter( 'jsn_widget_is_enabled', array( $this, 'filter_enabled' ), 10, 2 );
	}

	/**
	 * Ativação do plugin.
	 *
	 * @return void
	 */
	public static function activate() {
		$cpt = new JSN_CPT();
		$cpt->register();
		flush_rewrite_rules();
	}

	/**
	 * Desativação do plugin.
	 *
	 * @return void
	 */
	public static function deactivate() {
		flush_rewrite_rules();
	}

	/**
	 * Registra CPTs e taxonomias.
	 *
	 * @return void
	 */
	public function register_content_types() {
		$cpt = new JSN_CPT();
		$cpt->register();
	}

	/**
	 * Registra os endpoints REST do plugin.
	 *
	 * @return void
	 */
	public function register_rest() {
		JSN_Widgets_Core_REST::register_routes();
	}

	/**
	 * Padrões Gutenberg de páginas institucionais.
	 *
	 * @return void
	 */
	public function register_patterns() {
		if ( ! function_exists( 'register_block_pattern' ) ) {
			return;
		}

		if ( function_exists( 'register_block_pattern_category' ) ) {
			register_block_pattern_category(
				'jsn-pages',
				array( 'label' => __( 'JSN — Páginas', 'jsn-widgets-core' ) )
			);
		}

		register_block_pattern(
			'jsn/pagina-institucional',
			array(
				'title'       => __( 'JSN — Página institucional', 'jsn-widgets-core' ),
				'description' => __( 'Composição inicial com hero, serviços, benefícios, FAQ e contato.', 'jsn-widgets-core' ),
				'categories'  => array( 'jsn-pages' ),
				'content'     => implode(
					"\n",
					array(
						'<!-- wp:shortcode -->[jsn_widget id="hero"]<!-- /wp:shortcode -->',
						'<!-- wp:shortcode -->[jsn_widget id="cards-servicos"]<!-- /wp:shortcode -->',
						'<!-- wp:shortcode -->[jsn_widget id="beneficios-condominio"]<!-- /wp:shortcode -->',
						'<!-- wp:shortcode -->[jsn_widget id="faq"]<!-- /wp:shortcode -->',
						'<!-- wp:shortcode -->[jsn_widget id="cta-contato"]<!-- /wp:shortcode -->',
					)
				),
			)
		);
	}

	/**
	 * Central de bloqueio/desbloqueio de widgets.
	 *
	 * @return void
	 */
	public function admin_menu() {
		add_options_page(
			__( 'JSN Widgets', 'jsn-widgets-core' ),
			__( 'JSN Widgets', 'jsn-widgets-core' ),
			'manage_options',
			'jsn-widgets',
			array( $this, 'render_settings_page' )
		);
	}

	/**
	 * Registra a opção de widgets bloqueados.
	 *
	 * @return void
	 */
	public function register_settings() {
		register_setting(
			'jsn_widgets',
			'jsn_widgets_disabled',
			array(
				'type'              => 'array',
				'default'           => array(),
				'sanitize_callback' => array( $this, 'sanitize_disabled' ),
			)
		);
	}

	/**
	 * Sanitiza a lista de widgets bloqueados.
	 *
	 * @param mixed $value Valor recebido.
	 * @return array<int,string>
	 */
	public function sanitize_disabled( $value ) {
		if ( ! is_array( $value ) ) {
			return array();
		}

		return array_values( array_filter( array_map( 'sanitize_key', $value ) ) );
	}

	/**
	 * Renderiza a tela de administração.
	 *
	 * @return void
	 */
	public function render_settings_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$widgets  = $this->get_widget_index();
		$disabled = (array) get_option( 'jsn_widgets_disabled', array() );
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'JSN Widgets', 'jsn-widgets-core' ); ?></h1>
			<p><?php esc_html_e( 'Bloqueie ou libere widgets independentes do tema. Widgets bloqueados deixam de renderizar no front-end.', 'jsn-widgets-core' ); ?></p>

			<?php if ( empty( $widgets ) ) : ?>
				<p><?php esc_html_e( 'Nenhum widget descoberto. Verifique se o tema JSN está ativo.', 'jsn-widgets-core' ); ?></p>
			<?php else : ?>
				<form method="post" action="options.php">
					<?php settings_fields( 'jsn_widgets' ); ?>
					<table class="widefat striped">
						<thead>
							<tr>
								<th scope="col"><?php esc_html_e( 'Widget', 'jsn-widgets-core' ); ?></th>
								<th scope="col"><?php esc_html_e( 'Shortcode', 'jsn-widgets-core' ); ?></th>
								<th scope="col"><?php esc_html_e( 'Status', 'jsn-widgets-core' ); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ( $widgets as $widget ) : ?>
								<tr>
									<td>
										<strong><?php echo esc_html( $widget['title'] ); ?></strong><br>
										<code><?php echo esc_html( $widget['slug'] ); ?></code>
									</td>
									<td><code>[jsn_widget id="<?php echo esc_html( $widget['slug'] ); ?>"]</code></td>
									<td>
										<label>
											<input
												type="checkbox"
												name="jsn_widgets_disabled[]"
												value="<?php echo esc_attr( $widget['slug'] ); ?>"
												<?php checked( in_array( $widget['slug'], $disabled, true ) ); ?>
											>
											<?php esc_html_e( 'Bloqueado', 'jsn-widgets-core' ); ?>
										</label>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
					<?php submit_button( __( 'Salvar widgets', 'jsn-widgets-core' ) ); ?>
				</form>
			<?php endif; ?>
		</div>
		<?php
	}

	/**
	 * Índice global de widgets do tema.
	 *
	 * @return array<int,array<string,mixed>>
	 */
	public function get_widget_index() {
		if ( ! class_exists( 'JSN_Widget_Registry' ) ) {
			return array();
		}

		$widgets = JSN_Widget_Registry::instance()->get_widgets();
		$index   = array();

		foreach ( $widgets as $widget ) {
			$index[] = array(
				'slug'        => $widget['slug'],
				'title'       => $widget['title'],
				'description' => $widget['description'],
				'version'     => $widget['version'],
				'defaults'    => $widget['defaults'],
			);
		}

		return $index;
	}

	/**
	 * Aplica o bloqueio configurado no admin.
	 *
	 * @param bool   $enabled Habilitado pelo tema.
	 * @param string $slug    Slug.
	 * @return bool
	 */
	public function filter_enabled( $enabled, $slug ) {
		$disabled = (array) get_option( 'jsn_widgets_disabled', array() );

		if ( in_array( $slug, $disabled, true ) ) {
			return false;
		}

		return (bool) $enabled;
	}
}
