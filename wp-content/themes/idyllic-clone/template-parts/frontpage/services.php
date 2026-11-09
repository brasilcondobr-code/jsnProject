<?php
/**
 * Idyllic Clone — Serviços (4 cards clean).
 *
 * @package JSN_Idyllic_Clone
 */

defined( 'ABSPATH' ) || exit;

$jsn_title  = jsn_idyllic_clone_get_setting( 'services_title', __( 'Nossos serviços', 'jsn-idyllic-clone' ) );
$jsn_items  = jsn_idyllic_clone_get_services();

if ( empty( $jsn_items ) ) {
	return;
}
?>
<div class="jsn-idyllic-section jsn-idyllic-services clearfix">
	<div class="wrap">
		<div class="box-header">
			<h2 class="box-title"><?php echo esc_html( $jsn_title ); ?></h2>
			<p class="box-sub-title"><?php esc_html_e( 'Soluções pensadas para o seu dia a dia.', 'jsn-idyllic-clone' ); ?></p>
		</div>
		<div class="column clearfix">
			<?php foreach ( $jsn_items as $jsn_item ) : ?>
				<div class="four-column">
					<div class="feature-content-wrap">
						<div class="feature-icon">
							<?php jsn_idyllic_clone_icon( $jsn_item['icon'] ? $jsn_item['icon'] : 'briefcase' ); ?>
						</div>
						<div class="feature-content">
							<article>
								<h3 class="feature-title"><?php echo esc_html( $jsn_item['title'] ); ?></h3>
								<?php echo wp_kses_post( wpautop( $jsn_item['text'] ) ); ?>
							</article>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
