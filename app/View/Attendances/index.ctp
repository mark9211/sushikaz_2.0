<?
//debug($members);
//debug($member_flags);
//debug($member_types);
//debug($working_day);
?>
<div class="page-container">
	<!-- BEGIN PAGE HEAD -->
	<div class="page-head">
		<div class="container">
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<h1>スタッフ一覧 <small>Staff List</small></h1>
			</div>
			<!-- END PAGE TITLE -->
		</div>
	</div>
	<!-- END PAGE HEAD -->
	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">
			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Modal title</h4>
						</div>
						<div class="modal-body">
							Widget settings form goes here
						</div>
						<div class="modal-footer">
							<button type="button" class="btn blue">Save changes</button>
							<button type="button" class="btn default" data-dismiss="modal">Close</button>
						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
			<!-- /.modal -->
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<!-- BEGIN PAGE BREADCRUMB -->
			<!-- END PAGE BREADCRUMB -->
			<!-- BEGIN PAGE CONTENT INNER -->
			<div class="row">
				<?foreach($member_types as $member_type):?>
					<div class="col-md-<?if($member_type_num==1){echo 12;}elseif($member_type_num==2){echo 6;}elseif($member_type_num==3){echo 4;}elseif($member_type_num==4){echo 3;}?>">
						<!-- BEGIN SAMPLE TABLE PORTLET-->
						<div class="portlet light">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-thumbs-up font-green-sharp"></i>
									<span class="caption-subject font-green-sharp bold uppercase"><?echo $member_type?>一覧 </span>
								</div>
								<div class="tools">
									<a href="javascript:;" class="collapse">
									</a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="table-scrollable">
									<table class="table table-hover table-advance">
										<thead>
										<tr>
											<th>
												名前
											</th>
											<th>
												ポジション
											</th>
											<th>
												出勤状況
											</th>
										</tr>
										</thead>
										<tbody>
											<?php foreach ($members as $member): ?>
												<?php if($member['Type']['name'] == $member_type): ?>
													<tr data-href="<?echo $this->Html->url(array('controller'=>'attendances', 'action'=>'view', "?" => array("id" => $member['Member']['id'], "flag" => $member_flags[$member['Member']['id']])));?>">
														<td>
															<?php echo h($member['Member']['name']); ?>
														</td>
														<td>
															<?php echo h($member['Position']['name']); ?>
														</td>
														<td>
															<?if($member_flags[$member['Member']['id']]==2):?>
																<span class="label label-sm label-success"> 出勤中 </span>
															<?elseif($member_flags[$member['Member']['id']]==3):?>
																<span class="label label-sm label-warning"> 休憩中 </span>
															<?elseif($member_flags[$member['Member']['id']]==4):?>
																<span class="label label-sm label-success"> 出勤中 </span>
															<?elseif($member_flags[$member['Member']['id']]==5):?>
																<span class="label label-sm label-danger"> 退勤済 </span>
															<?else:?>
																<span class="label label-sm label-danger"></span>
															<?endif;?>
														</td>
													</tr>
												<?php endif; ?>
											<?php endforeach; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<!-- END SAMPLE TABLE PORTLET-->
					</div>
				<?endforeach;?>
			</div>
			<!-- END PAGE CONTENT INNER -->
		</div>
	</div>
	<!-- END PAGE CONTENT -->
</div>

<script>
	jQuery(document).ready(function() {
		// initiate layout and plugins
		Metronic.init(); // init metronic core components
		Layout.init(); // init current layout
		Demo.init(); // init demo features
	});
	jQuery( function($) {
		$('tbody tr[data-href]').addClass('clickable').click( function() {
			window.location = $(this).attr('data-href');
		}).find('a').hover( function() {
			$(this).parents('tr').unbind('click');
		}, function() {
			$(this).parents('tr').click( function() {
				window.location = $(this).attr('data-href');
			});
		});
	});
</script>