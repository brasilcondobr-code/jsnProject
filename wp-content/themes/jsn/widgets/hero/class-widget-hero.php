<?php
/**
 * Widget Hero.
 *
 * @package JSN
 */

defined( 'ABSPATH' ) || exit;

/**
 * Hero institucional.
 */
final class JSN_Widget_Hero {

	/**
	 * Slug do widget.
	 */
	public const SLUG = 'hero';

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
			'jsn/hero',
			array(
				'title'       => __( 'JSN — Hero', 'jsn' ),
				'description' => __( 'Bloco de abertura com chamada principal e métricas.', 'jsn' ),
				'categories'  => array( 'jsn-widgets' ),
				'content'     => '<!-- wp:shortcode -->[jsn_widget id="hero"]<!-- /wp:shortcode -->',
			)
		);
	}
}
