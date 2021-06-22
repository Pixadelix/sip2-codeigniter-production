

(function ($, window, undefined) {
	debug('app/dashboard/notification.js loaded');
	
	$.views.converters("upper", function(val) {
		if(!val) return;
		return val.toUpperCase();
	});
	
	$.views.converters("ldate", function(val, fmt = 'DD/MMM/YYYY HH:mm') {
		if(!val) return;
		return moment(val).format(fmt)
	});
	
	function refresh_notif_task() {

		var task_list = $('#task-list');
		task_list.empty();
		task_list.addClass('loading-container').html('<i class="fa fa-spin fa-refresh"></i> Loading data, please wait...');
		
		var btn_refresh = $('#btn-refresh-notif-task');
		btn_refresh.empty();
		btn_refresh.html('<i class="fa fa-spin fa-refresh"></i>');		

		$.ajax({
			url: '/get_task_notification',
			dataType: 'json',
			success: function ( response ) {
				
				var tmpl = $.templates('#task-list-template');
				var html = tmpl.render( response );
				task_list.removeClass('loading-container')
					.html(html);
				
				$('#task-total').html(response.length);
				btn_refresh.html('<i class="fa fa-refresh"></i>');
					
				$('#task-last-update').html(moment(new Date()).format("DD/MM/YYYY HH:mm:ss"));
			},
			error: function ( response ) {
				task_list
					.html('ERROR: '+response.responseJSON.err_msg);
				btn_refresh.html('<i class="fa fa-refresh"></i>');
			}
		});
	}
	
	$('#refresh-notif-task').on('click', function(e) {
		//debug($(this));
		if($(this).parent().hasClass('open')) {
			e.stopPropagation();
		}
		refresh_notif_task();
	});
	
	$('#btn-refresh-notif-task').on('click', function(e) {
		e.stopPropagation();
		refresh_notif_task();
		
	});
	
	
	
	
})(jQuery, window);