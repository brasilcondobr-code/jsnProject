<?php
/**
 * Template do widget CTA de contato.
 *
 * @package JSN
 *
 * @var array<string,mixed> $args   Atributos.
 * @var array<string,mixed> $widget Metadados.
 */

defined( 'ABSPATH' ) || exit;

$eyebrow      = isset( $args['eyebrow'] ) ? $args['eyebrow'] : '';
$title        = isset( $args['title'] ) ? $args['title'] : '';
$text         = isset( $args['text'] ) ? $args['text'] : '';
$email        = isset( $args['email'] ) ? $args['email'] : '';
$phone        = isset( $args['phone'] ) ? $args['phone'] : '';
$phone_url    = isset( $args['phone_url'] ) ? $args['phone_url'] : '';
$button_label = isset( $args['button_label'] ) ? $args['button_label'] : '';
$button_url   = isset( $args['button_url'] ) ? $args['button_url'] : '';
?>
<section class="jsn-widget jsn-cta jsn-section" id="cta-contato">
	<div class="jsn-container">
		<div class="jsn-cta__box">
			<div class="jsn-cta__content">
				<?php if ( '' !== $eyebrow ) : ?>
					<p class="jsn-eyebrow jsn-eyebrow--light"><?php echo esc_html( $eyebrow ); ?></p>
				<?php endif; ?>
				<h2><?php echo esc_html( $title ); ?></h2>
				<?php if ( '' !== $text ) : ?>
					<p><?php echo esc_html( $text ); ?></p>
				<?php endif; ?>
			</div>
			<div class="jsn-cta__actions">
				<?php if ( '' !== $button_label ) : ?>
					<a class="jsn-button jsn-button--primary" href="<?php echo esc_url( $button_url ); ?>">
						<?php echo esc_html( $button_label ); ?>
					</a>
				<?php endif; ?>
				<div class="jsn-cta__contacts">
					<?php if ( '' !== $email ) : ?>
						<a href="<?php echo esc_url( 'mailto:' . $email ); ?>"><?php echo esc_html( $email ); ?></a>
					<?php endif; ?>
					<?php if ( '' !== $phone ) : ?>
						<a href="<?php echo esc_url( $phone_url ); ?>"><?php echo esc_html( $phone ); ?></a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
