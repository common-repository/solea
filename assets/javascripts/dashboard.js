function solea_load_participant_data(data_id) {
	document.getElementById( 'solea-participant-box' ).style.display = 'block';
	document.getElementById( 'solea_hider' ).style.display           = 'block';
	solea_load_ajax_div( 'print-participant', 'solea-participant-box-content', 'participant-id=' + data_id )
}

function solea_hide()  {
	document.getElementById( 'solea-participant-box' ).style.display            = 'none';
	document.getElementById( 'solea-update_amount-box' ).style.display          = 'none';
	document.getElementById( 'solea-unregister_participant-box' ).style.display = 'none';
	document.getElementById( 'solea_hider' ).style.display                      = 'none';
}

function solea_update_amount(participant_id, amount) {
	document.getElementById( 'solea-update_amount-box' ).style.display = 'block';
	document.getElementById( 'solea_hider' ).style.display             = 'block';
	document.getElementById( 'participant_id' ).value                  = participant_id;
	document.getElementById( 'amount_paid' ).value                     = amount;
}

function solea_unregister_participant(participant_id, amount) {
	document.getElementById( 'solea-unregister_participant-box' ).style.display = 'block';
	document.getElementById( 'solea_hider' ).style.display                      = 'block';
	document.getElementById( 'participant_id_signoff' ).value                   = participant_id;
	document.getElementById( 'amount_paid' ).value                              = amount;
}