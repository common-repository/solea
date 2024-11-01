function solea_print_list(listtype, event_id) {
	solea_load_ajax_nw( 'print-list', 'list-type=' + listtype + '&event-id=' + event_id )
}
