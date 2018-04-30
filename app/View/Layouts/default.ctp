<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<!DOCTYPE html>
<html class="no-js">
<head>
	<?php echo $this->Html->charset('utf-8'); ?>
	<title>
		<?php echo $this->fetch('title'); ?>
	</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css">
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
	<?php
		echo $this->Html->meta('icon');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');

		#BEGIN GLOBAL MANDATORY STYLES
		echo $this->Html->css('style.css');
		echo $this->Html->css('assets/global/plugins/font-awesome/css/font-awesome.min.css');
		echo $this->Html->css('assets/global/plugins/simple-line-icons/simple-line-icons.min.css');
		echo $this->Html->css('assets/global/plugins/bootstrap/css/bootstrap.min.css');
		echo $this->Html->css('assets/global/plugins/uniform/css/uniform.default.css');
		#BEGIN THEME STYLES
		echo $this->Html->css('assets/global/css/components-rounded.css', array('id'=>'style_components'));
		echo $this->Html->css('assets/global/css/plugins.css');
		echo $this->Html->css('assets/admin/layout3/css/layout.css');
		echo $this->Html->css('assets/admin/layout3/css/themes/default.css', array('id'=>'style_color'));
		echo $this->Html->css('assets/admin/layout3/css/custom.css');

		#baseJs
		echo $this->Html->script('js/modernizr-2.6.2.min.js');
		#pluginJs
		echo $this->Html->script('assets/global/plugins/jquery.min.js');
		echo $this->Html->script('assets/global/plugins/jquery-migrate.min.js');
		echo $this->Html->script('assets/global/plugins/jquery-ui/jquery-ui.min.js');
		echo $this->Html->script('assets/global/plugins/bootstrap/js/bootstrap.min.js');
		echo $this->Html->script('assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js');
		echo $this->Html->script('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js');
		echo $this->Html->script('assets/global/plugins/jquery.blockui.min.js');
		echo $this->Html->script('assets/global/plugins/jquery.cokie.min.js');
		echo $this->Html->script('assets/global/plugins/uniform/jquery.uniform.min.js');
		#themeJs
		echo $this->Html->script('assets/global/scripts/metronic.js');
		echo $this->Html->script('assets/admin/layout3/scripts/layout.js');
		echo $this->Html->script('assets/admin/layout3/scripts/demo.js');
		echo $this->Html->script('assets/admin/pages/scripts/ui-datepaginator.js');
		echo $this->Html->script('assets/admin/pages/scripts/components-form-tools.js');
		echo $this->Html->script('assets/admin/pages/scripts/components-pickers.js');

	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<div class="page-header">
				<!-- BEGIN HEADER TOP -->
				<div class="page-header-top">
					<div class="container">
						<!-- BEGIN LOGO -->
						<div class="page-logo">
							<?echo $this->Html->image('assets/admin/layout3/img/logo-default.png', array('class' => 'logo-default', 'url'=>array('controller'=>'locations', 'action'=>'index')));?>
						</div>
						<!-- END LOGO -->
						<!-- BEGIN RESPONSIVE MENU TOGGLER -->
						<a href="javascript:;" class="menu-toggler"></a>
						<!-- END RESPONSIVE MENU TOGGLER -->
						<!-- BEGIN TOP NAVIGATION MENU -->
						<div class="top-menu">
							<ul class="nav navbar-nav pull-right">
								<li class="droddown dropdown-separator">
									<span class="separator"></span>
								</li>
								<!-- BEGIN USER LOGIN DROPDOWN -->
								<li class="dropdown dropdown-user dropdown-dark">
									<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
										<span class="username username-hide-mobile"><?if(isset($location)){echo $location['Location']['name'];}?></span></a>
									<ul class="dropdown-menu dropdown-menu-default">
										<li class="divider">
										</li>
										<li>
											<a onclick='location.href="<?echo $this->Html->url(array('controller'=>'admin', 'action'=>'index'));?>"'>
												<i class="icon-key"></i>管理者画面
											</a>
											<a onclick='location.href="<?echo $this->Html->url(array('controller'=>'locations', 'action'=>'logout'));?>"'>
												<i class="icon-key"></i>ログアウト
											</a>
										</li>
									</ul>
								</li>
								<!-- END USER LOGIN DROPDOWN -->
							</ul>
						</div>
						<!-- END TOP NAVIGATION MENU -->
					</div>
				</div>
				<!-- END HEADER TOP -->
				<!-- BEGIN HEADER MENU -->
				<div class="page-header-menu">
					<div class="container">
						<div class="hor-menu ">
							<ul class="nav navbar-nav">
								<li>
									<a onclick='location.href="<?echo $this->Html->url(array('controller'=>'locations', 'action'=>'index'));?>"'>
										ホーム
									</a>
								</li>
								<li class="menu-dropdown mega-menu-dropdown ">
									<a onclick='location.href="<?echo $this->Html->url(array('controller'=>'attendances', 'action'=>'index'));?>"' class="dropdown-toggle">
										タイムカード
									</a>
								</li>
								<li class="menu-dropdown mega-menu-dropdown mega-menu-full">
									<a data-toggle="modal" href="#responsive_1">
										勤怠管理 </a>
								</li>
								<li class="menu-dropdown mega-menu-dropdown mega-menu-full ">
									<?$date = date('Y-m-d', strtotime('-1 day'));?>
									<a onclick='location.href="<?echo $this->Html->url(array('controller'=>'sales', 'action'=>'index', '?' => array('date' => $date)));?>"' class="dropdown-toggle">
										日報入力
									</a>
								</li>
								<li class="menu-dropdown mega-menu-dropdown mega-menu-full ">
									<a onclick='location.href="<?echo $this->Html->url(array('controller'=>'sales', 'action'=>'view', '?' => array('date' => $date)));?>"' class="dropdown-toggle">
										日報一覧
									</a>
								</li>
								<li class="menu-dropdown">
									<a data-toggle="modal" href="#responsive_2">
										従業員管理 </a>
								</li>
								<!--
								<li class="menu-dropdown">
									<a onclick='location.href="<?= $this->Html->url(array('controller'=>'sales', 'action'=>'sql'));?>"'>本部送信</a>
								</li>
								-->
								<li class="menu-dropdown">
									<a onclick='location.href="<?= $this->Html->url(array('controller'=>'breakdowns', 'action'=>'index'));?>"'>システム連携</a>
								</li>
								<li class="menu-dropdown">
									<a onclick='location.href="<?= $this->Html->url(array('controller'=>'analysis', 'action'=>'index'));?>"'>各種分析</a>
								</li>
							</ul>
						</div>
						<!-- END MEGA MENU -->
					</div>
				</div>
				<!-- END HEADER MENU -->
				<!--Modal View 1-->
				<div id="responsive_1" class="modal fade in" tabindex="-1" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h4 class="modal-title">IDとパスワードを入力してください</h4>
							</div>
							<div class="modal-body">
								<div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 300px;"><div class="scroller" style="height: 300px; overflow: hidden; width: auto;" data-always-visible="1" data-rail-visible1="1" data-initialized="1">
										<div class="row">
											<div class="col-md-12">
												<h4>ID</h4>
												<p>
													<input type="text" class="col-md-12 form-control" id="userId_1" autocomplete="off">
												</p>
												<h4>Password</h4>
												<p>
													<input type="text" class="col-md-12 form-control" id="userPass_1" autocomplete="off">
												</p>
												<p id="msg_1" style="color: #ff0000;"></p>
											</div>
										</div>
									</div><div class="slimScrollBar" style="width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 300px; background: rgb(187, 187, 187);"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(234, 234, 234);"></div></div>
							</div>
							<div class="modal-footer">
								<button type="button" data-dismiss="modal" class="btn default">閉じる</button>
								<button type="button" class="btn green" id="checkButton_1">送信</button>
								<script>
									$(document).ready(function () {
										$('#checkButton_1').click(function () {
											//ID and Pass Check
											if($('#userId_1').val()=="<?if(isset($passcode)){echo $passcode['Passcode']['username'];}?>" && $('#userPass_1').val()=="<?if(isset($passcode)){echo $passcode['Passcode']['password1'];}?>"){
												window.location.href = "<?echo $this->Html->url(array('controller'=>'attendances', 'action'=>'edit', '?' => array('date' => $date)));?>";
											}else{
												$('#msg_1').text("IDまたはパスワードが違います");
											}
										})
									})
								</script>
							</div>
						</div>
					</div>
				</div>
				<!--Modal1 End-->
				<!--Modal View 2-->
				<div id="responsive_2" class="modal fade in" tabindex="-1" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h4 class="modal-title">IDとパスワードを入力してください</h4>
							</div>
							<div class="modal-body">
								<div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 300px;"><div class="scroller" style="height: 300px; overflow: hidden; width: auto;" data-always-visible="1" data-rail-visible1="1" data-initialized="1">
										<div class="row">
											<div class="col-md-12">
												<h4>ID</h4>
												<p>
													<input type="text" class="col-md-12 form-control" id="userId_2" autocomplete="off">
												</p>
												<h4>Password</h4>
												<p>
													<input type="text" class="col-md-12 form-control" id="userPass_2" autocomplete="off">
												</p>
												<p id="msg_2" style="color: #ff0000;"></p>
											</div>
										</div>
									</div><div class="slimScrollBar" style="width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 300px; background: rgb(187, 187, 187);"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(234, 234, 234);"></div></div>
							</div>
							<div class="modal-footer">
								<button type="button" data-dismiss="modal" class="btn default">閉じる</button>
								<button type="button" class="btn green" id="checkButton_2">送信</button>
								<script>
									$(document).ready(function () {
										$('#checkButton_2').click(function () {
											//ID and Pass Check
											if($('#userId_2').val()=="<?if(isset($passcode)){echo $passcode['Passcode']['username'];}?>" && $('#userPass_2').val()=="<?if(isset($passcode)){echo $passcode['Passcode']['password2'];}?>"){
												window.location.href = "<?echo $this->Html->url(array('controller'=>'members', 'action'=>'index'));?>";
											}else{
												$('#msg_2').text("IDまたはパスワードが違います");
											}
										})
									})
								</script>
							</div>
						</div>
					</div>
				</div>
				<!--Modal2 End-->
			</div>
		</div>

		<div id="content">
			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>

		<div id="footer">
			<div class="page-footer">
				<div class="container">
					2017 &copy; Riverside, INC. All Rights Reserved.
				</div>
			</div>
			<div class="scroll-to-top">
				<i class="icon-arrow-up"></i>
			</div>
		</div>

	</div>
</body>
</html>