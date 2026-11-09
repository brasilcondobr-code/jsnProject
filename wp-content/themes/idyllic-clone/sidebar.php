<?php
/**
 * Idyllic Clone — sidebar.
 *
 * @package JSN_Idyllic_Clone
 */

defined( 'ABSPATH' ) || exit;

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>
<aside id="secondary" class="sidebar-area widget-area" role="complementary">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>
