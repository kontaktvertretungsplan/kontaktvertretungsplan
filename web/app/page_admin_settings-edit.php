<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Bearbeiten
		<small>Einstellungen frei bearbeiten</small>
	</h1>
</section>

<!-- Main content -->
<section class="content">
	<div class="box box-success with-border">
		<!-- form start -->
		<form action="?do=admin:settings-save" method="POST">
			<div class="box-body">
			<div class="form-group">
			<label for="name">Name</label>
			<input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?php echo $_GET['name']; ?>">
			</div>
			<div class="form-group">
			<label for="value">Wert</label>
			<textarea class="form-control" rows="5" id="value" name="value" placeholder="Wert"><?php echo settingGet($_GET['name']); ?></textarea>
			</div>
			<button type="submit" class="btn btn-success">Speichern</button>
			</div>
			<!-- /.box-body -->
		</form>
	</div>
	<!-- /.box -->
</section>
<!-- /.content -->