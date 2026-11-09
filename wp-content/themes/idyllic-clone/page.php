<?php
/**
 * Idyllic Clone — página interna (com sidebar opcional).
 *
 * @package JSN_Idyllic_Clone
 */

defined( 'ABSPATH' ) || exit;

get_header();

$jsn_has_sidebar = is_active_sidebar( 'sidebar-1' );
?>
<div class="site-content-wrap wrap<?php echo $jsn_has_sidebar ? '' : ' no-sidebar-wrap'; ?>">
	<div id="primary" class="content-area<?php echo $jsn_has_sidebar ? '' : ' no-sidebar'; ?> clearfix">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="page-header">
					<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
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
