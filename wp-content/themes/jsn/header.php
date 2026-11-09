<?php
/**
 * Cabeçalho do tema.
 *
 * @package JSN
 */

defined( 'ABSPATH' ) || exit;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="jsn-skip-link" href="#main"><?php esc_html_e( 'Pular para o conteúdo', 'jsn' ); ?></a>

<header class="jsn-header" id="masthead">
	<div class="jsn-container jsn-header__inner">
		<div class="jsn-branding">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a class="jsn-branding__link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<span class="jsn-branding__mark" aria-hidden="true">JSN</span>
					<span class="jsn-branding__text">
						<strong><?php bloginfo( 'name' ); ?></strong>
						<small><?php bloginfo( 'description' ); ?></small>
					</span>
				</a>
			<?php endif; ?>
		</div>

		<button class="jsn-nav-toggle" type="button" aria-expanded="false" aria-controls="jsn-primary-nav" data-jsn-nav-toggle>
			<span class="screen-reader-text"><?php esc_html_e( 'Abrir menu', 'jsn' ); ?></span>
			<span aria-hidden="true"></span>
			<span aria-hidden="true"></span>
			<span aria-hidden="true"></span>
		</button>

		<div class="jsn-header__nav" id="jsn-primary-nav" data-jsn-nav>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'jsn-menu',
					'fallback_cb'    => false,
					'depth'          => 2,
				)
			);
			?>
			<div class="jsn-header__actions">
				<?php if ( is_user_logged_in() ) : ?>
					<a class="jsn-button jsn-button--small jsn-button--primary" href="<?php echo esc_url( get_permalink( get_page_by_path( 'area-restrita' ) ) ); ?>">
						<?php esc_html_e( 'Minha área', 'jsn' ); ?>
					</a>
					<a class="jsn-header__login" href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>">
						<?php esc_html_e( 'Sair', 'jsn' ); ?>
					</a>
				<?php else : ?>
					<a class="jsn-button jsn-button--small jsn-button--primary" href="<?php echo esc_url( wp_login_url( get_permalink( get_page_by_path( 'area-restrita' ) ) ) ); ?>">
						<?php esc_html_e( 'Entrar', 'jsn' ); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</header>
