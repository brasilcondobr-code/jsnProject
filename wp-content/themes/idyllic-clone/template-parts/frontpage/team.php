<?php
/**
 * Idyllic Clone — Equipe (grid de membros).
 *
 * @package JSN_Idyllic_Clone
 */

defined( 'ABSPATH' ) || exit;

$jsn_title = jsn_idyllic_clone_get_setting( 'team_title', __( 'Nossa equipe', 'jsn-idyllic-clone' ) );
$jsn_items = jsn_idyllic_clone_get_team();

if ( empty( $jsn_items ) ) {
	return;
}
?>
<div class="jsn-idyllic-section team-member-box clearfix">
	<div class="wrap">
		<div class="box-header">
			<h2 class="box-title jsn-idyllic-animate"><?php echo esc_html( $jsn_title ); ?></h2>
			<?php $jsn_team_sub = jsn_idyllic_clone_get_setting( 'team_sub', '' ); ?>
			<?php if ( '' !== $jsn_team_sub ) : ?>
				<p class="box-sub-title jsn-idyllic-animate" data-delay="120"><?php echo esc_html( $jsn_team_sub ); ?></p>
			<?php endif; ?>
		</div>
		<div class="column clearfix">
			<?php foreach ( $jsn_items as $jsn_item ) : ?>
				<div class="four-column">
					<div class="jsn-idyllic-team-member">
						<?php if ( ! empty( $jsn_item['image'] ) ) : ?>
							<img src="<?php echo esc_url( $jsn_item['image'] ); ?>" alt="<?php echo esc_attr( $jsn_item['name'] ); ?>" loading="lazy" width="420" height="520">
						<?php else : ?>
							<img src="<?php echo esc_url( jsn_idyllic_clone_placeholder() ); ?>" alt="<?php echo esc_attr( $jsn_item['name'] ); ?>" loading="lazy" width="420" height="520">
						<?php endif; ?>
						<h3 class="jsn-idyllic-team-name"><?php echo esc_html( $jsn_item['name'] ); ?></h3>
						<p class="jsn-idyllic-team-role"><?php echo esc_html( $jsn_item['role'] ); ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
