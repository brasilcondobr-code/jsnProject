<?php
/**
 * Plugin Name: JSN Mailpit
 * Description: Encaminha e-mails do WordPress para o Mailpit em ambiente local.
 * Version: 0.1.0
 * Author: JSN
 *
 * @package JSN
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'phpmailer_init',
	static function ( $phpmailer ) {
		$host = defined( 'MAILPIT_HOST' ) ? MAILPIT_HOST : getenv( 'MAILPIT_HOST' );
		$port = defined( 'MAILPIT_PORT' ) ? MAILPIT_PORT : getenv( 'MAILPIT_PORT' );

		if ( ! $host ) {
			return;
		}

		$phpmailer->isSMTP();
		$phpmailer->Host        = $host;
		$phpmailer->Port        = (int) ( $port ? $port : 1025 );
		$phpmailer->SMTPAuth    = false;
		$phpmailer->SMTPAutoTLS = false;
	},
	99999
);
