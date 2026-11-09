<?php
/**
 * Template do widget FAQ.
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
<section class="jsn-widget jsn-faq jsn-section" id="faq">
	<div class="jsn-container jsn-faq__inner">
		<div class="jsn-section__head">
			<?php if ( '' !== $eyebrow ) : ?>
				<p class="jsn-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
			<?php endif; ?>
			<h2 class="jsn-section__title"><?php echo esc_html( $title ); ?></h2>
			<?php if ( '' !== $text ) : ?>
				<p class="jsn-section__text"><?php echo esc_html( $text ); ?></p>
			<?php endif; ?>
		</div>
		<div class="jsn-faq__items">
			<?php foreach ( $items as $index => $item ) : ?>
				<?php
				$item     = is_array( $item ) ? $item : array();
				$question = isset( $item['question'] ) ? $item['question'] : '';
				$answer   = isset( $item['answer'] ) ? $item['answer'] : '';
				$open     = 0 === $index ? ' open' : '';
				?>
				<details class="jsn-faq__item"<?php echo esc_attr( $open ); ?>>
					<summary><?php echo esc_html( $question ); ?></summary>
					<p><?php echo esc_html( $answer ); ?></p>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>
