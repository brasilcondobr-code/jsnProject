<?php
/**
 * Template de fallback.
 *
 * @package JSN
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="main" class="jsn-main">
	<section class="jsn-page-hero">
		<div class="jsn-container">
			<h1><?php echo esc_html( is_home() ? get_bloginfo( 'name' ) : get_the_archive_title() ); ?></h1>
		</div>
	</section>
	<section class="jsn-section">
		<div class="jsn-container">
			<?php if ( have_posts() ) : ?>
				<div class="jsn-post-list">
					<?php while ( have_posts() ) : ?>
						<?php the_post(); ?>
						<article <?php post_class( 'jsn-post-card' ); ?>>
							<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<div class="jsn-prose"><?php the_excerpt(); ?></div>
						</article>
					<?php endwhile; ?>
				</div>
				<?php the_posts_pagination(); ?>
			<?php else : ?>
				<p><?php esc_html_e( 'Nenhum conteúdo encontrado.', 'jsn' ); ?></p>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php
get_footer();
