<div class="content-wrapper">

	<section class="content-header">
		<h1>
			User
			<small>management</small>
		</h1>
		<?php echo isset($bread) ? $bread : null; ?>
	</section>

	<section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box crowded-box box-solid box-darkred">
                    <div class="box-header with-border">
                        <i class="fa fa-users"></i><h3 class="box-title"> Users</h3>
                    </div>
                    <div class="box-body">
                        <table id="users-editor" class="display table table-condensed table-striped table-hover table-bordered" data-page-length="25" style="width:100%">
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            
            <div class="col-md-12">
                <div class="box crowded-box box-solid box-darkred">
                    <div class="box-header with-border">
                        <i class="fa fa-users"></i><h3 class="box-title"> Groups</h3>
                    </div>
                    <div class="box-body">
                        <table id="groups-editor" class="display table table-condensed table-striped table-hover table-bordered" data-page-length="25" style="width:100%">
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>

			
	</section>
	
</div>