<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo ($PAGE_TITLE ? "$PAGE_TITLE - " : '').$DEFAULT_PAGE_TITLE; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <?php /* */ ?>  
<?php /* OBSOLETE

<!-- Bootstrap 3.3.6 -->
<link rel="stylesheet" href="<?php echo base_url('/assets/static/adminlte/css/bootstrap.min.css'); ?>">
  
<!-- DataTables -->
<!--link rel="stylesheet" href="<?php echo base_url('/assets/static/adminlte/css/dataTables.bootstrap.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('/assets/static/css/datatables.css'); ?>"/-->
<!--link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css"/-->
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/autofill/2.1.3/css/autoFill.bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/buttons/1.2.4/css/buttons.bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/colreorder/1.3.2/css/colReorder.bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/fixedcolumns/3.2.2/css/fixedColumns.bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/keytable/2.2.0/css/keyTable.bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/rowreorder/1.2.0/css/rowReorder.bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/scroller/1.4.2/css/scroller.bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/select/1.2.0/css/select.bootstrap.min.css"/>


  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo base_url('/assets/static/adminlte/css/fontawesome-iconpicker.min.css'); ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- fullCalendar 2.2.5-->
  <!--link rel="stylesheet" href="/assets/src/css/adminlte2/plugins/fullcalendar/fullcalendar.min.css">
  <link rel="stylesheet" href="/assets/src/css/adminlte2/plugins/fullcalendar/fullcalendar.print.css" media="print"-->
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url('/assets/static/adminlte/plugins/select2/select2.min.css'); ?>">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?php echo base_url('/assets/static/adminlte/plugins/iCheck/all.css'); ?>">
  <!-- Pace -->
  <link rel="stylesheet" href="<?php echo base_url('/assets/static/adminlte/plugins/pace/pace.min.css'); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('/assets/static/adminlte/css/AdminLTE.min.css'); ?>">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect.
  -->
  <link rel="stylesheet" href="<?php echo base_url("/assets/static/adminlte/css/skins/_all-skins.min.css"); ?>">
  
  <link rel="stylesheet" href="<?php echo base_url('/assets/static/adminlte/css/admin.pixadelix.css'); ?>">
*/ ?>
<?php
echo enqueued_styles();
?>
<?php /* <!--link rel="shortcut icon" type="image/x-icon" href="/x-favicon.ico"/--> */ ?>
  <link rel="shortcut icon" type="image/x-icon" href="/favico.ico"/>
  
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->



</head>
<?php /*
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
*/ ?>
<body class="hold-transition skin-purple sidebar-mini fixed">
