<?php
/**
 * Bloco reutilizável do dashboard restrito.
 *
 * @package JSN
 */

defined( 'ABSPATH' ) || exit;

$jsn_user       = wp_get_current_user();
$jsn_role_names = wp_roles()->get_names();
$jsn_roles      = array();

foreach ( (array) $jsn_user->roles as $jsn_role ) {
	$jsn_roles[] = isset( $jsn_role_names[ $jsn_role ] ) ? translate_user_role( $jsn_role_names[ $jsn_role ] ) : $jsn_role;
}

$jsn_cards = array(
	array(
		'title' => __( 'Boletos e financeiro', 'jsn' ),
		'text'  => __( 'Segunda via, histórico e comprovantes em um só lugar.', 'jsn' ),
	),
	array(
		'title' => __( 'Assembleias', 'jsn' ),
		'text'  => __( 'Convocações, pautas, atas e deliberações.', 'jsn' ),
	),
	array(
		'title' => __( 'Comunicados', 'jsn' ),
		'text'  => __( 'Avisos oficiais e comunicados do condomínio.', 'jsn' ),
	),
	array(
		'title' => __( 'Ocorrências', 'jsn' ),
		'text'  => __( 'Registro e acompanhamento de solicitações.', 'jsn' ),
	),
);
?>
<section class="jsn-section jsn-dashboard">
	<div class="jsn-container">
		<div class="jsn-dashboard__head">
			<div>
				<p class="jsn-eyebrow"><?php esc_html_e( 'Dashboard Condomínio', 'jsn' ); ?></p>
				<h2><?php echo esc_html( sprintf( __( 'Olá, %s', 'jsn' ), $jsn_user->display_name ) ); ?></h2>
				<p><?php esc_html_e( 'Este é o ponto de partida do portal restrito. Os módulos serão acoplados via hooks nas próximas fases.', 'jsn' ); ?></p>
			</div>
			<?php if ( ! empty( $jsn_roles ) ) : ?>
				<div class="jsn-dashboard__roles">
					<span><?php esc_html_e( 'Perfil', 'jsn' ); ?></span>
					<strong><?php echo esc_html( implode( ', ', $jsn_roles ) ); ?></strong>
				</div>
			<?php endif; ?>
		</div>

		<?php do_action( 'jsn_before_dashboard' ); ?>

		<div class="jsn-dashboard__grid">
			<?php foreach ( $jsn_cards as $jsn_card ) : ?>
				<article class="jsn-dashboard__card">
					<span class="jsn-dashboard__badge"><?php esc_html_e( 'Fase 2', 'jsn' ); ?></span>
					<h3><?php echo esc_html( $jsn_card['title'] ); ?></h3>
					<p><?php echo esc_html( $jsn_card['text'] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
