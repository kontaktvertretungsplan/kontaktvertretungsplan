<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Bot
		<small>Übersicht</small>
	</h1>
</section>
	
<!-- Main content -->
<section class="content">
	<!-- Widget: user widget style 1 -->
	<div class="box box-widget widget-user-2">
		<!-- Add the bg color to the header using any of the bg-* classes -->
		<div class="widget-user-header bg-green">
			<!--<div class="widget-user-image">
				<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">
			</div>-->
			<!-- /.widget-user-image -->
			<h3 class="widget-user-username"><?php echo $BOT['first_name']; ?></h3>
			<h5 class="widget-user-desc"><?php echo $BOT['id']; ?></h5>
		</div>
		<div class="box-footer no-padding">
			<ul class="nav nav-stacked">
				<li><a href="https://telegram.me/<?php echo $BOT['username']; ?>" target="_blank">@<?php echo $BOT['username']; ?></a></li>
				<li><a href="?do=bot:webhook-renew">Neu verbinden</a></li>
			</ul>
		</div>
	</div>
	<!-- /.widget-user -->
</section>