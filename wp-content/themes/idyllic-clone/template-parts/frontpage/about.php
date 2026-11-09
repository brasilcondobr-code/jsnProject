<?php
/**
 * Idyllic Clone — About (box-header + 2 colunas float right: texto e imagem).
 *
 * Ordem do demo de referência: box-header centralizado, coluna de texto
 * à direita e coluna de imagem à esquerda.
 *
 * @package JSN_Idyllic_Clone
 */

defined( 'ABSPATH' ) || exit;

$jsn_about = jsn_idyllic_clone_get_about_data();
$jsn_items = array_filter( preg_split( '/\r\n|\r|\n/', (string) $jsn_about['items'] ) );
?>
<div class="jsn-idyllic-section about-box clearfix">
	<div class="about-box-bg">
		<div class="wrap">
			<div class="box-header">
				<h2 class="box-title jsn-idyllic-animate"><?php echo esc_html( $jsn_about['title'] ); ?></h2>
				<?php if ( '' !== (string) $jsn_about['sub'] ) : ?>
					<p class="box-sub-title jsn-idyllic-animate" data-delay="120"><?php echo esc_html( $jsn_about['sub'] ); ?></p>
				<?php endif; ?>
			</div>
			<div class="column clearfix">
				<div class="two-column jsn-idyllic-animate" data-delay="0">
					<div class="about-content-wrap">
						<article>
							<h2 class="about-title">
								<?php if ( '' !== (string) $jsn_about['link'] ) : ?>
									<a href="<?php echo esc_url( $jsn_about['link'] ); ?>"><?php echo esc_html( $jsn_about['heading'] ); ?></a>
								<?php else : ?>
									<?php echo esc_html( $jsn_about['heading'] ); ?>
								<?php endif; ?>
							</h2>

							<?php echo wp_kses_post( wpautop( $jsn_about['content'] ) ); ?>

							<?php if ( ! empty( $jsn_items ) ) : ?>
								<ul class="about-items">
									<?php foreach ( $jsn_items as $jsn_line ) : ?>
										<li><?php echo esc_html( trim( $jsn_line ) ); ?></li>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>

							<?php if ( '' !== (string) $jsn_about['button'] && '' !== (string) $jsn_about['link'] ) : ?>
								<a class="btn-default" href="<?php echo esc_url( $jsn_about['link'] ); ?>"><?php echo esc_html( $jsn_about['button'] ); ?></a>
							<?php endif; ?>
						</article>
					</div>
				</div>
				<div class="two-column jsn-idyllic-animate" data-delay="180">
					<div class="about-image">
						<img src="<?php echo esc_url( $jsn_about['image'] ? $jsn_about['image'] : jsn_idyllic_clone_placeholder() ); ?>" alt="<?php echo esc_attr( $jsn_about['heading'] ); ?>" loading="lazy" width="768" height="512">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
