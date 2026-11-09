<?php
/**
 * Suportes do tema.
 *
 * @package JSN
 */

defined( 'ABSPATH' ) || exit;

return array(
	'title-tag'             => true,
	'automatic-feed-links'  => true,
	'post-thumbnails'       => true,
	'responsive-embeds'     => true,
	'align-wide'            => true,
	'wp-block-styles'       => true,
	'editor-styles'         => true,
	'block-patterns'        => true,
	'html5'                 => array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ),
	'custom-logo'           => array(
		'height'      => 96,
		'width'       => 320,
		'flex-height' => true,
		'flex-width'  => true,
	),
);
