<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Nachricht
		<small>Nachricht senden</small>
	</h1>
</section>

<!-- Main content -->
<section class="content">
	<div class="box box-success with-border">
		<!-- form start -->
		<form action="?do=mod:broadcast-send" method="POST">
			<div class="box-body">
			<div class="form-group">
				<label for="classes">An diese Klassen</label>
				<select class="form-control select2" multiple="multiple" id="classes" name="classes[]" data-placeholder="Klassen" style="width: 100%;">
					<?php
						$statement = $PDO->prepare("SELECT ID, name FROM class ORDER BY name");
						$statement->execute();
						foreach($statement->fetchAll() as $class) {
							echo '<option value="'.$class['ID'].'" selected>'.$class['name'].'</option>';
						}
					?>
				</select>
			</div>
			<!-- /.form-group -->
			<div class="form-group">
			<label for="message">Nachricht</label>
			<textarea class="form-control" rows="5" id="message" name="message" placeholder="Nachricht"><?php echo $result['mute']; ?></textarea>
			</div>
			<button type="submit" class="btn btn-success">Senden</button>
			</div>
			<!-- /.box-body -->
		</form>
	</div>
	<!-- /.box -->
</section>
<!-- /.content -->

<?php $JS_ADDON = '$(".select2").select2()'; ?>