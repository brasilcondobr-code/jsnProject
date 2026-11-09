<?php
/**
 * Template 404.
 *
 * @package JSN
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="main" class="jsn-main">
	<section class="jsn-page-hero">
		<div class="jsn-container">
			<p class="jsn-eyebrow">404</p>
			<h1><?php esc_html_e( 'Página não encontrada', 'jsn' ); ?></h1>
			<p><?php esc_html_e( 'O endereço acessado não existe ou foi movido.', 'jsn' ); ?></p>
			<p><a class="jsn-button jsn-button--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Voltar para a home', 'jsn' ); ?></a></p>
		</div>
	</section>
</main>
<?php
get_footer();
