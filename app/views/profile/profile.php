<?php
/**
 * File profile.php
 *
 * Template edit additional profile data
 *
 * @since 2024-07-15
 * @license GPL-3.0-or-later
 *
 * @package solea/views/Profile
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="solea-invoice">

<h3><?php echo esc_html__( 'solea', 'solea' ); ?>
	-
	<?php echo esc_html__( 'Settings', 'solea' ); ?></h3>
<form method="post" action="<?php echo esc_url( admin_url( 'users.php?page=solea-profile' ) ); ?>" onsubmit="return form_filled();">
<input type="hidden" name="sent" value="1" />
<table class="form-table">
	<tr>
		<th><?php echo esc_html__( 'First name', 'solea' ); ?></th>
		<td>
			<input type="text" name="first_name" id="first_name" value="<?php echo esc_attr( $user->first_name ); ?>" class="regular-text" /><br />
		</td>
	</tr>

	<tr>
		<th><?php echo esc_html__( 'Last name', 'solea' ); ?></th>
		<td>
			<input type="text" name="last_name" id="last_name" value="<?php echo esc_attr( $user->last_name ); ?>" class="regular-text" /><br />
		</td>
	</tr>

	<tr>
		<th><?php echo esc_html__( 'Nickname', 'solea' ); ?></th>
		<td>
			<input type="text" name="nickname" value="<?php echo esc_attr( $user->solea_nickname ); ?>" class="regular-text" /><br />
		</td>
	</tr>

	<tr>
		<th><?php echo esc_html__( 'Birthday', 'solea' ); ?></th>
		<td>
			<input type="date" name="birthday" id="birthday" value="<?php echo esc_attr( $user->birthday ); ?>" class="regular-text" /><br />
		</td>
	</tr>

	<tr>
		<th><?php echo esc_html__( 'E-mail address', 'solea' ); ?></th>
		<td>
			<input type="text" name="email" id="email" value="<?php echo esc_attr( $user->user_email ); ?>" class="regular-text" /><br />
		</td>
	</tr>

	<tr>
		<th><?php echo esc_html__( 'Telephone', 'solea' ); ?></th>
		<td>
			<input type="text" name="telephone" id="telephone" value="<?php echo esc_attr( get_the_author_meta( 'telephone', $user->ID ) ); ?>" class="regular-text" /><br />
		</td>
	</tr>

	<tr>
		<th><?php echo esc_html__( 'Local group', 'solea' ); ?></th>
		<td>
			<select name="localgroup" class="regular-text" >
				<?php
				foreach ( $local_groups as $current_group ) {
					?>
							<option value="<?php echo esc_html( $current_group->id ); ?>"
								<?php
								if ( (int) get_the_author_meta( 'localgroup', $user->ID ) === $current_group->id ) {
									echo esc_html( ' selected' );}
								?>
								>
							<?php echo esc_html( $current_group->name ); ?>
							</option>
						<?php
				}

				?>
			</select>
		</td>
	</tr>

	<tr>
		<th><?php echo esc_html__( 'Address', 'solea' ); ?></th>
		<td>
			<input type="text" id="street" style="width: 280px;" name="street" value="<?php echo esc_attr( get_the_author_meta( 'street', $user->ID ) ); ?>" class="regular-text" />
			<input type="text" id="number" style="width: 60px;" name="number" value="<?php echo esc_attr( get_the_author_meta( 'housenumber', $user->ID ) ); ?>" class="regular-text" /><br />
			<input type="text" id="zip" name="zip" style="width: 80px;" value="<?php echo esc_attr( get_the_author_meta( 'zipcode', $user->ID ) ); ?>" class="regular-text" />
			<input type="text" id="city" name="city" style="width: 260px;" value="<?php echo esc_attr( get_the_author_meta( 'city', $user->ID ) ); ?>" class="regular-text" /><br />
		</td>
	</tr>

	<tr>
		<th><?php echo esc_html__( 'Allergies', 'solea' ); ?></th>
		<td>
			<input type="text" name="allergies" value="<?php echo esc_attr( get_the_author_meta( 'allergies', $user->ID ) ); ?>" class="regular-text" /><br />
		</td>
	</tr>

	<tr>
		<th><?php echo esc_html__( 'Food intolerances', 'solea' ); ?></th>
		<td>
			<input type="text" name="intolerances" value="<?php echo esc_attr( get_the_author_meta( 'intolerances', $user->ID ) ); ?>" class="regular-text" /><br />
		</td>
	</tr>

	<tr>
		<th><?php echo esc_html__( 'Medication', 'solea' ); ?></th>
		<td>
			<input type="text" name="medication" value="<?php echo esc_attr( get_the_author_meta( 'medication', $user->ID ) ); ?>" class="regular-text" /><br />
		</td>
	</tr>


</table>
	<input type="submit" class="button" value="<?php echo esc_html__( 'Save changes', 'solea' ); ?>" />
</form>
</div>