<?php
/**
 * Template de post único.
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
				<p class="jsn-eyebrow"><?php echo esc_html( get_the_date() ); ?></p>
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
