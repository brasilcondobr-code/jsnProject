<?php
/**
 * Idyllic Clone — Blog (últimos posts reais do WordPress).
 *
 * @package JSN_Idyllic_Clone
 */

defined( 'ABSPATH' ) || exit;

$jsn_title = jsn_idyllic_clone_get_setting( 'blog_title', __( 'Últimas notícias', 'jsn-idyllic-clone' ) );
$jsn_count = max( 1, absint( jsn_idyllic_clone_get_setting( 'blog_count', 6 ) ) );

$jsn_query = new WP_Query( array(
	'post_type'              => 'post',
	'post_status'            => 'publish',
	'posts_per_page'         => $jsn_count,
	'ignore_sticky_posts'    => true,
	'no_found_rows'          => true,
) );

if ( ! $jsn_query->have_posts() ) {
	return;
}
?>
<div class="jsn-idyllic-section latest-blog-box clearfix">
	<div class="wrap">
		<div class="inner-wrap">
			<div class="box-header">
				<h2 class="box-title jsn-idyllic-animate"><?php echo esc_html( $jsn_title ); ?></h2>
				<?php $jsn_blog_sub = jsn_idyllic_clone_get_setting( 'blog_sub', '' ); ?>
				<?php if ( '' !== $jsn_blog_sub ) : ?>
					<p class="box-sub-title jsn-idyllic-animate" data-delay="120"><?php echo esc_html( $jsn_blog_sub ); ?></p>
				<?php endif; ?>
			</div>

			<div class="column clearfix">
				<?php
				while ( $jsn_query->have_posts() ) :
					$jsn_query->the_post();
					?>
					<div class="two-column">
						<div class="latest-blog-content">
							<article <?php post_class( 'jsn-idyllic-post-card' ); ?>>
								<div class="latest-blog-image">
									<figure class="post-featured-image">
										<a href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
											<?php
											if ( has_post_thumbnail() ) {
												the_post_thumbnail( 'jsn-idyllic-clone-card', array( 'loading' => 'lazy' ) );
											} else {
												?>
												<img src="<?php echo esc_url( jsn_idyllic_clone_placeholder() ); ?>" alt="" loading="lazy" width="600" height="420">
												<?php
											}
											?>
										</a>
									</figure>
								</div>
								<div class="latest-blog-text">
									<?php jsn_idyllic_clone_entry_header(); ?>
									<div class="entry-content">
										<?php echo wp_kses_post( wp_trim_words( get_the_excerpt(), 22, '…' ) ); ?>
										<a class="more-link" href="<?php echo esc_url( get_permalink() ); ?>"><?php esc_html_e( 'Saiba mais', 'jsn-idyllic-clone' ); ?></a>
									</div>
								</div>
							</article>
						</div>
					</div>
					<?php
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</div>
</div>
