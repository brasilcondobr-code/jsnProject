<?php
/**
 * Idyllic Clone — carregamento de assets.
 *
 * @package JSN_Idyllic_Clone
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'jsn_idyllic_clone_enqueue_assets' ) ) {
	/**
	 * Enfileira CSS/JS com cache busting por versão.
	 *
	 * @return void
	 */
	function jsn_idyllic_clone_enqueue_assets() {
		wp_enqueue_style(
			'jsn-idyllic-clone-style',
			get_stylesheet_uri(),
			array(),
			JSN_IDYLLIC_CLONE_VERSION
		);

		wp_enqueue_style(
			'jsn-idyllic-clone-main',
			JSN_IDYLLIC_CLONE_URI . '/assets/css/main.css',
			array( 'jsn-idyllic-clone-style' ),
			JSN_IDYLLIC_CLONE_VERSION
		);

		wp_enqueue_style(
			'jsn-idyllic-clone-responsive',
			JSN_IDYLLIC_CLONE_URI . '/assets/css/responsive.css',
			array( 'jsn-idyllic-clone-main' ),
			JSN_IDYLLIC_CLONE_VERSION
		);

		// Google Fonts com preconnect + display=swap.
		wp_enqueue_style(
			'jsn-idyllic-clone-fonts',
			'https://fonts.googleapis.com/css2?family=Arimo:wght@400;600&family=Lustria&display=swap',
			array(),
			JSN_IDYLLIC_CLONE_VERSION
		);

		wp_enqueue_script(
			'jsn-idyllic-clone-main',
			JSN_IDYLLIC_CLONE_URI . '/assets/js/main.js',
			array(),
			JSN_IDYLLIC_CLONE_VERSION,
			true
		);

		if ( is_front_page() ) {
			wp_enqueue_script(
				'jsn-idyllic-clone-slider',
				JSN_IDYLLIC_CLONE_URI . '/assets/js/slider.js',
				array( 'jsn-idyllic-clone-main' ),
				JSN_IDYLLIC_CLONE_VERSION,
				true
			);
		}
	}
}
add_action( 'wp_enqueue_scripts', 'jsn_idyllic_clone_enqueue_assets' );

if ( ! function_exists( 'jsn_idyllic_clone_preconnect_fonts' ) ) {
	/**
	 * Preconnect para o Google Fonts (performance).
	 *
	 * @param string $tag  Tag do link.
	 * @param string $handle Handle.
	 * @return string
	 */
	function jsn_idyllic_clone_preconnect_fonts( $tag, $handle ) {
		if ( 'jsn-idyllic-clone-fonts' === $handle ) {
			$tag = sprintf( '<link rel="preconnect" href="https://fonts.googleapis.com" />%s<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />%s', PHP_EOL, PHP_EOL ) . $tag;
		}

		return $tag;
	}
}
add_filter( 'style_loader_tag', 'jsn_idyllic_clone_preconnect_fonts', 10, 2 );
