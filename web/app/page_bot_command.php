<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Befehle
		<small>Steuerung des Bots</small>
	</h1>
</section>

<!-- Main content -->
<section class="content">
	<div class="box box-success with-border">
		<div class="box-header">
			<h3 class="box-title">Alle Befehle</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<p>Befehle zu kopieren in den BotFather</p>
			<pre>
<?php

$out = '';

$com = $COMMANDS;

ksort($com);

foreach($com['command'] as $c => $p) {
	if($PLUGINS[$p]['description'] != '') {
		$desc = ' - '.$PLUGINS[$p]['description'];
	}
	else {
		$desc = '';
	}
	$out .= $c.$desc.'
';
}

echo trim($out);

?>
			</pre>
		</div>
	</div>
	<!-- /.box -->
</section>
<!-- /.content -->