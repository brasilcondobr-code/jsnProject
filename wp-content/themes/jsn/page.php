<?php
/**
 * Template padrão de página.
 *
 * @package JSN
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="main" class="jsn-main">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<section class="jsn-page-hero">
			<div class="jsn-container">
				<p class="jsn-eyebrow"><?php esc_html_e( 'JSN', 'jsn' ); ?></p>
				<h1><?php the_title(); ?></h1>
			</div>
		</section>
		<section class="jsn-section">
			<div class="jsn-container jsn-prose">
				<?php the_content(); ?>
			</div>
		</section>
	<?php endwhile; ?>
</main>
<?php
get_footer();
