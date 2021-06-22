//<script><?php restricted('flipmag'); ?>
    
(function ($, window, undefined) {
    
    $('.flipmag a').on('click', function(e) {
        var url = $(this).attr('href');
        var title = $(this).data('title');
        //debug(url);
        e.preventDefault();
        $.confirm({
            icon: 'fa fa-book',
            title: title,
            theme: 'supervan blue',
            columnClass: 'col-md-12',
            backgroundDismiss: true,
            buttons: {
                Close: {
                    
                }
            },
            content: function() {
                var self = this;
                
                return $.ajax({
                    url: url,
                    method: 'get',
                }).done( function ( res ) {
                    self.setContentPrepend(
                        '<div style="width: 100%; height: calc(60vh);"><table style="width: 100%; height: 100%;"><tbody><tr><td style="height: 100%; overflow: visible;">'+
                        '<iframe src="'+url+'" width="100%" height="100%" style="width: 100%; height: 100%; overflow: visible;"></iframe>'+
                        '</td></tr></tbody></table></div>'
                    );
                });
            }
        });
        
    });
    

})(jQuery, window);