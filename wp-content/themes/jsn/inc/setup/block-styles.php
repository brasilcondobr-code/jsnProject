<?php
/**
 * Estilos de bloco do tema.
 *
 * @package JSN
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registra variações visuais simples para o editor.
 *
 * @return void
 */
function jsn_register_block_styles() {
	if ( ! function_exists( 'register_block_style' ) ) {
		return;
	}

	register_block_style(
		'core/button',
		array(
			'name'  => 'jsn-outline',
			'label' => __( 'JSN contorno', 'jsn' ),
		)
	);

	register_block_style(
		'core/group',
		array(
			'name'  => 'jsn-surface',
			'label' => __( 'JSN superfície', 'jsn' ),
		)
	);
}
