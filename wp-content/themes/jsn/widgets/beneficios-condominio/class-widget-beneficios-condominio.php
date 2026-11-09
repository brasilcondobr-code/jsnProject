<?php
/**
 * Widget Benefícios do condomínio.
 *
 * @package JSN
 */

defined( 'ABSPATH' ) || exit;

/**
 * Lista de benefícios.
 */
final class JSN_Widget_Beneficios_Condominio {

	/**
	 * Slug do widget.
	 */
	public const SLUG = 'beneficios-condominio';

	/**
	 * Registra o padrão Gutenberg do widget.
	 *
	 * @return void
	 */
	public static function registers() {
		if ( ! function_exists( 'register_block_pattern' ) ) {
			return;
		}

		register_block_pattern(
			'jsn/beneficios-condominio',
			array(
				'title'       => __( 'JSN — Benefícios do condomínio', 'jsn' ),
				'description' => __( 'Lista de benefícios com marcadores e texto de apoio.', 'jsn' ),
				'categories'  => array( 'jsn-widgets' ),
				'content'     => '<!-- wp:shortcode -->[jsn_widget id="beneficios-condominio"]<!-- /wp:shortcode -->',
			)
		);
	}
}
