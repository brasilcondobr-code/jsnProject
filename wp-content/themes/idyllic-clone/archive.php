<?php
/**
 * Idyllic Clone — layout de listagens (archive/search) com sidebar.
 *
 * @package JSN_Idyllic_Clone
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<div class="site-content-wrap wrap">
	<div id="primary" class="content-area clearfix">
		<header class="page-header">
			<?php
			if ( is_search() ) {
				?>
				<h1 class="page-title">
					<?php
					printf(
						/* translators: %s: termo */
						esc_html__( 'Resultados para: %s', 'jsn-idyllic-clone' ),
						'<span>' . esc_html( get_search_query() ) . '</span>'
					);
					?>
				</h1>
				<?php
			} elseif ( is_archive() ) {
				echo '<h1 class="page-title">' . wp_kses_post( get_the_archive_title() ) . '</h1>' . wp_kses_post( get_the_archive_description() );
			}
			?>
		</header>

		<?php
		if ( have_posts() ) {
			while ( have_posts() ) :
				the_post();
				?>
				<article <?php post_class( 'jsn-idyllic-post-card' ); ?>>
					<div class="latest-blog-image">
						<figure class="post-featured-image">
							<a href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
								<?php
								if ( has_post_thumbnail() ) {
									the_post_thumbnail( 'jsn-idyllic-clone-card', array( 'loading' => 'lazy' ) );
								} else {
									echo '<img src="' . esc_url( jsn_idyllic_clone_placeholder() ) . '" alt="" loading="lazy" width="600" height="420">';
								}
								?>
							</a>
						</figure>
					</div>
					<div class="latest-blog-text">
						<?php jsn_idyllic_clone_entry_header(); ?>
						<div class="entry-content">
							<?php echo wp_kses_post( wp_trim_words( get_the_excerpt(), 26, '…' ) ); ?>
							<a class="more-link" href="<?php echo esc_url( get_permalink() ); ?>"><?php esc_html_e( 'Saiba mais', 'jsn-idyllic-clone' ); ?></a>
						</div>
					</div>
				</article>
				<?php
			endwhile;

			echo '<nav class="pagination" aria-label="' . esc_attr__( 'Navegação de posts', 'jsn-idyllic-clone' ) . '">';
			echo paginate_links( array( 'prev_text' => '←', 'next_text' => '→' ) ); // phpcs:ignore WordPress.Security.EscapeOutput
			echo '</nav>';
		} else {
			?>
			<h2><?php esc_html_e( 'Nada encontrado', 'jsn-idyllic-clone' ); ?></h2>
			<?php get_search_form(); ?>
			<?php
		}
		?>
	</div>

	<?php get_sidebar(); ?>
</div>
<?php
get_footer();
