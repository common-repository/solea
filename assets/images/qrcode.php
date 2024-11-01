<?php
/**
 * File: qrcode.php
 *
 * @since 2024-07-24
 * @license GPL-3.0-or-later
 *
 * @package solea/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../app/requests/class-createsepaqrcode.php';


use Solea\App\Requests\CreateSepaQRCode;


// header('Content-type: image/png');

CreateSepaQRCode::send( 5 );
