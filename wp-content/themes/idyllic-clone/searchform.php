<?php
/**
 * Idyllic Clone — formulário de busca.
 *
 * @package JSN_Idyllic_Clone
 */

defined( 'ABSPATH' ) || exit;
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="search-form-field"><?php esc_html_e( 'Pesquisar por:', 'jsn-idyllic-clone' ); ?></label>
	<input type="search" id="search-form-field" class="search-field" name="s" placeholder="<?php esc_attr_e( 'Buscar…', 'jsn-idyllic-clone' ); ?>">
	<button type="submit" class="search-submit"><?php jsn_idyllic_clone_icon( 'search' ); ?><span class="screen-reader-text"><?php esc_html_e( 'Buscar', 'jsn-idyllic-clone' ); ?></span></button>
</form>
