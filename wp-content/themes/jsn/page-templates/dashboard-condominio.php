<?php
/**
 * Template Name: Dashboard Condomínio
 * Template Post Type: page
 *
 * @package JSN
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="main" class="jsn-main jsn-restricted">
	<section class="jsn-page-hero">
		<div class="jsn-container">
			<p class="jsn-eyebrow"><?php esc_html_e( 'Portal JSN', 'jsn' ); ?></p>
			<h1><?php echo esc_html( get_the_title() ); ?></h1>
			<p><?php esc_html_e( 'Visão consolidada do condomínio — estrutura preparada para a fase 2.', 'jsn' ); ?></p>
		</div>
	</section>

	<?php get_template_part( 'template-parts/dashboard-condominio' ); ?>
</main>
<?php
get_footer();
