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
  <!-- Theme style -->
  <link rel="stylesheet" href="web/dist/css/AdminLTE.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="?">Kontakt:Vertretungsplan</a>
  </div>
  <div class="login-subtitle">
    <p><?php echo $SETTINGS['school:name']; ?></p>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <div id="login-box">
      <p class="login-box-msg"><b>Anmelden, um Einstellungen zu ändern</b></p>

      <form action="web/index2.html" method="post">
        <a id="tg-link" class="btn btn-success btn-block btn-flat btn-lg">Freischalten</a>
      </form>
      <br>
      <ol>
      	<li>Du wirst zu der Telegram App weitergeleitet</li>
      	<li>Klicke auf [START]</li>
      	<li>Klicke auf den Link</li>
      	<li>Ändere deine Einstellungen</li>
      </ol>
      <hr>
      <p class="login-box-msg"><b>Auf diesem Gerät kein Telegram installiert?</b></p>
      <div class="form-group has-success">
        <input id="command" type="text" class="form-control" name="command">
      </div>
      <ol>
      	<li>Nimm ein Gerät mit dem du bei Telegram eingeloggt bist</li>
      	<li>Gehe auf den <?php echo $BOT['username']; ?></li>
      	<li>Schicke den Befehl oben als Nachricht</li>
      	<li>Ändere deine Einstellungen hier</li>
      </ol>

      Noch kein Benutzer? <a href="?info=register" class="text-green">Nutzer werden</a><br>
      <a href="?info=main" class="text-green">Zur Startseite</a>
    </div>
    <div id="error">
      <p class="login-box-msg">Die Session ist abgelaufen.</p>
      <br>
      <a href="?sec=login" class="btn btn-success btn-block btn-flat btn-lg">Neue Session</a>
    
    </div>
  </div>
  <!-- /.login-box-body -->

</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="web/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="web/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script type="text/javascript">

var stopvar = false;
var valid;
var ready;
var session;
function updateQueue() {
	if (stopvar == false) {
	  $.get( "?sec=ajax", function( data ) {
		 //$( "#result" ).html( data );
		
		 var json = JSON.parse( data );
		
		 var valid = json['valid'];
		 var ready = json['ready'];
		 var session = json['session-id'];
		 
		 $('#command').val('/trust ' + session);
		 $('#tg-link').attr('href', 'tg://resolve?domain=<?php echo $BOT["username"]; ?>&start=trust-' + session)
		
		 if (valid == false) {
		 	stopvar = true;
			$('#login-box').fadeOut();
		 }
		 
		 if (ready == true) {
		 	window.location = '?sec=session-start';
		 }
	  });
	}
	
	if ($('#login-box').is(":visible") && $('#error').is(":visible")) {
     $('#error').fadeOut();
   }
   else if ($('#login-box').is(":visible") !== true && $('#error').is(":visible") !== true) {
     $('#error').fadeIn();
   }
	
}


setInterval(function(){ updateQueue(); }, 1000);
</script>
</body>
</html>
