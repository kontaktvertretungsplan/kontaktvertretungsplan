<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Einstellungen
		<small>Tabellarische Übersicht</small>
	</h1>
</section>
	
<!-- Main content -->
<section class="content">
	<div class="box box-success with-border">
		<div class="box-body">
			<table id="user-table" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Name</th>
						<th>Wert</th>
						<th>Bearbeiten</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$statement = $PDO->prepare("SELECT * FROM settings ORDER BY name ASC");
						$statement->execute();
						foreach($statement->fetchAll() as $set) {
					?>
					<tr>
						<td><?php echo $set['name']; ?></td>
						<td><pre><?php echo $set['value']; ?></pre></td>
						<td><a href="?p=admin:settings-edit&name=<?php echo $set['name']; ?>" class="btn btn-success">Bearbeiten</a></td>
					</tr>
					<?php
						}
					?>
				</tbody>
				<tfoot>
					<tr>
						<th>Name</th>
						<th>Wert</th>
						<th>Bearbeiten</th>
					</tr>
				</tfoot>
			</table>
		</div>
		<!-- /.box-body -->
	</div>
	<!-- /.box -->
</section>
<?php $JS_ADDON = '$(function () { $("#user-table").DataTable( {"order": [[ 0, "asc" ]], "language": {
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
    "zeroRecords":    "Keine passenden Einträge gefunden<br><a href=\"?p=admin:settings-edit\">Neuen Eintrag erstellen</a>",
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