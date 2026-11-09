<?php
/**
 * Template do widget Hero.
 *
 * @package JSN
 *
 * @var array<string,mixed> $args   Atributos.
 * @var array<string,mixed> $widget Metadados.
 */

defined( 'ABSPATH' ) || exit;

$eyebrow         = isset( $args['eyebrow'] ) ? $args['eyebrow'] : '';
$title           = isset( $args['title'] ) ? $args['title'] : '';
$text            = isset( $args['text'] ) ? $args['text'] : '';
$primary_label   = isset( $args['primary_label'] ) ? $args['primary_label'] : '';
$primary_url     = isset( $args['primary_url'] ) ? $args['primary_url'] : '/contato/';
$secondary_label = isset( $args['secondary_label'] ) ? $args['secondary_label'] : '';
$secondary_url   = isset( $args['secondary_url'] ) ? $args['secondary_url'] : '/area-restrita/';
$metrics         = array(
	array(
		'value' => isset( $args['metric_1_value'] ) ? $args['metric_1_value'] : '',
		'label' => isset( $args['metric_1_label'] ) ? $args['metric_1_label'] : '',
	),
	array(
		'value' => isset( $args['metric_2_value'] ) ? $args['metric_2_value'] : '',
		'label' => isset( $args['metric_2_label'] ) ? $args['metric_2_label'] : '',
	),
	array(
		'value' => isset( $args['metric_3_value'] ) ? $args['metric_3_value'] : '',
		'label' => isset( $args['metric_3_label'] ) ? $args['metric_3_label'] : '',
	),
);
?>
<section class="jsn-widget jsn-hero" id="hero">
	<div class="jsn-container jsn-hero__inner">
		<div class="jsn-hero__content">
			<?php if ( '' !== $eyebrow ) : ?>
				<p class="jsn-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
			<?php endif; ?>
			<h1 class="jsn-hero__title"><?php echo esc_html( $title ); ?></h1>
			<?php if ( '' !== $text ) : ?>
				<p class="jsn-hero__text"><?php echo esc_html( $text ); ?></p>
			<?php endif; ?>
			<div class="jsn-hero__actions">
				<?php if ( '' !== $primary_label ) : ?>
					<a class="jsn-button jsn-button--primary" href="<?php echo esc_url( home_url( $primary_url ) ); ?>">
						<?php echo esc_html( $primary_label ); ?>
					</a>
				<?php endif; ?>
				<?php if ( '' !== $secondary_label ) : ?>
					<a class="jsn-button jsn-button--ghost" href="<?php echo esc_url( home_url( $secondary_url ) ); ?>">
						<?php echo esc_html( $secondary_label ); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>
		<div class="jsn-hero__panel" aria-hidden="true">
			<div class="jsn-hero__panel-head">
				<span class="jsn-hero__dot"></span>
				<span class="jsn-hero__panel-title"><?php esc_html_e( 'Painel do condomínio', 'jsn' ); ?></span>
			</div>
			<div class="jsn-hero__metrics">
				<?php foreach ( $metrics as $metric ) : ?>
					<div class="jsn-hero__metric">
						<strong><?php echo esc_html( $metric['value'] ); ?></strong>
						<span><?php echo esc_html( $metric['label'] ); ?></span>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="jsn-hero__bars">
				<span style="--jsn-bar: 82%"></span>
				<span style="--jsn-bar: 64%"></span>
				<span style="--jsn-bar: 91%"></span>
			</div>
		</div>
	</div>
</section>
