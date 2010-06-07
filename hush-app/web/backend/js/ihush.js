(function($){

	// TODO : Add ihush app javascript here ...
	
	$.form = {
		confirm: function (url, msg) {
			if (confirm(msg)) {
				location.href = encodeURI(url);
			}
		}
	}
	
})(jQuery);