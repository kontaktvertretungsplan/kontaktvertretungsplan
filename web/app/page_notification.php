<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Benachrichtigungen
		<small>Nachrichten verwalten</small>
	</h1>
</section>
	
<!-- Main content -->
<section class="content">
	<!-- Default box -->
	<div class="box box-success with-border">
		<div class="box-body">
			<form action="?do=notification-save" method="POST">
				<!-- Custom Tabs (Pulled to the right) -->
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs pull-right">
						<li><a id="tab-button-plan" href="#notification_plan" data-toggle="tab">Pläne</a></li>
						<li class="active"><a id="tab-button-mute" href="#notification_mute" data-toggle="tab">Stumm</a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="notification_mute">
							<?php
								$statement = $PDO->prepare("SELECT mute FROM user WHERE ID = ?");
								$statement->execute([$USER_INFO['id']]);
								$mute = $statement->fetch();
								$mute = $mute['mute'];
								$mute = json_decode($mute, true);
							?>
							<b>Stumm</b>
							<br><br>
							<label>
								<input type="checkbox" name="mute[]" value="update" <?php if(in_array('update', $mute)) { echo 'checked';} ?>> UPDATE - Du erhältst keine Benachrichtigungen mehr, wenn sich der Stundenplan ändert.
							</label>
							<label>
								<input type="checkbox" name="mute[]" value="next" <?php if(in_array('next', $mute)) { echo 'checked';} ?>> NEXT - Du erhältst keine Benachrichtigungen mehr, welches Unterrichtsfach du gleich haben wirst.
							</label>
						</div>
						<!-- /.tab-pane -->
						
						<div class="tab-pane" id="notification_plan">
							<b>Pläne</b>
							<br><br>
							<div class="info-box">
								<span class="info-box-icon bg-red"><i class="fa fa-exclamation-triangle"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Under develoment</span>
									<span class="info-box-number">COMING SOON</span>
								</div>
								<!-- /.info-box-content -->
							</div>
							<!-- /.info-box -->
						</div>
						<!-- /.tab-pane -->
					</div>
					<!-- /.tab-content -->
				</div>
				<!-- nav-tabs-custom -->
				
				<button type="submit" class="btn bg-green btn-flat margin pull-right">Speichern</button>
			</form>
		</div>
		<!-- /.box-body -->
	</div>
	<!-- /.box -->
</section>
<!-- /.content -->

<?php $JS_ADDON .= 'function toggleCheckboxlist(id) {
	if (!$("#class-switch-" + id).is(":checked")) {
		$("#class-list-" + id).hide();
		$("#tab-button-" + id).attr("class", "");
	}
	else {
		$("#class-list-" + id).show();
		$("#tab-button-" + id).attr("class", "text-light-blue");
	}
}'; ?>



