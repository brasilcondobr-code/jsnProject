<?php
/**
 * Idyllic Clone — página inicial com as seções do layout.
 *
 * Ordem do demo de referência: features, about, testimonials, blog, team.
 * (services, cta e stats existem como seções opcionais, desativadas por padrão.)
 * Cada seção pode ser ativada/desativada via Customizer.
 *
 * @package JSN_Idyllic_Clone
 */

defined( 'ABSPATH' ) || exit;

get_header();

$jsn_idyllic_sections = array(
	'features'     => 'template-parts/frontpage/features',
	'about'        => 'template-parts/frontpage/about',
	'testimonials' => 'template-parts/frontpage/testimonials',
	'blog'         => 'template-parts/frontpage/blog',
	'team'         => 'template-parts/frontpage/team',
	'services'     => 'template-parts/frontpage/services',
	'cta'          => 'template-parts/frontpage/cta',
	'stats'        => 'template-parts/frontpage/stats',
);

/**
 * Filtro permite reordenar/adicionar seções.
 *
 * @param array<string,string> $sections Mapa slug => part.
 */
$jsn_idyllic_sections = apply_filters( 'jsn_idyllic_clone_front_page_sections', $jsn_idyllic_sections );

foreach ( $jsn_idyllic_sections as $jsn_idyllic_key => $jsn_idyllic_part ) {
	if ( jsn_idyllic_clone_is_active( $jsn_idyllic_key ) ) {
		get_template_part( $jsn_idyllic_part );
	}
}

get_footer();
