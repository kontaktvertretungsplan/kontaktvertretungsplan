<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Du hast gleich
		<small>Cron einrichten</small>
	</h1>
</section>

<!-- Main content -->
<section class="content">
	<div class="box box-success with-border">
		<div class="box-header">
			<h3 class="box-title">Aktivierung</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<p>Über diese URL werden die Nutzer informiert, was sie als nächstes haben</p>
			<p>?lesson=1,2,3</p>
			<h4>URL</h4>
			<pre><?php echo settingGet('url'); ?>next.php?key=<?php echo settingGet('k-v:webhook:next'); ?></pre>
			<h4>Befehl</h4>
			<pre>wget -O - '<?php echo settingGet('url'); ?>next.php?key=<?php echo settingGet('k-v:webhook:next'); ?>' > /dev/null</pre>
		</div>
	</div>
	<!-- /.box -->
	
	<div class="box box-success with-border">
		<!-- form start -->
		<form action="?do=cron:next-save" method="POST">
			<div class="box-body">
			<div class="form-group">
			<label for="key">Schlüssel</label>
			<input type="text" class="form-control" id="key" name="key" placeholder="Schlüssel" value="<?php echo settingGet('k-v:webhook:next'); ?>">
			<p class="help-block">Wenn leer wird ein neuer zufälliger Schlüssel erstellt.</p>
			</div>
			<button type="submit" class="btn btn-success">Speichern</button>
			</div>
			<!-- /.box-body -->
		</form>
	</div>
	<!-- /.box -->
	
	<div class="box with-border">
		<div class="box-header">
			<h3 class="box-title">Info</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<p></p>
		</div>
		<!-- /.box-body -->
	</div>
	<!-- /.box -->
</section>
<!-- /.content -->