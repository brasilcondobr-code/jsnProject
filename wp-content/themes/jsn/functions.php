<?php
/**
 * Bootstrap do tema JSN.
 *
 * @package JSN
 */

defined( 'ABSPATH' ) || exit;

define( 'JSN_THEME_VERSION', '0.1.0' );
define( 'JSN_THEME_DIR', get_template_directory() );
define( 'JSN_THEME_URI', get_template_directory_uri() );

require_once JSN_THEME_DIR . '/inc/class-jsn-widget-registry.php';
require_once JSN_THEME_DIR . '/inc/setup/class-jsn-roles.php';
require_once JSN_THEME_DIR . '/inc/api/class-jsn-rest.php';
require_once JSN_THEME_DIR . '/inc/class-jsn-theme.php';

JSN_Theme::instance();
