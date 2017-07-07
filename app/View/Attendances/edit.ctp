<?
#cssファイル
echo $this->Html->css('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css');
echo $this->Html->css('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css');
echo $this->Html->css('assets/global/plugins/jquery-tags-input/jquery.tagsinput.css');
echo $this->Html->css('assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css');
echo $this->Html->css('assets/global/plugins/typeahead/typeahead.css');

echo $this->Html->css('assets/global/plugins/clockface/css/clockface.css');
echo $this->Html->css('assets/global/plugins/bootstrap-datepicker/css/datepicker3.css');
echo $this->Html->css('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css');
echo $this->Html->css('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css');
echo $this->Html->css('assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css');
echo $this->Html->css('assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css');

#jsファイル
echo $this->Html->script('assets/global/plugins/fuelux/js/spinner.min.js');
echo $this->Html->script('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js');
echo $this->Html->script('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js');
echo $this->Html->script('assets/global/plugins/jquery.input-ip-address-control-1.0.min.js');
echo $this->Html->script('assets/global/plugins/bootstrap-pwstrength/pwstrength-bootstrap.min.js');
echo $this->Html->script('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js');
echo $this->Html->script('assets/global/plugins/jquery-tags-input/jquery.tagsinput.min.js');
echo $this->Html->script('assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js');
echo $this->Html->script('assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js');
echo $this->Html->script('assets/global/plugins/typeahead/handlebars.min.js');
echo $this->Html->script('assets/global/plugins/typeahead/typeahead.bundle.min.js');
echo $this->Html->script('assets/global/plugins/ckeditor/ckeditor.js');

echo $this->Html->script('assets/global/plugins/moment.min.js');
echo $this->Html->script('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js');
echo $this->Html->script('assets/global/plugins/bootstrap-datepaginator/bootstrap-datepaginator.min.js');

echo $this->Html->script('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js');
echo $this->Html->script('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js');
echo $this->Html->script('assets/global/plugins/clockface/js/clockface.js');
echo $this->Html->script('assets/global/plugins/bootstrap-daterangepicker/moment.min.js');
echo $this->Html->script('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js');
echo $this->Html->script('assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js');
echo $this->Html->script('assets/admin/pages/scripts/ui-datepaginator.js');
echo $this->Html->script('assets/admin/pages/scripts/components-form-tools.js');
echo $this->Html->script('assets/admin/pages/scripts/components-pickers.js');

//debug($attendances);
?>
	<script type="text/javascript">
		$(function () {
			$('.input-group').datetimepicker({
				format: 'yyyy-mm-dd hh:ii'
			});
		});
	</script>
