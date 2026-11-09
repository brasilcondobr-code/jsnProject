<?php
/**
 * Uninstall do plugin.
 *
 * @package JSN_Widgets_Core
 */

defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

delete_option( 'jsn_widgets_disabled' );
