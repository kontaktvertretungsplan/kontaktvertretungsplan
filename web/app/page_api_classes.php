<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Klasses
		<small>API</small>
	</h1>
</section>

<!-- Main content -->
<section class="content">
	<div class="box box-success with-border">
		<!-- form start -->
		<form action="?do=api:classes-save" method="POST">
			<div class="box-body">
			<div class="form-group">
			<label for="url">Klassen API URL</label>
			<input type="text" class="form-control" id="url" name="url" placeholder="API URL" value="<?php echo settingGet('k-v:api:classes'); ?>">
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
			<p>Kontakt:Vertretungsplan benötigt die Klasses der Schule, um den Stundenplan ausliefern zu können.</p>
		</div>
		<!-- /.box-body -->
	</div>
	<!-- /.box -->
</section>
<!-- /.content -->