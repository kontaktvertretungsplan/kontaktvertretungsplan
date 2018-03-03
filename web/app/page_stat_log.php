<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Log
		<small>Verlauf</small>
	</h1>
</section>
	
<!-- Main content -->
<section class="content">
	<div class="box box-success with-border">
		<!-- /.box-header -->
		<div class="box-body">
			<div class="table-responsive">
				<table id="user-table" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Zeit</th>
							<th>Benutzer</th>
							<th>Modul/Teil</th>
							<th>Status</th>
							<th>Anmerkung</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$statement = $PDO->prepare("SELECT * FROM log ORDER BY time DESC LIMIT 100");
							$statement->execute();
							foreach($statement->fetchAll() as $user) {
						?>
						<tr>
							<td><?php echo date("Y-m-d H:i:s", $user['time']); ?></td>
							<?php if($user['user'] != 0): ?>
							<td><?php echo $user['user']; ?></td>
							<?php else: ?>
							<td>System</td>
							<?php endif; ?>
							<td><?php echo $user['module']; ?>:<?php echo $user['part']; ?></td>
							<td><?php echo $user['status']; ?></td>
							<td><pre><?php echo $user['notice']; ?></pre></td>
						</tr>
						<?php
							}
						?>
					</tbody>
					<tfoot>
						<tr>
							<th>Zeit</th>
							<th>Modul/Teil</th>
							<th>Status</th>
							<th>Anmerkung</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
		<!-- /.box-body -->
	</div>
	<!-- /.box -->
</section>
<?php $JS_ADDON = '$(function () { $("#user-table").DataTable( {"order": [[ 0, "desc" ]], "language": {
    "decimal":        "",
    "emptyTable":     "Keine Log vorhanden",
    "info":           "Zeige _START_ bis _END_ von _TOTAL_ Einträgen",
    "infoEmpty":      "Zeige 0 bis 0 von 0 Einträgen",
    "infoFiltered":   "(aus _MAX_ Einträgen gefiltert)",
    "infoPostFix":    "",
    "thousands":      ",",
    "lengthMenu":     "Zeige _MENU_ Einträge",
    "loadingRecords": "Lade...",
    "processing":     "Verarbeite...",
    "search":         "Suche:",
    "zeroRecords":    "Keine passenden Einträge gefunden",
    "paginate": {
        "first":      "Erste Seite",
        "last":       "Letzte Seite",
        "next":       "Nächste",
        "previous":   "Vorgehende"
    },
    "aria": {
        "sortAscending":  ": activate to sort column ascending",
        "sortDescending": ": activate to sort column descending"
    }}})
})'; ?>