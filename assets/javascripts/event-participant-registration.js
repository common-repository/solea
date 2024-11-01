let currentStep = 1;
const form      = document.getElementById( 'multi-step-form' );
const steps     = document.querySelectorAll( '.step' );


function solea_format_amount(plain_amount) {
	var float_value     = parseFloat( plain_amount );
	var formatted_value = float_value.toLocaleString( 'de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 } );
	return formatted_value + ' Euro';

}

function solea_calc_total_amount(current_amount_type)
{
	if ('1' === solea_event.solidarity_event) {
		if ('regular' === current_amount_type) {
			document.getElementById( 'solea_amount' ).value = solea_event.amount_participant;
			formatted_amount                                = solea_format_amount( solea_event.amount_participant );
		}

		if ('reduced' === current_amount_type) {
			document.getElementById( 'solea_amount' ).value = solea_event.amount_reduced;
			formatted_amount                                = solea_format_amount( solea_event.amount_reduced );
		}

		if ('social' === current_amount_type) {
			document.getElementById( 'solea_amount' ).value = solea_event.amount_social;
			formatted_amount                                = solea_format_amount( solea_event.amount_social );
		}
		document.getElementById( 'total_amount' ).innerHTML = formatted_amount;
	} else {
		if ('participant' === current_amount_type) {
			document.getElementById( 'solea_amount' ).value = solea_event.amount_participant;
		}
		if ('volunteer' === current_amount_type) {
			document.getElementById( 'solea_amount' ).value = solea_event.amount_volunteer;
		}
		if ('team' === current_amount_type) {
			document.getElementById( 'solea_amount' ).value = solea_event.amount_team;
		}
		if ('other' === current_amount_type) {
			document.getElementById( 'solea_amount' ).value = solea_event.amount_other;
		}
		if ('online' === current_amount_type) {
			document.getElementById( 'solea_amount' ).value = solea_event.amount_online;
		}
	}
}

function checkAnsprechpartner() {
	var errors = false;

	var ids = ['ansprechpartner', 'telefon_2','email_2'];

	for (var idx = 0; idx < ids.length; idx++) {
		var currentElement = ids[idx];

		if (document.getElementById( currentElement ).value == '') {
			document.getElementById( currentElement ).style.backgroundColor = "#fd9393";
			document.getElementById( currentElement ).style.color           = "red";
			errors = true;
		} else {
			document.getElementById( currentElement ).style.backgroundColor = "#ffffff";
			document.getElementById( currentElement ).style.color           = "#c0c0c0";
		}
	}

	if ( ! errors) {
		showStep( 3 );
	}
}

function checkAnreise() {
	var errors = false;

	var ids = ['anreise', 'abreise'];

	for (var idx = 0; idx < ids.length; idx++) {
		var currentElement = ids[idx];

		if (document.getElementById( currentElement ).value == '') {
			document.getElementById( currentElement ).style.backgroundColor = "#fd9393";
			document.getElementById( currentElement ).style.color           = "red";
			errors = true;
		} else {
			document.getElementById( currentElement ).style.backgroundColor = "#ffffff";
			document.getElementById( currentElement ).style.color           = "#c0c0c0";
		}
	}

	if (errors) {
		return;
	}

	var anreise = new Date( document.getElementById( 'anreise' ).value );
	var abreise = new Date( document.getElementById( 'abreise' ).value );

	if (abreise < anreise) {
		document.getElementById( 'anreise' ).style.backgroundColor = "#fd9393";
		document.getElementById( 'anreise' ).style.color           = "red";
		document.getElementById( 'abreise' ).style.backgroundColor = "#fd9393";
		document.getElementById( 'abreise' ).style.color           = "red";
		return;
	}

	if (anreise < new Date( solea_event.event_start )) {
		document.getElementById( 'anreise' ).style.backgroundColor = "#fd9393";
		document.getElementById( 'anreise' ).style.color           = "red";
		errors = true;
	} else {
		document.getElementById( 'anreise' ).style.backgroundColor = "#ffffff";
		document.getElementById( 'anreise' ).style.color           = "#c0c0c0";
	}

	if (abreise > new Date( solea_event.event_end )) {
		document.getElementById( 'abreise' ).style.backgroundColor = "#fd9393";
		document.getElementById( 'abreise' ).style.color           = "red";
		errors = true;
	} else {
		document.getElementById( 'abreise' ).style.backgroundColor = "#ffffff";
		document.getElementById( 'abreise' ).style.color           = "#c0c0c0";
	}

	if ( ! errors) {
		days = (abreise - anreise) / 86400 / 1000;
		days = days + 1;
		if ('1' !== solea_event.solidarity_event) {
			document.getElementById( 'total_amount' ).innerHTML = solea_format_amount( document.getElementById( 'solea_amount' ).value * days );
		}
		showStep( 6 );
	}
}


function checkAddress() {
	var errors = false;

	var ids = ['vorname', 'nachname','geburtsdatum', 'email_1', 'strasse', 'hausnummer', 'plz', 'ort'];

	for (var idx = 0; idx < ids.length; idx++) {
		var currentElement = ids[idx];

		if (document.getElementById( currentElement ).value == '') {
			document.getElementById( currentElement ).style.backgroundColor = "#fd9393";
			document.getElementById( currentElement ).style.color           = "red";
			errors = true;
		} else {
			document.getElementById( currentElement ).style.backgroundColor = "#ffffff";
			document.getElementById( currentElement ).style.color           = "#c0c0c0";
		}
	}

	if ( ! errors) {
		showStep( 4 );
	}
}

function solea_accept_all_permissions() {

	document.getElementById( 'foto_socialmedia' ).checked = true;
	document.getElementById( 'foto_print' ).checked       = true;
	document.getElementById( 'foto_webseite' ).checked    = true;
	document.getElementById( 'foto_partner' ).checked     = true;
	document.getElementById( 'foto_intern' ).checked      = true;
	showStep( 8 );
}

function showStep(stepNumber) {

	if ('1' !== solea_event.solidarity_event && stepNumber == 6) {
		stepNumber++;
	}

	steps.forEach( step => step.style.display = 'none' );
	document.getElementById( `step${stepNumber}` ).style.display = 'block';
}

function nextStep() {
	if (currentStep < steps.length) {
		currentStep++;
		showStep( currentStep );
	}
}

function solea_validationCheck()
{
	if ( ! document.getElementById( 'dsgvo_accept' ).checked) {
		document.getElementById( 'dsgvo_text' ).classList.add( 'dsgvo_error' );
	} else {
		document.getElementById( 'dsgvo_text' ).classList.remove( 'dsgvo_error' );
	}

	if ( ! document.getElementById( 'amount_accept' ).checked) {
		document.getElementById( 'amount_text' ).classList.add( 'dsgvo_error' );
	} else {
		document.getElementById( 'amount_text' ).classList.remove( 'dsgvo_error' );
	}

	var ids = ['vorname', 'nachname','geburtsdatum', 'email_1', 'anreise', 'abreise', 'strasse', 'hausnummer', 'plz', 'ort'];

	for (var idx = 0; idx < ids.length; idx++) {
		var currentElement = ids[idx];
		if (document.getElementById( currentElement ).value == '') {
			return false;
		}
	}

	var anreise = new Date( document.getElementById( 'anreise' ).value );
	var abreise = new Date( document.getElementById( 'abreise' ).value );

	if (anreise < new Date( '{{startdate}}' )) {
		return false;
	}

	if (abreise > new Date( '{{enddate}}' )) {
		return false;
	}

	if ( ! document.getElementById( 'dsgvo_accept' ).checked) {
		document.getElementById( 'dsgvo_text' ).classList.add( 'dsgvo_error' );
	}

	return (document.getElementById( 'dsgvo_accept' ).checked && document.getElementById( 'amount_accept' ).checked);

}

showStep( currentStep );