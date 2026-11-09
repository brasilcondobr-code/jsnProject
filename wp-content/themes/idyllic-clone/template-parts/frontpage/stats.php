<?php
/**
 * Idyllic Clone — Stats (contadores animados).
 *
 * @package JSN_Idyllic_Clone
 */

defined( 'ABSPATH' ) || exit;

$jsn_items = jsn_idyllic_clone_get_stats();

if ( empty( $jsn_items ) ) {
	return;
}
?>
<div class="jsn-idyllic-section fact-figure-box">
	<div class="wrap">
		<div class="inner-wrap clearfix">
			<?php foreach ( $jsn_items as $jsn_i => $jsn_item ) : ?>
				<div class="four-column fact-divider<?php echo 0 === $jsn_i ? '' : ''; ?>">
					<div class="facts-content-wrap">
						<span class="jsn-idyllic-counter" data-target="<?php echo esc_attr( max( 0, absint( $jsn_item['number'] ) ) ); ?>">0</span>
						<span class="jsn-idyllic-counter-label"><?php echo esc_html( $jsn_item['label'] ); ?></span>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
