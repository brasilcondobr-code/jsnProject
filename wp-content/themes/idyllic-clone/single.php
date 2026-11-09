<?php
/**
 * Idyllic Clone — post individual (destaque + conteúdo + sidebar + meta).
 *
 * @package JSN_Idyllic_Clone
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<div class="site-content-wrap wrap">
	<div id="primary" class="content-area clearfix">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="page-header">
					<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>

					<div class="entry-meta">
						<?php
						$jsn_cats = get_the_category();
						if ( ! empty( $jsn_cats ) ) {
							echo '<span class="cat-links"><a href="' . esc_url( get_category_link( $jsn_cats[0]->term_id ) ) . '">' . esc_html( $jsn_cats[0]->name ) . '</a></span>';
						}
						?>
						<span class="posted-on">
							<a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_date() ); ?></a>
						</span>
						<span class="author vcard">
							<?php
							esc_html_e( 'Por', 'jsn-idyllic-clone' );
							echo ' ';
							the_author_posts_link();
							?>
						</span>
					</div>
				</header>

				<?php if ( has_post_thumbnail() ) : ?>
					<figure class="post-featured-image">
						<?php the_post_thumbnail( 'large', array( 'loading' => 'eager' ) ); ?>
					</figure>
				<?php endif; ?>

				<div class="entry-content">
					<?php
					the_content();
					wp_link_pages( array(
						'before' => '<nav class="page-links" aria-label="' . esc_attr__( 'Páginas', 'jsn-idyllic-clone' ) . '">',
						'after'  => '</nav>',
					) );
					?>
				</div>

				<footer class="entry-footer">
					<?php
					$jsn_tags = get_the_tag_list( '<span class="tag-links">', ' ', '</span>' );
					if ( $jsn_tags ) {
						echo wp_kses_post( $jsn_tags );
					}
					?>
					<nav class="post-navigation" aria-label="<?php esc_attr_e( 'Navegação do post', 'jsn-idyllic-clone' ); ?>">
						<?php the_post_navigation( array(
							'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Anterior', 'jsn-idyllic-clone' ) . '</span> <span class="nav-title">%title</span>',
							'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Próximo', 'jsn-idyllic-clone' ) . '</span> <span class="nav-title">%title</span>',
						) ); ?>
					</nav>
				</footer>
			</article>

			<?php
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
		endwhile;
		?>
	</div>

	<?php get_sidebar(); ?>
</div>
<?php
get_footer();
