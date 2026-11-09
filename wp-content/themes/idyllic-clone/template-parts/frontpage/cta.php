<?php
/**
 * Idyllic Clone — CTA Banner (faixa de chamada).
 *
 * @package JSN_Idyllic_Clone
 */

defined( 'ABSPATH' ) || exit;

$jsn_title  = jsn_idyllic_clone_get_setting( 'cta_title', __( 'Pronto para começar? Fale com a nossa equipe.', 'jsn-idyllic-clone' ) );
$jsn_button = jsn_idyllic_clone_get_setting( 'cta_button_text', __( 'Entre em contato', 'jsn-idyllic-clone' ) );
$jsn_url    = jsn_idyllic_clone_get_setting( 'cta_button_url', '' );
?>
<div class="cta-banner">
	<div class="wrap">
		<h2><?php echo esc_html( $jsn_title ); ?></h2>
		<?php if ( '' !== $jsn_url ) : ?>
			<a class="btn-default" href="<?php echo esc_url( $jsn_url ); ?>"><?php echo esc_html( $jsn_button ); ?></a>
		<?php endif; ?>
	</div>
</div>
