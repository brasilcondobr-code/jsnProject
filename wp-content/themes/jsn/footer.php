<?php
/**
 * Rodapé do tema.
 *
 * @package JSN
 */

defined( 'ABSPATH' ) || exit;
?>
<footer class="jsn-footer" id="colophon">
	<div class="jsn-container jsn-footer__inner">
		<div class="jsn-footer__brand">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
			<p><?php esc_html_e( 'Gestão e serviços administrativos para condomínios.', 'jsn' ); ?></p>
		</div>

		<nav class="jsn-footer__nav" aria-label="<?php esc_attr_e( 'Menu do rodapé', 'jsn' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'container'      => false,
					'menu_class'     => 'jsn-menu jsn-menu--footer',
					'fallback_cb'    => false,
					'depth'          => 2,
				)
			);
			?>
		</nav>

		<div class="jsn-footer__meta">
			<p>
				<?php
				printf(
					/* translators: %s: ano atual. */
					esc_html__( '© %s JSN Negócios Administrativos. Todos os direitos reservados.', 'jsn' ),
					esc_html( gmdate( 'Y' ) )
				);
				?>
			</p>
			<a href="<?php echo esc_url( wp_login_url() ); ?>"><?php esc_html_e( 'Acesso restrito', 'jsn' ); ?></a>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
