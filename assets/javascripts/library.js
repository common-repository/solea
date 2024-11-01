function solea_check_elements(fields) {
	let no_errors = true;

	fields.forEach(
		function (field) {
			let element = document.getElementsByName( field )[0];

			if ( ! element) {
				console.error( `Element with name "${field}" not found.` );
				no_errors = false;
				return; // Skip to the next field
			}

			if (element.value.trim() === '') {
				no_errors = false;
				element.classList.add( 'solea-error' );
			} else {
				element.classList.remove( 'solea-error' );
			}
		}
	);

	return no_errors;
}

function solea_is_valid_iban(iban) {
	iban = iban.replace( /\s+/g, '' ).toUpperCase();

	if (iban.length !== 22) {
		return false;
	}

	if ( ! iban.startsWith( 'DE' )) {
		return false;
	}

	iban = iban.slice( 4 ) + iban.slice( 0, 4 );

	const convertedIban = iban.split( '' ).map(
		char => {
        const code  = char.charCodeAt( 0 );
        return code >= 65 && code <= 90 ? (code - 55).toString() : char;
		}
	).join( '' );

	let remainder = convertedIban;
	while (remainder.length > 2) {
		const block = remainder.slice( 0, 9 );
		remainder   = (parseInt( block, 10 ) % 97).toString() + remainder.slice( 9 );
	}

	return parseInt( remainder, 10 ) % 97 === 1;
}

function solea_is_valid_email(email) {
	// Einfache RegEx, um eine E-Mail-Adresse zu validieren
	const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

	// Teste die E-Mail-Adresse gegen die RegEx
	return emailRegex.test( email );
}
