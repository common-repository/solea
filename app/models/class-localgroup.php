<?php
/**
 * File: class-localgroup.php
 *
 * @since 2024-07-21
 * @license GPL-3.0-or-later
 *
 * @package Solea/Models/
 */

namespace Solea\App\models;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class LocalGroup
 *
 * Represents a local group.
 */
class LocalGroup extends MainModel {
	/**
	 * Disables the creation and last update date information. We do not need it.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * Fillable database fields.
	 *
	 * @var string[] Database keys you can use.
	 */
	protected $fillable = array(
		'name',
		'email',
		'members_email',
		'zip',
		'city',
	);

	/**
	 * Constructor of the class.
	 */
	public function __construct() {
		parent::__construct( get_class( $this ) );
	}
}
