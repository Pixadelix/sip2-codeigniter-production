<?php


$message_text  = isset($message) ? $message[0] : null;
$message_type  = isset($message) ? $message[1] : null;
$message_title = isset($message) ? $message[2] : 'Info Message';

?>

</div>
<!-- ./wrapper -->

  <div class="message-modal">
	<div class="modal" id="message-modal">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title"><?php echo $message_title; ?></h4>
		  </div>
		  <div class="modal-body">
			<p><?php echo $message_text; ?></p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
		  </div>
		</div>
		<!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
  </div>
  <!-- /.message-modal -->		
<?php /* OBSOLETE 
<!-- REQUIRED JS SCRIPTS -->
<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url('/assets/static/adminlte/js/jquery-2.2.3.min.js'); ?>"></script>
 
<!--script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script-->
<!--script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script-->
<script type="text/javascript" src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/autofill/2.1.3/js/dataTables.autoFill.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/autofill/2.1.3/js/autoFill.bootstrap.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.2.4/js/buttons.bootstrap.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/colreorder/1.3.2/js/dataTables.colReorder.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/fixedcolumns/3.2.2/js/dataTables.fixedColumns.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/fixedheader/3.1.2/js/dataTables.fixedHeader.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/keytable/2.2.0/js/dataTables.keyTable.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/responsive/2.1.0/js/responsive.bootstrap.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/rowreorder/1.2.0/js/dataTables.rowReorder.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/scroller/1.4.2/js/dataTables.scroller.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>
<?php /* 
<!-- DataTables -->
<script src="<?php echo base_url('/assets/static/adminlte/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('/assets/static/adminlte/js/dataTables.bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('/assets/static/js/datatables.js'); ?>"></script>

<script src="//momentjs.com/downloads/moment-with-locales.min.js"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.13/dataRender/datetime.js"></script>

<!-- IMG Previewer -->
<script src="<?php echo base_url('/assets/static/adminlte/js/imgpreview.jquery.js'); ?>"></script>
<script src="<?php echo base_url('/assets/static/adminlte/js/yoxview/yoxview-init.js'); ?>"></script>

<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url('/assets/static/adminlte/js/bootstrap.min.js'); ?>"></script>
<!-- jQuery UI 1.11.4 -->
<script src='https://code.jquery.com/ui/1.11.4/jquery-ui.min.js'></script>
<!-- Select2 -->
<script src="<?php echo base_url('/assets/static/adminlte/plugins/select2/select2.full.min.js'); ?>"></script>
<!-- Slimscroll -->
<script src="<?php echo base_url('/assets/static/adminlte/plugins/slimScroll/jquery.slimscroll.min.js'); ?>"></script>
<!-- FastClick -->
<script src="<?php echo base_url('/assets/static/adminlte/plugins/fastclick/fastclick.js'); ?>"></script>
<!-- iCheck -->
<script src="<?php echo base_url('/assets/static/adminlte/plugins/iCheck/icheck.min.js'); ?>"></script>
<!-- Pace -->
<script src="<?php echo base_url('/assets/static/adminlte/plugins/pace/pace.min.js'); ?>"></script>
<!-- fontawesome-iconpicker.min -->
<script src="<?php echo base_url('/assets/static/adminlte/js/fontawesome-iconpicker.js'); ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('/assets/static/adminlte/js/app.js'); ?>"></script>

<script src="<?php echo base_url('/assets/static/js/jstree/jstree.min.js'); ?>"></script>

<script src="<?php echo base_url('/assets/static/adminlte/js/admin.pixadelix.js'); ?>"></script>
*/ ?>

 
<?php
echo enqueued_scripts();
echo enqueued_resources();
?>
<script>
;  $(function () {
/*	
	$('.btn-go-back').click(function() {
		window.history.back();
	});
	
    $('.data-grid').DataTable({
      "columnDefs": [ {
		  "targets"  : 'no-sort',
		  "orderable": false } ],
      "paging": true,
      "lengthChange": true,
      "searching": true,
	  "select": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
	  "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
	  "iDisplayLength": 25,
	  "responsive": true,
	  "fixedHeader": true,
	  
    });
	
	$('.yoxview').yoxview();

	
	
		$('a.img-preview').each(function() {
			$( this ).imgPreview({
				containerID: 'preview-container',
				imgCSS: {
					// Limit preview size:
					height: 200
				},
				// When container is shown:
				onShow: function(link){
					$('<span>' + $(link).text() + '</span>').appendTo(this);
				},
				// When container hides: 
				onHide: function(link){
					$('span', this).remove();
				}
			});
		});
	

	
	//iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
		checkboxClass: 'icheckbox_minimal-blue',
		radioClass: 'iradio_minimal-blue'
    });
	
	*/
	$info_message = <?php echo trim_all($message_text) ? 1 : 0; ?>;
	if($info_message){
		
		$msg = <?php echo json_encode($message); ?>;
		debug($msg);
		
		$message_text  = $msg[0];
		$message_type  = $msg[1];
		$message_title = $msg[2];
		
		//$('#message-modal').addClass('<?php echo $message_type; ?>').modal();
		$.confirm({
			title: $message_title,
			content: $message_text,
			theme: 'supervan ' + $message_type,
			backgroundDismiss: true,
			backgroundDismissAnimation: 'shake',
			buttons: {
				Close: {
					
				}
			}
		});
	}

});

</script>

</body>
</html>