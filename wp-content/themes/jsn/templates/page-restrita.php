<?php
/**
 * Template Name: Área Restrita JSN
 * Template Post Type: page
 *
 * @package JSN
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="main" class="jsn-main jsn-restricted">
	<section class="jsn-page-hero">
		<div class="jsn-container">
			<p class="jsn-eyebrow"><?php esc_html_e( 'Portal JSN', 'jsn' ); ?></p>
			<h1><?php echo esc_html( get_the_title() ); ?></h1>
			<p><?php esc_html_e( 'Conteúdo exclusivo para usuários autenticados.', 'jsn' ); ?></p>
		</div>
	</section>

	<?php if ( ! is_user_logged_in() ) : ?>
		<section class="jsn-section">
			<div class="jsn-container">
				<div class="jsn-login-card">
					<h2><?php esc_html_e( 'Acesso restrito', 'jsn' ); ?></h2>
					<p><?php esc_html_e( 'Entre com sua conta para acessar o portal do condomínio.', 'jsn' ); ?></p>
					<a class="jsn-button jsn-button--primary" href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>">
						<?php esc_html_e( 'Entrar', 'jsn' ); ?>
					</a>
				</div>
			</div>
		</section>
	<?php else : ?>
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<section class="jsn-section jsn-restricted__content">
				<div class="jsn-container">
					<div class="jsn-prose"><?php the_content(); ?></div>
					<nav class="jsn-restricted__nav" aria-label="<?php esc_attr_e( 'Menu restrito', 'jsn' ); ?>">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'restricted',
								'container'      => false,
								'menu_class'     => 'jsn-menu jsn-menu--restricted',
								'fallback_cb'    => false,
								'depth'          => 1,
							)
						);
						?>
					</nav>
				</div>
			</section>
		<?php endwhile; ?>

		<?php get_template_part( 'template-parts/dashboard-condominio' ); ?>
	<?php endif; ?>
</main>
<?php
get_footer();
