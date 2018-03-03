<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Aufrufe
		<small>Der letzten zwei Wochen</small>
	</h1>
</section>
	
<!-- Main content -->
<section class="content">
	<div class="box box-success with-border">
		<!-- /.box-header -->
		<div class="box-body">
			<div id="graph" style="height: 300px;"></div>
		</div>
		<!-- /.box-body -->
	</div>
	<!-- /.box -->
</section>
<?php
$current_time  = strtotime(date("Y-m-d"));
$used_time = $current_time;
$values = [];
while($used_time > $current_time - (60*60*24*7*2)) {
    $statement = $PDO->prepare("SELECT * FROM log WHERE time > ? AND time <= ?");
    $statement->execute([$used_time - (60*60*12), $used_time + (60*60*12)]);
    $values[] = [-($current_time - $used_time)/(60*60*24), $statement->rowCount()];
    $used_time -= 60*60*24;
}
?>
<?php $JS_ADDON = '$.plot($("#graph"), ['. json_encode($values) .'], {
      grid  : {
        hoverable  : true,
        borderColor: \'#f3f3f3\',
        borderWidth: 1,
        tickColor  : \'#f3f3f3\'
      },
      series: {
        shadowSize: 0,
        lines     : {
          show: true
        },
        points    : {
          show: true
        }
      },
      lines : {
        fill : false,
        color: [\'#00a65a\', \'#00a65a\']
      },
      yaxis : {
        show: true
      },
      xaxis : {
        show: true
      }
    });'; ?>
