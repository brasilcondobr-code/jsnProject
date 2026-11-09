<?php
/**
 * Template do widget Cards de Serviços.
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
<section class="jsn-widget jsn-cards-servicos jsn-section" id="cards-servicos">
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
		<div class="jsn-cards">
			<?php foreach ( $items as $item ) : ?>
				<?php
				$item       = is_array( $item ) ? $item : array();
				$item_title = isset( $item['title'] ) ? $item['title'] : '';
				$item_text  = isset( $item['text'] ) ? $item['text'] : '';
				$item_url   = isset( $item['url'] ) ? $item['url'] : '/servicos/';
				$item_icon  = isset( $item['icon'] ) ? $item['icon'] : '';
				?>
				<article class="jsn-card">
					<?php if ( '' !== $item_icon ) : ?>
						<span class="jsn-card__icon"><?php echo esc_html( $item_icon ); ?></span>
					<?php endif; ?>
					<h3 class="jsn-card__title"><?php echo esc_html( $item_title ); ?></h3>
					<p class="jsn-card__text"><?php echo esc_html( $item_text ); ?></p>
					<a class="jsn-card__link" href="<?php echo esc_url( home_url( $item_url ) ); ?>">
						<?php esc_html_e( 'Saiba mais', 'jsn' ); ?>
						<span aria-hidden="true">→</span>
					</a>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
