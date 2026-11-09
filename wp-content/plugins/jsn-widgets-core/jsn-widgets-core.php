<?php
/**
 * Plugin Name: JSN Widgets Core
 * Plugin URI: https://jsn.local/
 * Description: Camada de dados do projeto JSN: CPTs, taxonomias, REST, padrões Gutenberg e central de widgets.
 * Version: 0.1.0
 * Requires at least: 6.5
 * Requires PHP: 8.1
 * Author: JSN Negócios Administrativos
 * Author URI: https://jsn.local/
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: jsn-widgets-core
 * Domain Path: /languages
 *
 * @package JSN_Widgets_Core
 */

defined( 'ABSPATH' ) || exit;

define( 'JSN_WIDGETS_CORE_VERSION', '0.1.0' );
define( 'JSN_WIDGETS_CORE_FILE', __FILE__ );
define( 'JSN_WIDGETS_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'JSN_WIDGETS_CORE_URL', plugin_dir_url( __FILE__ ) );

require_once JSN_WIDGETS_CORE_DIR . 'includes/class-jsn-widgets-core.php';

JSN_Widgets_Core::instance();

register_activation_hook( __FILE__, array( 'JSN_Widgets_Core', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'JSN_Widgets_Core', 'deactivate' ) );
