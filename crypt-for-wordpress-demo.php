<?php
/**
 * Plugin Name:       Crypt for WordPress Demo
 * Description:       This plugin demonstrates the usage of the composer package threadi/crypt.
 * Requires at least: 6.0
 * Requires PHP:      8.2
 * Version:           1.0.3
 * Author:            Thomas Zwirner
 * Author URI:        https://www.thomaszwirner.de
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       crypt-for-wordpress-demo
 *
 * @package crypt-for-wordpress-demo
 */

// prevent direct access.
defined( 'ABSPATH' ) || exit;

use CryptForWordPress\Crypt;
use CryptForWordPress\Method_Base;
use CryptForWordPress\Place_Base;

// do nothing if the PHP version is not 8.2 or newer.
if ( PHP_VERSION_ID < 80200 ) { // @phpstan-ignore smaller.alwaysFalse
	return;
}

// embed the composer packages.
require __DIR__ . '/vendor/autoload.php';

/**
 * Add a new dashboard widget.
 *
 * @return void
 */
function cfwd_add_dashboard_widgets(): void {
	wp_add_dashboard_widget(
		'cfwd_dashboard_widget',
		__( 'Crypt for WordPress Demo', 'crypt-for-wordpress-demo' ),
		'cfwd_dashboard',
		null,
		null,
		'normal',
		'high'
	);
}
add_action( 'wp_dashboard_setup', 'cfwd_add_dashboard_widgets' );

/**
 * Show how this plugin encrypt and decrypt a string.
 *
 * @return void
 */
function cfwd_dashboard(): void {
	// configure the crypt object.
	$crypt = new Crypt( __FILE__ );
	$crypt->set_config(
		array(
			'openssl' => array(
				'hash_type'        => 'hash_pbkdf2',
				'hash_algorithm'   => 'sha256',
				'cipher_algorithm' => 'chacha20-poly1305',
			),
			'sodium'  => array(
				'hash_type' => 'sodium_crypto_secretbox_keygen',
			),
		)
	);

	// get the place.
	$place = $crypt->get_place();

	// bail if no place could be loaded.
	if ( ! $place instanceof Place_Base ) {
		return;
	}

	// get the method.
	$method = $crypt->get_method();

	// bail if no method could be loaded.
	if ( ! $method instanceof Method_Base ) {
		echo '<strong>' . esc_html__( 'Could not load any method to encrypt strings!', 'crypt-for-wordpress-demo' ) . '</strong>';
		return;
	}

	// show the example.
	echo '<strong>' . esc_html__( 'Used place for the key:', 'crypt-for-wordpress-demo' ) . '</strong> <code>' . esc_html( $place->get_name() ) . '</code><br>';
	echo '<strong>' . esc_html__( 'Used method:', 'crypt-for-wordpress-demo' ) . '</strong> <code>' . esc_html( $method->get_name() ) . '</code><br>';
	$original = __( 'Hello World!', 'crypt-for-wordpress-demo' );
	echo '<strong>' . esc_html__( 'Original:', 'crypt-for-wordpress-demo' ) . '</strong> <code>' . esc_html( $original ) . '</code><br>';
	$encrypted = $crypt->encrypt( $original );
	echo '<strong>' . esc_html__( 'Encrypted:', 'crypt-for-wordpress-demo' ) . '</strong> <code>' . esc_html( $encrypted ) . '</code><br>';
	$decrypted = $crypt->decrypt( $encrypted );
	echo '<strong>' . esc_html__( 'Decrypted:', 'crypt-for-wordpress-demo' ) . '</strong> <code>' . esc_html( $decrypted ) . '</code><br>';
	$has_errors = $crypt->has_errors();
	echo '<strong>' . esc_html__( 'Errors:', 'crypt-for-wordpress-demo' ) . '</strong> <code>' . ( $has_errors ? esc_html__( 'Yes', 'crypt-for-wordpress-demo' ) : esc_html__( 'No', 'crypt-for-wordpress-demo' ) ) . '</code><br>';
	if ( $has_errors ) {
		$errors = $crypt->get_errors();
		if ( $errors instanceof WP_Error ) {
			foreach ( $errors->errors as $error ) {
				foreach ( $error as $key => $value ) {
					echo '<strong>' . esc_html( $key ) . '</strong> ' . wp_kses_post( implode( '', $value ) ) . '<br>';
				}
			}
		}
	}
}
