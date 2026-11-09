<?php
/**
 * Idyllic Clone — funções principais.
 *
 * @package JSN_Idyllic_Clone
 */

defined( 'ABSPATH' ) || exit;

define( 'JSN_IDYLLIC_CLONE_VERSION', '1.0.4' );
define( 'JSN_IDYLLIC_CLONE_DIR', get_template_directory() );
define( 'JSN_IDYLLIC_CLONE_URI', get_template_directory_uri() );

require_once JSN_IDYLLIC_CLONE_DIR . '/inc/template-tags.php';
require_once JSN_IDYLLIC_CLONE_DIR . '/inc/enqueue.php';

/**
 * Setup do tema.
 *
 * @return void
 */
function jsn_idyllic_clone_setup() {
	load_theme_textdomain( 'jsn-idyllic-clone', JSN_IDYLLIC_CLONE_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'custom-logo', array(
		'height'      => 80,
		'width'       => 240,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'custom-header' );
	add_theme_support( 'custom-background', array( 'default-color' => 'ffffff' ) );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	) );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'customize-selective-refresh-widgets' );

	register_nav_menus( array(
		'primary' => __( 'Menu Principal', 'jsn-idyllic-clone' ),
		'social'  => __( 'Menu de Redes Sociais', 'jsn-idyllic-clone' ),
		'footer'  => __( 'Menu do Rodapé', 'jsn-idyllic-clone' ),
	) );

	add_image_size( 'jsn-idyllic-clone-card', 600, 420, true );
	add_image_size( 'jsn-idyllic-clone-team', 420, 520, true );
}
add_action( 'after_setup_theme', 'jsn_idyllic_clone_setup' );

/**
 * Aba de conteúdo (content_width).
 *
 * @return void
 */
function jsn_idyllic_clone_content_width() {
	$GLOBALS['content_width'] = 860;
}
add_action( 'after_setup_theme', 'jsn_idyllic_clone_content_width', 0 );

/**
 * Áreas de widget.
 *
 * @return void
 */
function jsn_idyllic_clone_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Barra Lateral (Sidebar)', 'jsn-idyllic-clone' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	for ( $i = 1; $i <= 4; $i++ ) {
		register_sidebar( array(
			/* translators: %d: coluna */
			'name'          => sprintf( __( 'Rodapé — Coluna %d', 'jsn-idyllic-clone' ), $i ),
			'id'            => sprintf( 'footer-%d', $i ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	}
}
add_action( 'widgets_init', 'jsn_idyllic_clone_widgets_init' );

/**
 * Módulos do tema.
 */
require_once JSN_IDYLLIC_CLONE_DIR . '/inc/custom-functions.php';
require_once JSN_IDYLLIC_CLONE_DIR . '/inc/customizer.php';
