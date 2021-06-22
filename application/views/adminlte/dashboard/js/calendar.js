

document.addEventListener('DOMContentLoaded',function(){

	(function ($, window, undefined) {
		debug('app/dashboard/calendar.js loaded');

		$('#calendar').fullCalendar({
			schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
			//now: '<?php echo date_format(date_create(), 'Y-m-d'); ?>',
			now: function () { return new Date(); },
			editable: false, // enable draggable events
			//aspectRatio: 1.8,
			scrollTime: '00:00', // undo default 6am scrollTime
			locale: 'id',
			columnFormat: 'dddd',
			minTime: '07:30',
			maxTime: '23:00',
			
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,timelineDay'
			},
			buttonIcons: {
				today: 'fa fa-calendar',
				
				prev: 'fa fa-angle-left',
				next: 'fa fa-angle-right',
				prevYear: 'left-double-arrow',
				nextYear: 'right-double-arrow'
			},
			uttonText: {
				month: 'Bulan',
				agendaWeek: 'Minggu',
				timelineDay: 'Hari',
			},
			
			theme: false,
			
			aspectRatio: 0.75,
			contentHeight: 'auto',
			defaultView: 'month',
			timeFormat: 'H:mm',
			allDay: false,
			windowResize: function(view) {
				//debug(view);
			},

			views: {
				timelineThreeDays: {
					type: 'timeline',
					duration: { days: 3 }
				}
			},

			timezone: 'local',
			resourceLabelText: 'Resources',
			resources: '/dashboard/calendar/resources',
			googleCalendarApiKey: 'AIzaSyDZNcsmmVazF1S3VJicnjRD7s_VV_GApIo',
			eventSources: [
				{
					url: '/dashboard/calendar/events',
					success: function ( response ) {
						
					}
				},
				{
					googleCalendarId: 'en.indonesian#holiday@group.v.calendar.google.com',
					className: 'gcal-holiday-event'
				},
				{
					googleCalendarId: 'en.usa#holiday@group.v.calendar.google.com',
					className: 'gcal-us-holiday-event'
				}
			],
			
			eventRender: function(event, element, view) {
				/*
				var title = $('.fc-time', element);
				//debug(title);
				title.on('touchstart', function(e) {
					e.preventDefault();
					//debug(e);
				});
				*/
				
				element.qtip({
					content: {
						title: event.title,
						text: event.description
					},
					position: {
						viewport: $(window),
						my: 'bottom left',
						at: 'top left',
					},
					show: {
						event: 'touchstart mouseover',
					},
					hide: {
						event: 'unfocus mouseleave',
					}
				});
				
				
				
				var ntoday = new Date().getTime();
				var eventStart = moment( event.start ).valueOf();
				var eventEnd = moment( event.end ? event.end : event.start ).valueOf();
				//debug(eventEnd+' < '+ntoday+' '+(eventEnd < ntoday)+' '+event.title);

				if(event.start) {
					if (eventEnd < ntoday){
						element.addClass("past-event");
						element.children().addClass("past-event");
					}
				}
				
				if ( event.allDay === true ) {
					element.addClass("allday-event");
					element.children().addClass("allday-event");
				}
			}
		});
		
		
	})(jQuery, window);
	
});