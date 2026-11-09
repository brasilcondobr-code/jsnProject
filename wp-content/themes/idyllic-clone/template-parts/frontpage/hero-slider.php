<?php
/**
 * Idyllic Clone — Hero slider (template self-contido, acessível, vanilla JS).
 *
 * @package JSN_Idyllic_Clone
 */

defined( 'ABSPATH' ) || exit;

$jsn_slides = jsn_idyllic_clone_get_slides();

if ( empty( $jsn_slides ) && ! get_theme_mod( 'jsn_idyllic_hero_autoplay', true ) ) {
	return;
}

if ( empty( $jsn_slides ) ) {
	return;
}
?>
<div class="main-slider" data-idyllic-slider data-idyllic-auto="<?php echo get_theme_mod( 'jsn_idyllic_hero_autoplay', true ) ? 'true' : 'false'; ?>" aria-roledescription="carousel" aria-label="<?php esc_attr_e( 'Destaques', 'jsn-idyllic-clone' ); ?>">
	<?php foreach ( $jsn_slides as $jsn_index => $jsn_slide ) : ?>
		<div class="jsn-idyllic-slide<?php echo 0 === $jsn_index ? ' is-active' : ''; ?>" style="background-image:url('<?php echo esc_url( $jsn_slide['image'] ? $jsn_slide['image'] : jsn_idyllic_clone_placeholder() ); ?>');" role="group" aria-roledescription="slide" aria-label="<?php echo esc_attr( sprintf( /* translators: %1$d: posição */ __( '%1$d de %2$d', 'jsn-idyllic-clone' ), $jsn_index + 1, count( $jsn_slides ) ) ); ?>">
			<article class="slider-content">
				<div class="slider-text-content">
					<?php if ( ! empty( $jsn_slide['subtitle'] ) ) : ?>
						<p class="slider-text"><?php echo esc_html( $jsn_slide['subtitle'] ); ?></p>
					<?php endif; ?>
					<?php if ( ! empty( $jsn_slide['title'] ) ) : ?>
						<h2 class="slider-title">
							<?php if ( ! empty( $jsn_slide['url'] ) ) : ?>
								<a href="<?php echo esc_url( $jsn_slide['url'] ); ?>"><?php echo esc_html( $jsn_slide['title'] ); ?></a>
							<?php else : ?>
								<?php echo esc_html( $jsn_slide['title'] ); ?>
							<?php endif; ?>
						</h2>
					<?php endif; ?>
				</div>
				<div class="slider-buttons">
					<?php if ( ! empty( $jsn_slide['url'] ) ) : ?>
						<a href="<?php echo esc_url( $jsn_slide['url'] ); ?>" class="btn-default jsn-idyllic-accent"><?php echo esc_html( $jsn_slide['button'] ? $jsn_slide['button'] : __( 'Saiba mais', 'jsn-idyllic-clone' ) ); ?></a>
					<?php endif; ?>
				</div>
			</article>
		</div>
	<?php endforeach; ?>

	<div class="slider-controls" role="tablist" aria-label="<?php esc_attr_e( 'Controles do slider', 'jsn-idyllic-clone' ); ?>">
		<?php foreach ( $jsn_slides as $jsn_index => $jsn_slide ) : ?>
			<button class="slider-control<?php echo 0 === $jsn_index ? ' is-active' : ''; ?>" type="button" data-slide="<?php echo esc_attr( $jsn_index ); ?>" role="tab">
				<span class="screen-reader-text"><?php echo esc_html( sprintf( /* translators: %d: número */ __( 'Ir ao slide %d', 'jsn-idyllic-clone' ), $jsn_index + 1 ) ); ?></span>
			</button>
		<?php endforeach; ?>
	</div>

	<button class="jsn-idyllic-prev" type="button" aria-label="<?php esc_attr_e( 'Slide anterior', 'jsn-idyllic-clone' ); ?>">
		<?php jsn_idyllic_clone_icon( 'chevron-left' ); ?>
	</button>
	<button class="jsn-idyllic-next" type="button" aria-label="<?php esc_attr_e( 'Próximo slide', 'jsn-idyllic-clone' ); ?>">
		<?php jsn_idyllic_clone_icon( 'chevron-right' ); ?>
	</button>
</div>
