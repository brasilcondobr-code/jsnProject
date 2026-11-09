<?php
/**
 * Idyllic Clone — 404.
 *
 * @package JSN_Idyllic_Clone
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<div class="site-content-wrap wrap">
	<div class="content-area no-sidebar">
		<div class="error-404">
			<h1 class="page-title"><?php esc_html_e( 'Página não encontrada', 'jsn-idyllic-clone' ); ?></h1>
			<p class="error-code" style="font-size:96px;color:var(--id-primary);line-height:1;margin:20px 0;">404</p>
			<p><?php esc_html_e( 'Parece que nada foi encontrado neste endereço. Tente a busca ou volte ao início.', 'jsn-idyllic-clone' ); ?></p>
			<p><a class="btn-default" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Voltar ao início', 'jsn-idyllic-clone' ); ?></a></p>
		</div>
		<?php get_search_form(); ?>
	</div>
</div>
<?php
get_footer();
