<?php
/**
 * Idyllic Clone — Features (4 cards com cor primária).
 *
 * @package JSN_Idyllic_Clone
 */

defined( 'ABSPATH' ) || exit;

$jsn_title = jsn_idyllic_clone_get_setting( 'features_title', '' );
$jsn_items = jsn_idyllic_clone_get_features();

if ( empty( $jsn_items ) ) {
	return;
}
?>
<div class="jsn-idyllic-section our-feature-box our-feature-one clearfix">
	<div class="wrap">
		<div class="inner-wrap">
			<?php if ( '' !== $jsn_title ) : ?>
				<div class="box-header">
					<h2 class="box-title"><?php echo esc_html( $jsn_title ); ?></h2>
				</div>
			<?php endif; ?>
			<div class="column clearfix">
				<?php foreach ( $jsn_items as $jsn_i => $jsn_item ) : ?>
					<div class="four-column jsn-idyllic-animate" data-delay="<?php echo esc_attr( $jsn_i * 80 ); ?>">
						<div class="feature-content-wrap">
							<a class="feature-icon" href="<?php echo esc_url( $jsn_item['link'] ? $jsn_item['link'] : '#' ); ?>" aria-label="<?php echo esc_attr( $jsn_item['title'] ); ?>">
								<?php jsn_idyllic_clone_icon( $jsn_item['icon'] ? $jsn_item['icon'] : 'briefcase' ); ?>
							</a>
							<div class="feature-content">
								<article>
									<h3 class="feature-title">
										<a href="<?php echo esc_url( $jsn_item['link'] ? $jsn_item['link'] : '#' ); ?>"><?php echo esc_html( $jsn_item['title'] ); ?></a>
									</h3>
									<?php echo wp_kses_post( wpautop( $jsn_item['text'] ) ); ?>
									<a class="more-link" href="<?php echo esc_url( $jsn_item['link'] ? $jsn_item['link'] : '#' ); ?>"><?php esc_html_e( 'Saiba mais', 'jsn-idyllic-clone' ); ?></a>
								</article>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>
