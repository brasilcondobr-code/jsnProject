<?php
/**
 * Idyllic Clone — rodapé.
 *
 * @package JSN_Idyllic_Clone
 */

defined( 'ABSPATH' ) || exit;
			?>
		</main><!-- #main -->
	</div><!-- .site-content -->
</div><!-- .site-content-contain -->

<footer id="colophon" class="site-footer" role="contentinfo">
	<div class="colophon-widgets">
		<div class="wrap clearfix">
			<?php
			for ( $i = 1; $i <= 4; $i++ ) {
				if ( is_active_sidebar( 'footer-' . $i ) ) {
					echo '<div class="footer-column width-responsive">';
					dynamic_sidebar( 'footer-' . $i );
					echo '</div>';
				}
			}
			?>
		</div>
	</div>

	<div class="site-info">
		<div class="wrap">
			<div class="copyright">
				<?php
				printf(
					/* translators: %1$s: nome do site, %2$s: ano */
					esc_html__( '© %2$s %1$s. Todos os direitos reservados.', 'jsn-idyllic-clone' ),
					esc_html( get_bloginfo( 'name' ) ),
					esc_html( wp_date( 'Y' ) )
				);
				?>
			</div>
			<div class="site-footer-menu">
				<?php
				if ( has_nav_menu( 'footer' ) ) {
					wp_nav_menu( array(
						'theme_location' => 'footer',
						'container'      => false,
						'depth'          => 1,
					) );
				} else {
					echo '<div class="footer-links">';
					jsn_idyllic_clone_social_links();
					echo '</div>';
				}
				?>
			</div>
			<div class="site-footer-social social-links">
				<?php jsn_idyllic_clone_social_links(); ?>
			</div>
		</div>
	</div>
</footer>

<button class="go-to-top" type="button">
	<span class="btn-default">
		<?php jsn_idyllic_clone_icon( 'chevron-up' ); ?>
		<span class="screen-reader-text"><?php esc_html_e( 'Voltar ao topo', 'jsn-idyllic-clone' ); ?></span>
	</span>
</button>

<?php wp_footer(); ?>
</body>
</html>
