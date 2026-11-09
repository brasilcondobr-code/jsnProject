<?php
/**
 * Template do widget Benefícios do condomínio.
 *
 * @package JSN
 *
 * @var array<string,mixed> $args   Atributos.
 * @var array<string,mixed> $widget Metadados.
 */

defined( 'ABSPATH' ) || exit;

$eyebrow = isset( $args['eyebrow'] ) ? $args['eyebrow'] : '';
$title   = isset( $args['title'] ) ? $args['title'] : '';
$text    = isset( $args['text'] ) ? $args['text'] : '';
$items   = isset( $args['items'] ) && is_array( $args['items'] ) ? $args['items'] : array();
?>
<section class="jsn-widget jsn-beneficios jsn-section" id="beneficios-condominio">
	<div class="jsn-container">
		<div class="jsn-section__head">
			<?php if ( '' !== $eyebrow ) : ?>
				<p class="jsn-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
			<?php endif; ?>
			<h2 class="jsn-section__title"><?php echo esc_html( $title ); ?></h2>
			<?php if ( '' !== $text ) : ?>
				<p class="jsn-section__text"><?php echo esc_html( $text ); ?></p>
			<?php endif; ?>
		</div>
		<div class="jsn-beneficios__grid">
			<?php foreach ( $items as $item ) : ?>
				<?php
				$item       = is_array( $item ) ? $item : array();
				$item_title = isset( $item['title'] ) ? $item['title'] : '';
				$item_text  = isset( $item['text'] ) ? $item['text'] : '';
				?>
				<article class="jsn-beneficio">
					<span class="jsn-beneficio__check" aria-hidden="true">✓</span>
					<div>
						<h3><?php echo esc_html( $item_title ); ?></h3>
						<p><?php echo esc_html( $item_text ); ?></p>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
