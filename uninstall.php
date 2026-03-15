<?php
/**
 * Tasks to run during uninstallation of this plugin.
 *
 * @package crypt-for-wordpress-demo
 */

// prevent direct access.
defined( 'ABSPATH' ) || exit;

// if uninstall.php is not called by WordPress, die.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

// nothing to do.
