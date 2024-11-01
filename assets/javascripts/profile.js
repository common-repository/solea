function form_filled() {
	no_errors = true;

	if ( ! solea_is_valid_email( document.getElementById( 'email' ).value )) {
		document.getElementById( 'email' ).classList.add( 'solea-error' );
		no_errors = false;
	} else {
		document.getElementById( 'email' ).classList.remove( 'solea-error' );
	}

	if (document.getElementById( 'first_name' ).value == '') {
		document.getElementById( 'first_name' ).classList.add( 'solea-error' );
		no_errors = false;
	} else {
		document.getElementById( 'first_name' ).classList.remove( 'solea-error' );
	}

	if (document.getElementById( 'last_name' ).value == '') {
		document.getElementById( 'last_name' ).classList.add( 'solea-error' );
		no_errors = false;
	} else {
		document.getElementById( 'last_name' ).classList.remove( 'solea-error' );

	}

	if (document.getElementById( 'street' ).value == '') {
		document.getElementById( 'street' ).classList.add( 'solea-error' );
		no_errors = false;
	} else {
		document.getElementById( 'street' ).classList.remove( 'solea-error' );
	}

	if (document.getElementById( 'number' ).value == '') {
		document.getElementById( 'number' ).classList.add( 'solea-error' );
		no_errors = false;
	} else {
		document.getElementById( 'number' ).classList.remove( 'solea-error' );
	}

	if (document.getElementById( 'zip' ).value == '') {
		document.getElementById( 'zip' ).classList.add( 'solea-error' );
		no_errors = false;
	} else {
		document.getElementById( 'zip' ).classList.remove( 'solea-error' );
	}

	if (document.getElementById( 'city' ).value == '') {
		document.getElementById( 'city' ).classList.add( 'solea-error' );
		no_errors = false;
	} else {
		document.getElementById( 'city' ).classList.remove( 'solea-error' );
	}

	if (document.getElementById( 'birthday' ).value == '') {
		document.getElementById( 'birthday' ).classList.add( 'solea-error' );
		no_errors = false;
	} else {
		document.getElementById( 'birthday' ).classList.remove( 'solea-error' );
	}

	return no_errors;
}