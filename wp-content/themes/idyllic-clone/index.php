<?php
/**
 * Idyllic Clone — fallback geral (blog/arquivos).
 *
 * @package JSN_Idyllic_Clone
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<div class="site-content-wrap wrap">
<?php
if ( have_posts() ) {
	if ( is_home() && ! is_front_page() ) {
		?>
		<header class="page-header">
			<h1 class="page-title"><?php single_post_title(); ?></h1>
		</header>
		<?php
	}
	?>
	<div id="primary" class="content-area no-sidebar clearfix">
		<?php
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
		?>
	</div>
	<nav class="pagination" aria-label="<?php esc_attr_e( 'Navegação de posts', 'jsn-idyllic-clone' ); ?>">
		<?php
		echo paginate_links( array(
			'prev_text' => '←',
			'next_text' => '→',
		) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>
	</nav>
	<?php
} else {
	?>
	<div class="content-area no-sidebar">
		<h1><?php esc_html_e( 'Nada encontrado', 'jsn-idyllic-clone' ); ?></h1>
		<p><?php esc_html_e( 'Desculpe, nenhum conteúdo corresponde à sua busca.', 'jsn-idyllic-clone' ); ?></p>
		<?php get_search_form(); ?>
	</div>
	<?php
}
?>
</div>
<?php
get_footer();
