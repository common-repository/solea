<?php
/**
 * File: sqlsetup.php
 *
 * @since 2024-07-21
 * @license GPL-3.0-or-later
 *
 * @package solea/Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Illuminate\Database\Capsule\Manager;

$capsule = new Manager();
$capsule->addConnection(
	array(
		'driver'    => 'mysql',
		'host'      => DB_HOST,
		'database'  => DB_NAME,
		'username'  => DB_USER,
		'password'  => DB_PASSWORD,
		'charset'   => 'utf8',
		'collation' => 'utf8_unicode_ci',
		'prefix'    => '',
	)
);
$capsule->setAsGlobal();
$capsule->bootEloquent();
