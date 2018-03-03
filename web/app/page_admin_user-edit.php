<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Bearbeiten
		<small>Benutzer bearbeiten</small>
	</h1>
</section>

<!-- Main content -->
<section class="content">
	<div class="box box-success with-border">
		<!-- form start -->
		<?php
			$statement = $PDO->prepare("SELECT ID, telegram, mute, role, name FROM user WHERE ID = ?");
			$statement->execute([$_GET['id']]);
			$result = $statement->fetch();
			
		?>
		<form action="?do=admin:user-save&id=<?php echo $result['ID']; ?>" method="POST">
			<div class="box-body">
			<div class="form-group">
			<label for="name">Name</label>
			<input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?php echo $result['name']; ?>">
			</div>
			<div class="form-group">
			<label for="telegram">Telegram</label>
			<input type="text" class="form-control" id="telegram" name="telegram" placeholder="Telegram ID" value="<?php echo $result['telegram']; ?>" disabled>
			</div>
			<div class="form-group">
				<label for="role">Rollen</label>
				<select class="form-control select2" multiple="multiple" id="role" name="role[]" data-placeholder="Rollen" style="width: 100%;">
					<?php
						$user_roles = json_decode($result['role'], true);
						
						$all_roles = [];
						foreach(scandir('web/app') as $file) {
							$file = explode('_', $file);
							if(count($file) >= 3) {
								if($file[0] == 'page' || $file[0] == 'do') {
									if($file[1] != 'error') {
										$is_there = false;
										foreach($all_roles as $a_r) {
											if($a_r == $file[1]) {
												$is_there = true;
											}
										}
										
										if($is_there == false) {
											$all_roles[] = $file[1];
										}
									}
								}
							}
						}
						
						foreach($all_roles as $role) {
							$selected = false;
							foreach($user_roles as $u_r) {
								if($u_r == $role) {
									$selected = true;
								}
							}
							
							echo "<option";
							if($selected) {
								echo " selected";
							}
							echo ">".$role."</option>";
						}
					?>
				</select>
			</div>
			<!-- /.form-group -->
			<div class="form-group">
				<label for="role">Stumm</label>
				<select class="form-control select2" multiple="multiple" id="mute" name="mute[]" data-placeholder="Stumm" style="width: 100%;">
					<?php
						$muted = json_decode($result['mute'], true);
						
						$mute_options = ["update", "next"];
						
						
						foreach($mute_options as $m_o) {
							$selected = false;
							foreach($muted as $m) {
								if($m == $m_o) {
									$selected = true;
								}
							}
							
							echo '<option';
							if($selected) {
								echo ' selected';
							}
							echo '>'.$m_o.'</option>';
						}
					?>
				</select>
			</div>
			<!-- /.form-group -->
			<button type="submit" class="btn btn-success">Speichern</button>
			</div>
			<!-- /.box-body -->
		</form>
	</div>
	<!-- /.box -->
</section>
<!-- /.content -->

<?php $JS_ADDON = '$(".select2").select2()'; ?>