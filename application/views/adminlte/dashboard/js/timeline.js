


(function ($, window, undefined) {
	debug('app/dashboard/timeline.js loaded');

	function refresh_timeline() {
		var timeline = $('#timeline');
		timeline
			.removeClass('timeline')
			.addClass('loading-container')
			.html('<center><i class="fa fa-spin fa-refresh"></i> Loading data, please wait...</center>');
		$.ajax({
			url: '/dashboard/dashboard/get_timeline',
			dataType: 'json',
			success: function ( response ) {
				var tmpl = $.templates('#timeline-template');
				var html = tmpl.render(response);

				timeline
					.removeClass('loading-container')
					.addClass('timeline')
					.html(html);
			}
		})
		
	}
	
	refresh_timeline();
    
    $('.btn-timeline').on('click', function() { refresh_timeline() });
	
	
})(jQuery, window);