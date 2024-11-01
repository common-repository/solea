function solea_generate_ajax_url(ajaxmethode, params) {
	return ajaxurl + '?action=solea_show_ajax&&method=' + ajaxmethode + '&' + params;
}
function solea_load_ajax_nw(ajaxmethode, params='') {
	ajaxurl = solea_generate_ajax_url( ajaxmethode, params );
	window.open( ajaxurl );
}

function solea_load_ajax_div( ajaxmethode, targetid, params = '') {
	var xhr                = new XMLHttpRequest();
	xhr.onreadystatechange = function () {
		if (xhr.readyState === XMLHttpRequest.DONE) {
			if (xhr.status === 200) {
				document.getElementById( targetid ).innerHTML = xhr.responseText;
			};
		}
	}
		var scriptcall     = solea_generate_ajax_url( ajaxmethode, params );
		xhr.open( 'GET', scriptcall, true );
		xhr.send();

}