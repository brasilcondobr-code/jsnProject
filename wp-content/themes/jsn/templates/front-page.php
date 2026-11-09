<?php
/**
 * Template Name: Home JSN
 * Template Post Type: page
 *
 * @package JSN
 */

defined( 'ABSPATH' ) || exit;

get_header();

$jsn_registry = JSN_Widget_Registry::instance();
?>
<main id="main" class="jsn-main jsn-front-page">
	<?php
	echo $jsn_registry->render( 'hero' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo $jsn_registry->render( 'cards-servicos' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo $jsn_registry->render( 'beneficios-condominio' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo $jsn_registry->render( 'faq' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo $jsn_registry->render( 'cta-contato' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	?>
</main>
<?php
get_footer();
