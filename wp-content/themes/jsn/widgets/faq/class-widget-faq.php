<?php
/**
 * Widget FAQ.
 *
 * @package JSN
 */

defined( 'ABSPATH' ) || exit;

/**
 * Perguntas frequentes.
 */
final class JSN_Widget_Faq {

	/**
	 * Slug do widget.
	 */
	public const SLUG = 'faq';

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
			'jsn/faq',
			array(
				'title'       => __( 'JSN — FAQ', 'jsn' ),
				'description' => __( 'Perguntas frequentes em acordeão nativo.', 'jsn' ),
				'categories'  => array( 'jsn-widgets' ),
				'content'     => '<!-- wp:shortcode -->[jsn_widget id="faq"]<!-- /wp:shortcode -->',
			)
		);
	}
}
