<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Benutzer
		<small>Benutzer Verwalten</small>
	</h1>
</section>
	
<!-- Main content -->
<section class="content">
	<div class="box box-success with-border">
		<!-- /.box-header -->
		<div class="box-body">
			<table id="user-table" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Name</th>
						<th>Rollen</th>
						<th>Telegram</th>
						<th>Einstellungen</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$statement = $PDO->prepare("SELECT * FROM user");
						$statement->execute();
						foreach($statement->fetchAll() as $user) {
					?>
					<tr>
						<td><?php echo $user['name']; ?></td>
						<td>
							<ul>
								<li>user</li>
								<?php
									foreach(json_decode($user['role'], true) as $role) {
										echo '<li>'.$role.'</li>';
									}
								?>
							</ul>
						</td>
						<td><?php echo $user['telegram']; ?></td>
						<td><a href="?p=admin:user-edit&id=<?php echo $user['ID']; ?>" class="btn btn-success">Bearbeiten</a></td>
					</tr></td>
					</tr>
					<?php
						}
					?>
				</tbody>
				<tfoot>
					<tr>
						<th>Name</th>
						<th>Rollen</th>
						<th>Telegram</th>
						<th>Einstellungen</th>
					</tr>
				</tfoot>
			</table>
		</div>
		<!-- /.box-body -->
	</div>
	<!-- /.box -->
</section>
<?php $JS_ADDON = '$(function () { $("#user-table").DataTable() })'; ?>