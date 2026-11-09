<?php
/**
 * Widget CTA de contato.
 *
 * @package JSN
 */

defined( 'ABSPATH' ) || exit;

/**
 * Chamada final para contato.
 */
final class JSN_Widget_Cta_Contato {

	/**
	 * Slug do widget.
	 */
	public const SLUG = 'cta-contato';

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
			'jsn/cta-contato',
			array(
				'title'       => __( 'JSN — CTA de contato', 'jsn' ),
				'description' => __( 'Chamada final com e-mail, telefone e botão de contato.', 'jsn' ),
				'categories'  => array( 'jsn-widgets' ),
				'content'     => '<!-- wp:shortcode -->[jsn_widget id="cta-contato"]<!-- /wp:shortcode -->',
			)
		);
	}
}
