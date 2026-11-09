<?php
/**
 * Idyllic Clone — Top bar (contato à direita, redes à esquerda).
 *
 * @package JSN_Idyllic_Clone
 */

defined( 'ABSPATH' ) || exit;

$jsn_topbar = jsn_idyllic_clone_get_topbar();
?>
<div class="top-bar">
	<div class="wrap">
		<div class="header-social-block social-links">
			<?php jsn_idyllic_clone_social_links(); ?>
		</div>
		<aside class="widget-contact">
			<ul class="jsn-topbar-list">
				<?php if ( ! empty( $jsn_topbar['address'] ) ) : ?>
					<li>
						<a href="#">
							<?php jsn_idyllic_clone_icon( 'map-marker' ); ?>
							<?php echo esc_html( $jsn_topbar['address'] ); ?>
						</a>
					</li>
				<?php endif; ?>
				<?php if ( ! empty( $jsn_topbar['phone'] ) ) : ?>
					<li>
						<a href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', $jsn_topbar['phone'] ) ); ?>">
							<?php jsn_idyllic_clone_icon( 'phone' ); ?>
							<?php echo esc_html( $jsn_topbar['phone'] ); ?>
						</a>
					</li>
				<?php endif; ?>
				<?php if ( ! empty( $jsn_topbar['email'] ) ) : ?>
					<li>
						<a href="mailto:<?php echo esc_attr( antispambot( $jsn_topbar['email'] ) ); ?>">
							<?php jsn_idyllic_clone_icon( 'envelope' ); ?>
							<?php echo esc_html( antispambot( $jsn_topbar['email'] ) ); ?>
						</a>
					</li>
				<?php endif; ?>
			</ul>
		</aside>
	</div>
</div>
