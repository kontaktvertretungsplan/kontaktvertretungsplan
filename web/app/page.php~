<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Kontakt:Vertretungsplan | milchinsel.de</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="web/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="web/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="web/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="web/bower_components/select2/dist/css/select2.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="web/plugins/iCheck/minimal/green.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="web/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="web/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="web/dist/css/skins/skin-green.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
<!-- the fixed layout is not compatible with sidebar-mini -->
<body class="hold-transition skin-green fixed sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="?p=main" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">K<b>:</b>V</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">K:Vertretungsplan</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Control Sidebar Toggle Button -->
          <li class="user user-menu">
            <a href="#" data-toggle="control-sidebar">
              <i class="fa fa-user-circle-o" aria-hidden="true"></i>
              <span><?php echo $USER_INFO['name']; ?></span></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">ALLGEMEIN</li>
        <li>
          <a href="?p=main">
            <i class="fa fa-th"></i> <span>Übersicht</span>
            <span class="pull-right-container">
              
            </span>
          </a>
        </li>
        <li class="header">EINSTELLUNGEN</li>
        <li>
          <a href="?p=class">
            <i class="fa fa-calendar"></i> <span>Klassen</span>
            <span class="pull-right-container">
              
            </span>
          </a>
        </li>
        <li>
          <a href="?p=notification">
            <i class="fa fa-bell"></i> <span>Benachrichtigung</span>
            <span class="pull-right-container">
              
            </span>
          </a>
        </li>
        <?php if(isRole('mod')): ?>
        <li class="header">MODERATION</li>
        <li>
          <a href="?p=mod:broadcast">
            <i class="fa fa-comment"></i> <span>Nachricht</span>
            <span class="pull-right-container">
              
            </span>
          </a>
        </li>
        <?php endif; ?>
        <?php if(isRole('admin')): ?>
        <li class="header">ADMINISTRATION</li>
        <li>
          <a href="?p=admin:user">
            <i class="fa fa-users"></i> <span>Benutzer</span>
            <span class="pull-right-container">
              
            </span>
          </a>
        </li>
        <li>
          <a href="?p=admin:password">
            <i class="fa fa-key"></i> <span>Passwort</span>
            <span class="pull-right-container">
              
            </span>
          </a>
        </li>
        <li>
          <a href="?p=admin:settings">
            <i class="fa fa-cogs"></i> <span>Einstellungen</span>
            <span class="pull-right-container">
              
            </span>
          </a>
        </li>
        <?php endif; ?>
        <?php if(isRole('api')): ?>
        <li class="header">API</li>
        <li>
          <a href="?p=api:timetable">
            <i class="fa fa-chain"></i> <span>Stundenplan</span>
            <span class="pull-right-container">
              
            </span>
          </a>
        </li>
        <li>
          <a href="?p=api:classes">
            <i class="fa fa-chain"></i> <span>Klassen</span>
            <span class="pull-right-container">
              
            </span>
          </a>
        </li>
        <?php endif;?>
        <?php if(isRole('cron')): ?>
        <li class="header">CRON</li>
        <li>
          <a href="?p=cron:timetable">
            <i class="fa fa-refresh"></i> <span>Stundenplan</span>
            <span class="pull-right-container">
              
            </span>
          </a>
        </li>
        <li>
          <a href="?p=cron:next">
            <i class="fa fa-refresh"></i> <span>Du hast gleich</span>
            <span class="pull-right-container">
              
            </span>
          </a>
        </li>
        <li>
          <a href="?p=cron:class">
            <i class="fa fa-refresh"></i> <span>Klassen</span>
            <span class="pull-right-container">
              
            </span>
          </a>
        </li>
        <?php endif;?>
        <?php if(isRole('bot')): ?>
        <li class="header">BOT</li>
        <li>
          <a href="?p=bot:info">
            <i class="fa fa-telegram"></i> <span>Info</span>
            <span class="pull-right-container">
              
            </span>
          </a>
        </li>
        <?php endif;?>
        <?php if(isRole('stat')): ?>
        <li class="header">STATISTIK</li>
        <li>
          <a href="?p=stat:log">
            <i class="fa fa-area-chart"></i> <span>Log</span>
            <span class="pull-right-container">
              
            </span>
          </a>
        </li>
        <?php endif;?>
        <li class="header">WEITERES</li>
        <li><a href="https://kontakt-vertretungsplan.de"><i class="fa fa-home"></i> <span>Homepage</span></a></li>
        <li><a href="https://kontakt-vertretungsplan.de/wiki/bug"><i class="fa fa-bug"></i> <span>Fehler melden</span></a></li>
        <!--<li><a href="?info=info"><i class="fa fa-gavel"></i> <span>Impressum & Datenschutz</span></a></li>-->
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php
    $page = explode(':', $ACTION_PAGE);
    if(count($page) == 2) {
		if(isRole($page[0])) {
   		include("web/app/page_".validPath($page[0])."_".validPath($page[1]).".php");
   	}
   	else {
   		include("web/app/page_error_access-denied.php");
		}
    }
    else {
    	include("web/app/page_".validPath($page[0]).".php");
    }
    ?>
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2018 <a href="https://milchinsel.de">milchinsel.de</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <div class="user-panel">
      <div class="pull-left">
        <i class="fa fa-user-circle-o fa-4x" style="color: white;" aria-hidden="true"></i>
      </div>
      <div class="pull-left info">
        <p><?php echo $USER_INFO['name']; ?></p>
        tuid:<?php echo $USER_INFO['telegram-id']; ?><br>
      </div>
    </div>
    <div class="tab-content">
	    <ul>
	      <li>user</li>
	    <?php
	      foreach($USER_INFO['role'] as $role) {
	      	echo '<li>'.$role.'</li>';
	      }
	    ?>
	    </ul>
	    <a href="?do=logout" class="btn bg-green btn-flat margin pull-right">Abmelden</a>
	    <br>
	    <br>
	    <h3 class="control-sidebar-heading">Schule</h3>
	    <?php echo $SETTINGS['school:name']; ?>
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="web/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="web/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="web/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="web/plugins/iCheck/icheck.min.js"></script>
<!-- DataTables -->
<script src="web/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="web/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- FLOT CHARTS -->
<script src="web/bower_components/Flot/jquery.flot.js"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="web/bower_components/Flot/jquery.flot.resize.js"></script>
<!-- SlimScroll -->
<script src="web/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- AdminLTE App -->
<script src="web/dist/js/adminlte.min.js"></script>

<script>

$(document).ready(function(){
  $('input[type="checkbox"], input[type="radio"]').iCheck({
    checkboxClass: 'icheckbox_minimal-green',
    radioClass: 'iradio_minimal-green',
    increaseArea: '20%' // optional
  });
});
</script>

<script type="text/javascript">
<?php echo $JS_ADDON; ?>
</script>

</body>
</html>
