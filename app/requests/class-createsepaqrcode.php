<?php
/**
 * File: class-createsepaqrcode.php
 *
 * @since 2024-07-24
 * @license GPL-3.0-or-later
 *
 * @package Solae/Requests/
 */

namespace Solea\App\Requests;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelInterface;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\EpsWriter;
use Endroid\QrCode\Writer\PdfWriter;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\SvgWriter;
use Endroid\QrCode\Writer\WriterInterface;

/**
 * Class CreateSepaQRCode
 *
 * Sends a payment using the provided amount, recipient, subject, and IBAN.
 */
class CreateSepaQRCode {
	/**
	 * Sends a payment using the provided amount, recipient, subject, and IBAN.
	 *
	 * @param string $amount The amount of the payment.
	 * @param string $recipient The recipient of the payment.
	 * @param string $subject The subject of the payment.
	 * @param string $iban The IBAN (International Bank Account Number) for the payment.
	 *
	 * @return void
	 */
	public static function send(
		string $amount,
		string $recipient,
		string $subject,
		string $iban
	) {
		$png    = new PngWriter();
		$qrcode = QrCode::create( self::get_sepa_format( $recipient, $iban, $subject, $amount ) )
						->setEncoding( new Encoding( 'UTF-8' ) );

		header( 'Content-type: image/png' );
		print_r( $png->write( $qrcode )->getString() );
	}

	/**
	 * Returns the SEPA (Single Euro Payments Area) format for a payment.
	 *
	 * @param string $recipient The recipient of the payment.
	 * @param string $iban The IBAN (International Bank Account Number) for the payment.
	 * @param string $subject The subject of the payment.
	 * @param string $amount The amount of the payment.
	 *
	 * @return string The SEPA format for the payment.
	 */
	public static function get_sepa_format( string $recipient, string $iban, string $subject, string $amount ): string {
		return "BCD
001
1
SCT

$recipient
$iban
EUR$amount

$subject";
	}
}
