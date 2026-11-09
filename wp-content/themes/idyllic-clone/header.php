<?php
/**
 * Idyllic Clone — cabeçalho.
 *
 * @package JSN_Idyllic_Clone
 */

defined( 'ABSPATH' ) || exit;
?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class( 'idyllic-clone' ); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#site-content-contain"><?php esc_html_e( 'Pular para o conteúdo', 'jsn-idyllic-clone' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<?php if ( is_front_page() && jsn_idyllic_clone_is_active( 'topbar' ) ) : ?>
			<?php get_template_part( 'template-parts/header/top-bar' ); ?>
		<?php endif; ?>

		<div id="sticky-header">
			<div class="wrap">
				<div class="main-header clearfix">
					<div class="site-branding">
						<?php if ( has_custom_logo() ) : ?>
							<?php the_custom_logo(); ?>
						<?php else : ?>
							<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
							<?php
							$description = get_bloginfo( 'description', 'display' );
							if ( $description ) :
								?>
								<p class="site-description"><?php echo esc_html( $description ); ?></p>
							<?php endif; ?>
						<?php endif; ?>
					</div>

					<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Menu Principal', 'jsn-idyllic-clone' ); ?>">
						<button class="menu-toggle" type="button" aria-controls="primary-menu" aria-expanded="false">
							<span></span>
							<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'jsn-idyllic-clone' ); ?></span>
						</button>
						<?php
						wp_nav_menu( array(
							'theme_location' => 'primary',
							'menu_id'        => 'primary-menu',
							'container'      => false,
							'depth'          => 2,
						) );
						?>
					</nav>

					<div class="header-actions">
						<button id="search-toggle" class="search-toggle" type="button" aria-controls="search-box" aria-expanded="false">
							<?php jsn_idyllic_clone_icon( 'search' ); ?>
							<span class="screen-reader-text"><?php esc_html_e( 'Abrir busca', 'jsn-idyllic-clone' ); ?></span>
						</button>
					</div>
				</div>
			</div>
		</div>

		<div id="search-box" class="header-search-box">
			<div class="wrap">
				<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<label class="screen-reader-text" for="header-search-field"><?php esc_html_e( 'Pesquisar por:', 'jsn-idyllic-clone' ); ?></label>
					<input type="search" id="header-search-field" class="search-field" name="s" placeholder="<?php esc_attr_e( 'Buscar…', 'jsn-idyllic-clone' ); ?>" autocomplete="off">
					<button type="submit" class="search-submit"><?php jsn_idyllic_clone_icon( 'search' ); ?><span class="screen-reader-text"><?php esc_html_e( 'Buscar', 'jsn-idyllic-clone' ); ?></span></button>
				</form>
			</div>
		</div>
	</header>

	<?php if ( is_front_page() ) : ?>
		<div class="main-hero">
			<?php
			if ( jsn_idyllic_clone_is_active( 'hero' ) ) {
				get_template_part( 'template-parts/frontpage/hero-slider' );
			}
			?>
		</div><!-- .main-hero -->
	<?php endif; ?>

	<div id="site-content-contain" class="site-content-contain">
		<div id="content" class="site-content">
			<main id="main" class="site-main" role="main">
