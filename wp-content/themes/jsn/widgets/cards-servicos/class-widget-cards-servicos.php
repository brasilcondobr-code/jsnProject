<?php
/**
 * Widget Cards de Serviços.
 *
 * @package JSN
 */

defined( 'ABSPATH' ) || exit;

/**
 * Grade de serviços.
 */
final class JSN_Widget_Cards_Servicos {

	/**
	 * Slug do widget.
	 */
	public const SLUG = 'cards-servicos';

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
			'jsn/cards-servicos',
			array(
				'title'       => __( 'JSN — Cards de serviços', 'jsn' ),
				'description' => __( 'Grade de serviços com ícone, título e resumo.', 'jsn' ),
				'categories'  => array( 'jsn-widgets' ),
				'content'     => '<!-- wp:shortcode -->[jsn_widget id="cards-servicos"]<!-- /wp:shortcode -->',
			)
		);
	}
}
