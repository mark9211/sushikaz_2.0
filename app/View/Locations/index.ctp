<?
#css
echo $this->Html->css('less/custom.css');
echo $this->Html->css('less/jquery.maximage.css', array('media' => 'screen'));
#js
echo $this->Html->script('js/jquery-2.0.3.min.js');
echo $this->Html->script('js/jquery.djax.js');
echo $this->Html->script('js/jquery.nicescroll.min.js');
echo $this->Html->script('js/jquery.ba-throttle-debounce.min.js');
echo $this->Html->script('js/transit.js');
echo $this->Html->script('js/jquery.cycle.all.min.js');
echo $this->Html->script('js/jquery.maximage.min.js');
echo $this->Html->script('js/jquery.colorbox-min.js');
echo $this->Html->script('js/owl.carousel.min.js');
echo $this->Html->script('js/main.js');
echo $this->Html->script('js/tooltip.js');
echo $this->Html->script('js/popover.js');
?>
<div id="content-wrapper">
	<div class="dynamic-content restaurant-wrapper" id="main-content">
		<div class="container">
			<div id="restaurant" class="padding-wrapper">
				<div class="row">
					<div class="col-md-6">
						<div class="square square-big">
							<i class="fa fa-clock-o"></i>
							<a onclick='location.href="<?echo $this->Html->url(array('controller'=>'attendances', 'action'=>'index'));?>"'>
								<div class="square-bg">
									<?= $this->Html->image('img/calendar-512.png', array('width' => '100%','style' => 'background-color:#ff4081'));?>
								</div>
								<div class="square-header">
									<p class="title">Time Card</p>
									<p class="description"><strong>タイムカード</strong></p>
								</div>
								<div class="square-post">
									<p class="title">タイムカード</p>
									<p class="description">こちらのページより出退休憩の記録を付けてください。</p>
								</div>
							</a>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="square">
									<i class="fa fa-globe"></i>
									<a href="#responsive_1" data-toggle="modal">
										<div class="square-bg">
											<?= $this->Html->image('img/cast.png', array('width'=>'100%','style' => 'background-color:#1b39a8'));?>
										</div>
										<div class="square-header">
											<p class="title">Attendance</p>
											<p class="description">勤怠<strong>管理</strong></p>
										</div>
										<div class="square-post">
											<p class="title">勤怠<br/> <strong>管理<i class="fa fa-arrow-circle-o-right"></i></strong></p>
										</div>
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-6">
								<div class="square">
									<i class="fa fa-calendar-o"></i>
									<?$date = date('Y-m-d', strtotime('-1 day'));?>
									<a onclick='location.href="<?echo $this->Html->url(array('controller'=>'sales', 'action'=>'index', '?' => array('date' => $date)));?>"'>
										<div class="square-bg" style="background-color:#ab47bc">
											<?= $this->Html->image('img/design-minutes.png', array('width'=>'50%','height'=>'50%','style' => 'margin: auto;'));?>
										</div>
										<div class="square-header">
											<p class="title">Entry</p>
											<p class="description">日報<strong>入力</strong></p>
										</div>
										<div class="square-post">
											<p class="title">日報<br/> <strong>入力 <i class="fa fa-arrow-circle-o-right"></i></strong></p>
										</div>
									</a>
								</div>
							</div>
							<div class="col-md-6">
								<div class="square">
									<i class="fa fa-group"></i>
									<a onclick='location.href="<?echo $this->Html->url(array('controller'=>'sales', 'action'=>'view', '?' => array('date' => $date)));?>"'>
										<div class="square-bg" style="background-color:#ff5252;">
											<?= $this->Html->image('img/materialreel.png', array('width'=>'50%','height'=>'50%', 'style' => 'margin: auto;'));?>
										</div>
										<i class="fa fa-clock-o"></i>
										<div class="square-header">
											<p class="title">DailyReports</p>
											<p class="description"><strong>日報</strong>一覧</p>
										</div>
										<div class="square-post">
											<p class="title">日報<br/><strong>一覧<i class="fa fa-arrow-circle-o-right"></i></strong></p>
										</div>
									</a>
								</div>
							</div>
							<div class="col-md-6">
								<div class="square">
									<i class="fa fa-group"></i>
									<a href="#responsive_2" data-toggle="modal">
										<div class="square-bg">
											<?= $this->Html->image('img/notebook-512.png', array('width'=>'100%','style' => 'background-color:#ffcd40'));?>
										</div>
										<i class="fa fa-clock-o"></i>
										<div class="square-header">
											<p class="title">Staffing</p>
											<p class="description"><strong>従業員</strong>管理</p>
										</div>
										<div class="square-post">
											<p class="title">従業員<br/> <strong>管理<i class="fa fa-arrow-circle-o-right"></i></strong></p>
										</div>
									</a>
								</div>
							</div>
							<div class="col-md-6">
								<div class="square">
									<i class="fa fa-group"></i>
									<a onclick='location.href="<?= $this->Html->url(array('controller'=>'breakdowns', 'action'=>'index'));?>"'>
										<div class="square-bg">
											<?= $this->Html->image('img/webdesigner.png', array('width'=>'100%','style' => 'background-color:#8bc34a'));?>
										</div>
										<div class="square-header">
											<p class="title">Master Submit</p>
											<p class="description">システム連携<strong></strong></p>
										</div>
										<div class="square-post">
											<p class="title">システム<br><strong>連携<i class="fa fa-arrow-circle-o-right"></i></strong></p>
										</div>
									</a>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="square">
									<i class="fa fa-globe"></i>
									<a onclick='location.href="<?= $this->Html->url(array('controller'=>'analysis', 'action'=>'index'));?>"'>
										<div class="square-bg">
											<?= $this->Html->image('img/doodlearchive.png', array('width'=>'100%','style' => 'background-color:#FF9933'));?>
										</div>
										<div class="square-header">
											<p class="title">Analysis</p>
											<p class="description">各種<strong>分析</strong></p>
										</div>
										<div class="square-post">
											<p class="title">各種<br/> <strong>分析<i class="fa fa-arrow-circle-o-right"></i></strong></p>
										</div>
									</a>
								</div>
							</div>
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
	});
</script>
