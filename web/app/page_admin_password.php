<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Passwort
		<small>Zugangssperre</small>
	</h1>
</section>

<!-- Main content -->
<section class="content">
	<div class="box box-success with-border">
		<!-- form start -->
		<form action="?do=admin:password-save" method="POST">
			<div class="box-body">
			<div class="form-group">
			<label for="password">Passwort</label>
			<input type="text" class="form-control" id="password" name="password" placeholder="Passwort" value="<?php echo settingGet('password'); ?>">
			</div>
			<button type="submit" class="btn btn-success">Speichern</button>
			</div>
			<!-- /.box-body -->
		</form>
	</div>
	<!-- /.box -->
	
	<div class="box with-border">
		<div class="box-header with-border">
			<h3 class="box-title">Info</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<p>Das Passwort wird beim ersten aufrufen des Bots abgefragt.<br>Es stellt eine <b>rudimentäre</b> Sicherheitsfunktion dar.</p>
		</div>
		<!-- /.box-body -->
	</div>
	<!-- /.box -->
</section>
<!-- /.content -->