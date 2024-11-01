<?php
/**
 * File: photopermission.php
 *
 * @since 2024-07-22
 * @license GPL-3.0-or-later
 *
 * @package Solea/Views/Registration/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<p style="font-weight: bold; font-size: 13pt;">
	<?php echo esc_html__( 'Please let us know what we can take photos of you / your child for.', 'solea' ); ?>
</p>

<p>
	<input type="checkbox" name="foto[socialmedia]" value="active" id="foto_socialmedia" />
	<label for="foto_socialmedia"><?php echo esc_html__( 'Social Media (Facebook / Instagram / ...)', 'solea' ); ?></label><br />
</p>

<p>
	<input type="checkbox" name="foto[print]" value="active" id="foto_print" />
	<label for="foto_print"><?php echo esc_html__( 'Print Media (Local newspaper, club magazine, postcards)', 'solea' ); ?></label><br />
</p>

<p>
	<input type="checkbox" name="foto[webseite]" value="active" id="foto_webseite" />
	<label for="foto_webseite"><?php echo esc_html__( 'Websites (club\'s website / local group\'s website)', 'solea' ); ?></label><br />
</p>

<p>
	<input type="checkbox" name="foto[partner]" value="active" id="foto_partner" />
	<label for="foto_partner"><?php echo esc_html__( 'Partners & Sponsors (often in the form of emails)', 'solea' ); ?></label><br />
</p>

<p>
	<input type="checkbox" name="foto[intern]" value="active" id="foto_intern" />
	<label for="foto_intern"><?php echo esc_html__( 'Internal purposes (chronicle, protected digital photo album)', 'solea' ); ?></label><br />
</p>

<?php
if ( $event->registration_solidarity ) {
	?>
<input type="button" value="<?php echo esc_html__( 'Previous', 'solea' ); ?>" onclick="showStep(6)" />
	<?php
} else {
	?>
		<input type="button" value="<?php echo esc_html__( 'Previous', 'solea' ); ?>" onclick="showStep(5)" />
	<?php
}
?>

<input style="width: 200px;" type="button" value="<?php echo esc_html__( 'Accept all and next', 'solea' ); ?>" onclick="solea_accept_all_permissions()" />
<input type="button" value="<?php echo esc_html__( 'Next', 'solea' ); ?>" onclick="showStep(8)" />
