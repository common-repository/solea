<?php
/**
 * File: class-maillibrary.php
 *
 * @since 2024-07-24
 * @license GPL-3.0-or-later
 *
 * @package Solea/core
 */

namespace Solea\Libs;

/**
 * Provides a mail environment for solea tasks
 */
class MailLibrary {

	/**
	 * Contains recipients of the mail
	 *
	 * @var array
	 */
	private array $recipients;

	/**
	 * Contains the subject of the mail
	 *
	 * @var string
	 */
	private string $subject;

	/**
	 * Contains the html - encoded message
	 *
	 * @var string
	 */
	private string $message;

	/**
	 * Contains the reply-to address
	 *
	 * @var string|false|mixed|null
	 */
	private string $sender;

	/**
	 * Constructor of the class
	 */
	public function __construct() {
		$this->sender = get_option( 'admin_email' );
	}

	/**
	 * Extracts a valid email - address from a text string
	 *
	 * @param string $text Unparsed mail text.
	 *
	 * @return string
	 */
	private function extract_mail( string $text ): string {
		$email_pattern = '/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}/i';
		preg_match( $email_pattern, $text, $matches );
		return isset( $matches[0] ) ? $matches[0] : '';
	}
	/**
	 * Sets the recipients from a text string.
	 *
	 * @param string $recipients A list of recipients separated by spaces or semicolons.
	 */
	public function set_recipients_from_text( string $recipients ) {
		$recipients = str_replace( ' ', ',', $recipients );
		$recipients = str_replace( ';', ',', $recipients );
		foreach ( explode( ',', $recipients ) as $recipient ) {
			$recipient = trim( $recipient );
			$email     = $this->extract_mail( $recipient );
			if ( '' !== $email ) {
				$this->add_recipient( $email );
			}
		}
	}

	/**
	 * Sends the email to all recipients and returns a log of the send status.
	 *
	 * @global WP_Error $wp_error Contains error information for failed sends.
	 *
	 * @return array An array with two keys: 'sent' containing recipients who were successfully sent the email, and 'failed' containing recipients for whom sending failed.
	 */
	public function send(): array {
		global $wp_error;
		$header = array(
			'Reply-To: ' . $this->sender,
			'Content-Type: text/html; charset=UTF-8',
		);

		$mail_protocol = array(
			'sent'   => array(),
			'failed' => array(),
		);

		foreach ( $this->recipients as $recipient ) {
			if ( wp_mail( $recipient, $this->subject, $this->message, $header ) ) {
				$mail_protocol['sent'][] = $recipient;
			} else {
				$mail_protocol['failed'][] = $recipient;
			}
		}

		return $mail_protocol;
	}

	/**
	 * Adds a recipient to the list.
	 *
	 * @param string $recipient The email address of the recipient.
	 */
	public function add_recipient( string $recipient ): void {
		$this->recipients[] = $recipient;
	}

	/**
	 * Sets the subject of the email.
	 *
	 * @param string $subject The subject of the email.
	 */
	public function set_subject( string $subject ): void {
		$this->subject = $subject;
	}

	/**
	 * Sets the message body of the email.
	 *
	 * @param string $message The message body of the email.
	 */
	public function set_message( string $message ): void {
		$this->message = $message;
	}

	/**
	 * Sets the list of recipients.
	 *
	 * @param array $recipients An array of recipient email addresses.
	 */
	public function set_recipients( array $recipients ): void {
		$this->recipients = $recipients;
	}

	/**
	 * Sets the sender's email address.
	 *
	 * @param string $sender The sender's email address.
	 */
	public function set_sender( string $sender ): void {
		$this->sender = $sender;
	}
}
