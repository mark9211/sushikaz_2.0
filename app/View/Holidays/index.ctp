<?
#css
echo $this->Html->css('assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css');
echo $this->Html->css('assets/global/plugins/fullcalendar/fullcalendar.min.css');

#js
echo $this->Html->script('assets/global/plugins/bootstrap-daterangepicker/moment.min.js');
echo $this->Html->script('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js');
echo $this->Html->script('assets/global/plugins/fullcalendar/fullcalendar.min.js');
echo $this->Html->script('assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js');
echo $this->Html->script('assets/global/plugins/jquery.sparkline.min.js');
echo $this->Html->script('assets/admin/pages/scripts/index.js');    //index.init

?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light calendar">
				<div class="portlet-title ">
					<div class="caption">
						<i class="icon-calendar font-green-sharp"></i>
						<span class="caption-subject font-green-sharp bold uppercase">業務スケジュール</span>
					</div>
				</div>
				<div class="portlet-body">
					<div id="calendar" class="fc fc-ltr fc-unthemed"><div class="fc-toolbar">
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>
<script>
	jQuery(document).ready(function() {
		// initiate layout and plugins
		Metronic.init(); // init metronic core components
		Layout.init(); // init current layout
		Demo.init(); // init demo features
		Index.init();
		Index.initDashboardDaterange();
		Index.initCalendar(); // init index page's custom scripts
	});
</script>