<?echo $this->Form->create('Attendance', array('action'=>'add'));?>
	<input type="hidden" name="working_day" value="<?echo $working_day; ?>">
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
		<!-- BEGIN PAGE CONTENT INNER -->
		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN PORTLET-->
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-cogs font-green-sharp"></i>
							<span class="caption-subject font-green-sharp bold uppercase">日付選択</span>
						</div>
						<div class="tools">
							<a href="javascript:;" class="collapse">
							</a>
						</div>
					</div>
					<div class="portlet-body">
						<div class="row">
							<div class="col-md-6">
								<input id="date_box" data-date-format="yyyy-mm-dd" class="form-control input-large date-picker" size="16" type="text" value="<?echo $working_day; ?>" readonly>
							</div>
							<div class="col-md-6">
								<button type="button" class="btn red" onClick="goNextDay();"><i class="fa fa-check"></i>日付を選択する</button>
								<script>
									function goNextDay(){
										var date  = $("#date_box").val();
										var url   = location.href;
										console.log(url);
										var parameters    = url.split("?");
										var dateJob = parameters[1].split("=");
										if (date != dateJob[1]) {
											window.location.href = '?date='+date;
										};
									}
								</script>
							</div>
						</div>
					</div>
				</div>
				<!-- END PORTLET-->
			</div>
		</div>
		<!-- END PAGE CONTENT INNER -->
		<!-- BEGIN PAGE CONTENT INNER -->
		<div class="row">
			<div class="col-md-12">
				<div class="tabbable tabbable-custom tabbable-noborder tabbable-reversed">
					<ul class="nav nav-tabs">
						<li class="active">
							<a href="#tab_0" data-toggle="tab">
								時間調整</a>
						</li>
						<li>
							<a href="#tab_1" data-toggle="tab">
								新規追加</a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab_0">

							<div class="row">
								<div class="col-md-12">
									<div class="portlet box blue">
										<div class="portlet-title">
											<div class="caption">
												<i class="fa fa-gift"></i>タイムカード記録
											</div>
											<div class="tools">
												<a href="javascript:;" class="collapse">
												</a>
											</div>
										</div>
										<div class="portlet-body form">
											<!-- BEGIN FORM-->

											<div class="form-body">
												<?php if($attendances): ?>
													<?php foreach ($attendances as $key => $attendance): ?>
														<!-- 共通row -->
														<div class="row">
															<div class="col-md-3">
																<label class="control-label">名前</label>
																<div class="form-group">
																	<div class="panel panel-warning">
																		<div class="panel-heading">
																			<?echo $attendance[1]['Member']['name'];?>
																		</div>
																	</div>
																</div>
															</div>
															<div class="col-md-3">
																<label class="control-label">まかない</label>
																<div class="form-group">
																	<select class="form-control" name="AttendanceResult[<?echo $key;?>][makanai]">
																		<option value="0" <?if(!isset($attendance['makanai'])||(isset($attendance['makanai'])&&$attendance['makanai']==0)){echo "selected";}?>>なし</option>
																		<option value="1" <?if(isset($attendance['makanai'])&&$attendance['makanai']==1){echo "selected";}?>>あり</option>
																	</select>
																</div>
															</div>
															<div class="col-md-3">
																<div class="form-group">
																	<label class="control-label">出勤時間</label>
																	<div class="input-group date form_datetime">
																			<span class="input-group-btn">
																				<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
																			</span>
																		<input type="text" readonly="" class="form-control" name="AttendanceResult[<?echo $key;?>][attendance_start][<?echo $attendance[1]['Attendance']['id'];?>]" value="<?echo $attendance[1]['Attendance']['time'];?>">
																	</div>
																</div>
															</div>
															<div class="col-md-3">
																<div class="form-group">
																	<label class="control-label">退勤時間</label>
																	<div class="input-group date form_datetime">
																			<span class="input-group-btn">
																				<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
																			</span>
																		<input type="text" readonly="" class="form-control" name="AttendanceResult[<?echo $key;?>][attendance_end][<?if(isset($attendance[2])){echo $attendance[2]['Attendance']['id'];}else{echo "new";}?>]" value="<?if(isset($attendance[2])){echo $attendance[2]['Attendance']['time'];} ?>">
																	</div>
																</div>
															</div>
														</div>
														<!-- END共通row -->
														<!-- 休憩row -->
														<div class="row">
															<?if(isset($attendance['break'])):?>
																<?$i=0;?>
																<?foreach($attendance['break'] as $break):?>
																	<?$i++;$s=ceil($i/2);?>
																	<div class="col-md-3">
																		<div class="form-group">
																			<label class="control-label"><?echo $break['Type']['name'];?><?echo $s;?></label>
																			<div class="input-group date form_datetime">
																				<span class="input-group-btn"><button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button></span>
																				<input type="text" readonly="" class="form-control" name="AttendanceResult[<?echo $key;?>][break][<?echo $break['Attendance']['id'];?>]" value="<?echo $break['Attendance']['time'];?>">
																			</div>
																		</div>
																	</div>
																<?endforeach;?>
															<?else:?>
																<?for($c=1;$c<3;$c++):?>
																	<div class="col-md-3">
																		<div class="form-group">
																			<label class="control-label">休憩開始<?echo $c;?></label>
																			<div class="input-group date form_datetime">
																				<span class="input-group-btn"><button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button></span>
																				<input type="text" readonly="" class="form-control" name="AttendanceResult[<?echo $key;?>][break][new][]" value="">
																			</div>
																		</div>
																	</div>
																	<div class="col-md-3">
																		<div class="form-group">
																			<label class="control-label">休憩終了<?echo $c;?></label>
																			<div class="input-group date form_datetime">
																				<span class="input-group-btn"><button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button></span>
																				<input type="text" readonly="" class="form-control" name="AttendanceResult[<?echo $key;?>][break][new][]" value="">
																			</div>
																		</div>
																	</div>
																<?endfor;?>
															<?endif;?>
														</div>
														<!-- END休憩row -->
														<div class="form-actions right">
															<?if(isset($attendance["出勤"])&&!isset($attendance["退勤"])&&!isset($attendance["休憩開始"])&&!isset($attendance["休憩終了"])):?>
																<input type="button" value="削除する" class="btn green" onclick='var ok=confirm("本当に削除してもよろしいですか？");if (ok) location.href="<?echo $this->Html->url(array('controller'=>'attendances', 'action'=>'delete', '?' => array('id' => $attendance["出勤"]['Attendance']['id'])));?>"'>
															<?elseif(isset($attendance["出勤"])&&isset($attendance["退勤"])&&!isset($attendance["休憩開始"])&&!isset($attendance["休憩終了"])):?>
																<input type="button" value="削除する" class="btn green" onclick='var ok=confirm("本当に削除してもよろしいですか？");if (ok) location.href="<?echo $this->Html->url(array('controller'=>'attendances', 'action'=>'delete', '?' => array('id' => $attendance["出勤"]['Attendance']['id'], 'id_two' => $attendance["退勤"]['Attendance']['id'])));?>"'>
															<?elseif(isset($attendance["出勤"])&&isset($attendance["退勤"])&&isset($attendance["休憩開始"])&&isset($attendance["休憩終了"])):?>
																<input type="button" value="削除する" class="btn green" onclick='var ok=confirm("本当に削除してもよろしいですか？");if (ok) location.href="<?echo $this->Html->url(array('controller'=>'attendances', 'action'=>'delete', '?' => array('id' => $attendance["出勤"]['Attendance']['id'], 'id_two' => $attendance["退勤"]['Attendance']['id'], 'id_three' => $attendance["休憩開始"]['Attendance']['id'], 'id_four' => $attendance["休憩終了"]['Attendance']['id'])));?>"'>
															<?endif;?>
														</div>
													<?php endforeach; ?>
												<?php endif; ?>

											</div>
											<!--button-->
											<!-- END FORM-->
										</div>
									</div>
								</div>
							</div>
						</div>


						<!-- 追加分 新規追加 -->
						<div class="tab-pane" id="tab_1">

							<div class="row">
								<div class="col-md-12">
									<div class="portlet box purple">
										<div class="portlet-title">
											<div class="caption">
												<i class="fa fa-gift"></i>出勤者新規追加
											</div>
											<div class="tools">
												<a href="javascript:;" class="collapse"></a>
											</div>
										</div>
										<div class="portlet-body form">
											<div class="form-body">
												<!--新規追加分ループ-->
												<?php for ($i=0; $i < 5; $i++): ?>
													<div class="row">
														<div class="col-md-3">
															<label class="control-label">名前</label>
															<div class="form-group">
																<select class="form-control" name="NewAttendanceResult[<?echo $i;?>][member_id]">
																	<option value="">選択してください</option>
																	<?foreach ($members as $member): ?>
																		<option value="<?= $member['Member']['id']; ?>"><?= $member['Member']['name']; ?></option>
																	<?endforeach; ?>
																</select>
															</div>
														</div>
														<div class="col-md-3">
															<label class="control-label">まかない</label>
															<div class="form-group">
																<select class="form-control" name="NewAttendanceResult[<?echo $i;?>][makanai]">
																	<option value="0">なし</option>
																	<option value="1">あり</option>
																</select>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-3">
															<div class="form-group">
																<label class="control-label">出勤時間</label>
																<div class="input-group date form_datetime">
																	<span class="input-group-btn">
																		<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
																	</span>
																	<input type="text" size="16" readonly="" class="form-control" name="NewAttendanceResult[<?echo $i;?>][attendance_start]" value="">
																</div>
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<label class="control-label">休憩開始</label>
																<div class="input-group date form_datetime">
																	<span class="input-group-btn">
																		<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
																	</span>
																	<input type="text" size="16" readonly="" class="form-control" name="NewAttendanceResult[<?echo $i;?>][attendance_start_break]" value="">
																</div>
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<label class="control-label">休憩終了</label>
																<div class="input-group date form_datetime">
																	<span class="input-group-btn">
																		<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
																	</span>
																	<input type="text" size="16" readonly="" class="form-control" name="NewAttendanceResult[<?echo $i;?>][attendance_end_break]" value="">
																</div>
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<label class="control-label">退勤時間</label>
																<div class="input-group date form_datetime">
																	<span class="input-group-btn">
																		<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
																	</span>
																	<input type="text" size="16" readonly="" class="form-control" name="NewAttendanceResult[<?echo $i;?>][attendance_end]" value="">
																</div>
															</div>
														</div>
													</div>
												<?php endfor; ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- 追加分 新規追加 -->

					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<input type="button" onclick="submit();" onmouseover="this.style.backgroundColor='#36C3FF'" onmouseout="this.style.backgroundColor='#ff5252'" ;="" class="list-group-item list-group-item-danger" style="height:90px; width:100%; color:white; text-align:center; font-size:50px; font-weight:bold; background-color:#ff5252; letter-spacing:20px;" value="送信する">
			</div>
		</div>
	</div>
</div>
<!-- END PAGE CONTENT INNER -->
<script>
	jQuery(document).ready(function() {
		// initiate layout and plugins
		Metronic.init(); // init metronic core components
		Layout.init(); // init current layout
		Demo.init(); // init demo features
		UIDatepaginator.init();
		ComponentsFormTools.init();
		ComponentsPickers.init();
	});
</script>
<?echo $this->Form->end();?>