<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Klassen
		<small>Abonieren von Stundenplänen</small>
	</h1>
</section>
	
<!-- Main content -->
<section class="content">
	<!-- Default box -->
	<div class="box box-success with-border">
		<div class="box-body">
			<form action="?do=class-save" method="POST">
				<!-- Custom Tabs (Pulled to the right) -->
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs pull-right">
						<?php
							$statement = $PDO->prepare("SELECT ID, name FROM class ORDER BY name DESC");
							$statement->execute();
							$result = $statement->fetchAll();
							
							$active_tab_set = false;
							
							foreach($result as $row) {
								echo '<li ';
								$statement = $PDO->prepare("SELECT ID FROM subscription WHERE user = ? AND typ = 'class' AND value = ?");
								$statement->execute([$USER_INFO['id'], $row['ID']]);
								if($statement->rowCount() == 1 && $active_tab_set == false) {
									echo 'class="active"';
									$active_tab_set = true;
								}
								echo '><a id="tab-button-'.$row['ID'].'" href="#class_'.$row['ID'].'" data-toggle="tab">'.$row['name'].'</a></li>';
							}
							
						?>
						<!--<li class="pull-left header"><i class="fa fa-th"></i> Klassen</li>-->
					</ul>
					<div class="tab-content">
						<?php
							$active_tab_set = false;
							
							foreach($result as $row) {
								echo '<div class="tab-pane ';
								
								$statement = $PDO->prepare("SELECT ID FROM subscription WHERE user = ? AND typ = 'class' AND value = ?");
								$statement->execute([$USER_INFO['id'], $row['ID']]);
								if($statement->rowCount() == 1 && $active_tab_set == false) {
									echo 'active';
									$active_tab_set = true;
								}
								echo '" id="class_'.$row['ID'].'">';
								
								echo '<b>Klasse '.$row['name'].'</b>';
								echo '<br><br>';
								
								echo '<label><input id="class-switch-'.$row['ID'].'" type="checkbox" name="class['.$row['ID'].']" value="yes"';
								
								
								if($statement->rowCount() == 1) {
									echo ' checked';
								}
								
								echo '> '.$row['name'].'</label><br><br>';
								
								$JS_ADDON .= '$("#class-switch-'.$row['ID'].'").on("ifToggled", function () {toggleCheckboxlist('.$row['ID'].');}); $(document).ready(function(){toggleCheckboxlist('.$row['ID'].');});
		';
								
								echo '<div id="class-list-'.$row['ID'].'">';
								echo '<b>Kurse '.$row['name'].'</b><br><br>';
								
								$statement = $PDO->prepare("SELECT ID, name FROM course WHERE class = ? ORDER BY name ASC");
								$statement->execute([$row['ID']]);
								foreach($statement->fetchAll() as $row2) {
									echo '<label><input type="checkbox" name="course['.$row['ID'].']['.$row2['ID'].']" value="yes"';
									
									$statement = $PDO->prepare("SELECT ID FROM subscription WHERE user = ? AND typ = 'course' AND value = ?");
									$statement->execute([$USER_INFO['id'], $row2['ID']]);
									if($statement->rowCount() == 1) {
										echo ' checked';
									}
									
									echo '> '.$row2['name'].'</label><br>';
								}
								
								echo '</div>';
								
								echo '</div><!-- /.tab-pane -->';
							}
							
						?>
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

