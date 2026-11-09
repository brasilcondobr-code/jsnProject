<?php
/**
 * Idyllic Clone — Depoimentos (slider com parallax).
 *
 * @package JSN_Idyllic_Clone
 */

defined( 'ABSPATH' ) || exit;

$jsn_title = jsn_idyllic_clone_get_setting( 'testimonials_title', '' );
$jsn_bg    = get_theme_mod( 'jsn_idyllic_testimonials_bg', '' );
$jsn_items = jsn_idyllic_clone_get_testimonials();

if ( empty( $jsn_items ) ) {
	return;
}
?>
<div class="jsn-idyllic-section testimonial-box">
	<div class="testimonial-bg" style="background-image:url('<?php echo esc_url( $jsn_bg ? $jsn_bg : jsn_idyllic_clone_placeholder() ); ?>');">
		<div class="wrap">
			<div class="inner-wrap">
				<?php if ( '' !== $jsn_title ) : ?>
					<div class="box-header">
						<h2 class="box-title"><?php echo esc_html( $jsn_title ); ?></h2>
					</div>
				<?php endif; ?>

				<div class="jsn-idyllic-testimonial" data-idyllic-slider aria-roledescription="carousel" aria-label="<?php esc_attr_e( 'Depoimentos', 'jsn-idyllic-clone' ); ?>">
				<?php foreach ( $jsn_items as $jsn_i => $jsn_item ) : ?>
					<figure class="jsn-idyllic-testimonial-slide<?php echo 0 === $jsn_i ? ' is-active' : ''; ?>">
						<?php if ( ! empty( $jsn_item['image'] ) ) : ?>
							<img class="jsn-idyllic-testimonial-avatar" src="<?php echo esc_url( $jsn_item['image'] ); ?>" alt="<?php echo esc_attr( $jsn_item['author'] ); ?>" loading="lazy" width="240" height="240">
						<?php endif; ?>
						<blockquote class="jsn-idyllic-testimonial-quote">
							<?php if ( ! empty( $jsn_item['title'] ) ) : ?>
								<h2><?php echo esc_html( $jsn_item['title'] ); ?></h2>
							<?php endif; ?>
							<p><?php echo esc_html( $jsn_item['quote'] ); ?></p>
							<cite><?php echo esc_html( $jsn_item['author'] ); ?></cite>
						</blockquote>
					</figure>
				<?php endforeach; ?>

				<div class="testimonial-controls">
					<?php foreach ( $jsn_items as $jsn_i => $jsn_item ) : ?>
						<button class="slider-control<?php echo 0 === $jsn_i ? ' is-active' : ''; ?>" type="button" data-slide="<?php echo esc_attr( $jsn_i ); ?>">
							<span class="screen-reader-text"><?php echo esc_html( sprintf( /* translators: %d: número */ __( 'Depoimento %d', 'jsn-idyllic-clone' ), $jsn_i + 1 ) ); ?></span>
						</button>
					<?php endforeach; ?>
				</div><!-- .testimonial-controls -->
				<button class="jsn-idyllic-prev" type="button" aria-label="<?php esc_attr_e( 'Depoimento anterior', 'jsn-idyllic-clone' ); ?>">
					<?php jsn_idyllic_clone_icon( 'chevron-left' ); ?>
				</button>
				<button class="jsn-idyllic-next" type="button" aria-label="<?php esc_attr_e( 'Próximo depoimento', 'jsn-idyllic-clone' ); ?>">
					<?php jsn_idyllic_clone_icon( 'chevron-right' ); ?>
				</button>
				</div><!-- .jsn-idyllic-testimonial -->
			</div><!-- .inner-wrap -->
		</div><!-- .wrap -->
	</div><!-- .testimonial-bg -->
</div><!-- .testimonial-box -->
