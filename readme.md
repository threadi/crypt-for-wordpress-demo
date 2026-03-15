# Crypt for WordPress Demo

This repository contains a WordPress demo plugin for [Crypt for WordPress](https://github.com/threadi/crypt-for-wordpress). It is intended to show the possibilities of the plugin. It is not intended to be used actively in a productive system. You are welcome to use the programming as a template for your own use of Crypt for WordPress.

## Use the demo

1. Download the actual release ZIP (not the source ZIP).
2. Install it in your WordPress and activate it.
3. You will see a demo encryption and decryption on your dashboard.

## Use it for development of the demo plugin

1. Checkout the repository in your development environment in the plugin directory or download the actual source ZIP.
2. Run `composer install` to get the sources.
3. Go to the backend of your development environment and activate the plugin.
4. You will see a demo encryption and decryption on your dashboard.

## Use it for development of the Crypt for WordPress composer package

1. Checkout the repository in your development environment in the plugin directory or download the actual source ZIP.
2. Checkout the repository https://github.com/threadi/crypt-for-wordpress in your hostings main directory (where **wp-admin** and **wp-config.php** are located).
3. Run: `chmod 755 composer.sh` 
4. Run `./composer.sh`
5. Go to the backend of your development environment and activate the plugin.
6. You are now able to develop on Crypt for WordPress and test the changes with the demo plugin.

## Check for WordPress Coding Standards

### Initialize

`composer install`

### Run

`vendor/bin/phpcs --standard=ruleset.xml .`

### Repair

`vendor/bin/phpcbf --standard=ruleset.xml .`

## Check for WordPress VIP Coding Standards

Hint: this check runs against the VIP-GO-platform which is not our target for this plugin. Many warnings can be ignored.

### Run

`vendor/bin/phpcs --extensions=php --ignore=*/vendor/* --standard=WordPress-VIP-Go .`

## Check PHP compatibility

`vendor/bin/phpcs -p crypt-for-wordpress-demo.php --standard=PHPCompatibilityWP`

## Analyse with PHPStan

`vendor/bin/phpstan analyse`