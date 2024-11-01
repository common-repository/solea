document.addEventListener('DOMContentLoaded', (event) => {
    document.getElementById('payment_direct').addEventListener('change', function() {
        if (this.checked) {
            document.getElementById('account_owner').style.display='table-row';
            document.getElementById('account_iban').style.display='table-row';

        } else {
            document.getElementById('account_owner').style.display='none';
            document.getElementById('account_iban').style.display='none';
        }
    });


    document.getElementById('event_begin').addEventListener('change', function() {
        registration_end_date = new Date(document.getElementById('event_begin').value);
        last_minute_start_date = new Date(document.getElementById('event_begin').value);
        event_end_date = new Date(document.getElementById('event_begin').value);

        day_in_millisecond = 24 * 60 * 60 * 1000;
        week_in_millisecond = 7 * day_in_millisecond;
        registration_end_date.setTime(registration_end_date.getTime() - week_in_millisecond);
        last_minute_start_date.setTime(last_minute_start_date.getTime() - week_in_millisecond * 2);
        event_end_date.setTime(event_end_date.getTime() + day_in_millisecond * 2);

        document.getElementById('registration_end').value = registration_end_date.toISOString().split('T')[0];
        document.getElementById('event_end').value = event_end_date.toISOString().split('T')[0];
        document.getElementById('last_minute_begin').value = last_minute_start_date.toISOString().split('T')[0];
        document.getElementById('last_minute_begin_group').value = last_minute_start_date.toISOString().split('T')[0];
    });

    document.getElementsByName('amount_teamer')[0].addEventListener('keypress', function(event) {
        const char = String.fromCharCode(event.which);
        if (!/[0-9,]/.test(char)) { event.preventDefault(); }
    });

    document.getElementsByName('amount_volunteer')[0].addEventListener('keypress', function(event) {
        const char = String.fromCharCode(event.which);
        if (!/[0-9,]/.test(char)) { event.preventDefault(); }
    });

    document.getElementsByName('amount_participant')[0].addEventListener('keypress', function(event) {
        const char = String.fromCharCode(event.which);
        if (!/[0-9,]/.test(char)) { event.preventDefault(); }
    });

    document.getElementsByName('amount_others')[0].addEventListener('keypress', function(event) {
        const char = String.fromCharCode(event.which);
        if (!/[0-9,]/.test(char)) { event.preventDefault(); }
    });

    document.getElementsByName('amount_online')[0].addEventListener('keypress', function(event) {
        const char = String.fromCharCode(event.which);
        if (!/[0-9,]/.test(char)) { event.preventDefault(); }
    });

    document.getElementsByName('amount_maximum')[0].addEventListener('keypress', function(event) {
        const char = String.fromCharCode(event.which);
        if (!/[0-9,]/.test(char)) { event.preventDefault(); }
    });

    document.getElementsByName('solidary_amount')[0].addEventListener('keypress', function(event) {
        const char = String.fromCharCode(event.which);
        if (!/[0-9,]/.test(char)) { event.preventDefault(); }
    });

    document.getElementsByName('reduced_amount')[0].addEventListener('keypress', function(event) {
        const char = String.fromCharCode(event.which);
        if (!/[0-9,]/.test(char)) { event.preventDefault(); }
    });

    document.getElementsByName('lastminute_amount_group')[0].addEventListener('keypress', function(event) {
        const char = String.fromCharCode(event.which);
        if (!/[0-9]/.test(char)) { event.preventDefault(); }
    });

    document.getElementsByName('lastminute_amount')[0].addEventListener('keypress', function(event) {
        const char = String.fromCharCode(event.which);
        if (!/[0-9]/.test(char)) { event.preventDefault(); }
    });
});

function solea_solidarity_creation() {
    document.getElementById('solea-payment-change').style.display = 'none';
    document.getElementById('solea-solidarity-registration').style.display = 'block';
    document.getElementById('solea-event_data-registration').style.display = 'block';
    document.getElementById('registration_mode').value='solidarity';
}

function solea_classic_creation() {
    document.getElementById('solea-payment-change').style.display = 'none';
    document.getElementById('solea-event_data-registration').style.display = 'block';
    document.getElementById('solea-classic-registration').style.display = 'block';
    document.getElementById('registration_mode').value='classic';
}

function solea_new_event_form_validator() {
    const fields = ['event_name', 'event_email', 'event_begin', 'event_end', 'registration_end'];

    document.getElementById('iban_field').classList.remove('solea-error');
    document.getElementById('email').classList.remove('solea-error');
    no_errors = solea_check_elements(fields);

    no_errors_2 = true;
    no_errors_3 = true;
    no_errors_4 = true;
    no_errors_5 = true;

    if (document.getElementById('payment_direct').checked) {

        no_errors_2 = solea_check_elements(['account_owner', 'account_iban']);
        no_errors_4 = solea_is_valid_iban(iban = document.getElementById( 'iban_field' ).value);
        if (!no_errors_4) {
            document.getElementById('iban_field').classList.add('solea-error');
        }

        no_errors_5 = solea_is_valid_email(document.getElementById('email').value);
        if (!no_errors_5) {
            document.getElementById('email').classList.add('solea-error');
        }


    }

    if ('solidarity' === document.getElementById('registration_mode').value) {
        no_errors_3 = solea_check_elements(['regular_amount', 'lastminute_amount', 'last_minute_begin']);
    } else {
        no_errors_3 = solea_check_elements(['lastminute_amount_group', 'last_minute_begin_group', 'amount_maximum']);
        if (
            '' === document.getElementsByName('amount_teamer')[0].value &&
            '' === document.getElementsByName('amount_volunteer')[0].value &&
            '' === document.getElementsByName('amount_participant')[0].value &&
            '' === document.getElementsByName('amount_others')[0].value &&
            '' === document.getElementsByName('amount_online')[0].value &&
            '' === document.getElementsByName('amount_teamer')[0].value
        ) {
            document.getElementsByName('amount_participant')[0].classList.add('solea-error')
            no_errors_3 = false;
        } else{
            document.getElementsByName('amount_participant')[0].classList.remove('solea-error')
        }
    }

    start_date = new Date(document.getElementsByName('event_begin')[0].value);
    end_date = new Date(document.getElementsByName('event_end')[0].value);
    registration_end = new Date(document.getElementsByName('registration_end')[0].value);

    if ( end_date < start_date) {
        document.getElementsByName('event_begin')[0].classList.add('solea-error');
        document.getElementsByName('event_end')[0].classList.add('solea-error');
        return false;
    }

    if ( start_date < registration_end) {
        document.getElementsByName('event_begin')[0].classList.add('solea-error');
        document.getElementsByName('registration_end')[0].classList.add('solea-error');
        return false;
    }

    return (no_errors && no_errors_2 && no_errors_3 && no_errors_4 && no_errors_5);
}