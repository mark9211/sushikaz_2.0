<?
#cssファイル
echo $this->Html->css('assets/global/plugins/select2/select2.css');
echo $this->Html->css('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css');
echo $this->Html->css('assets/global/plugins/bootstrap-datepicker/css/datepicker.css');
#jsファイル
echo $this->Html->script('jquery-ui-1.10.4.custom.js');
echo $this->Html->script('assets/global/plugins/flot/jquery.flot.js');
echo $this->Html->script('assets/global/plugins/flot/jquery.flot.resize.js');
echo $this->Html->script('assets/global/plugins/flot/jquery.flot.categories.js');
#客数グラフ
echo $this->Html->script('assets/admin/pages/scripts/ecommerce-index.js');
echo $this->Html->script('assets/admin/pages/scripts/charts-flotcharts.js');
echo $this->Html->script('assets/admin/pages/scripts/table-advanced.js');
echo $this->Html->script('assets/global/plugins/flot/jquery.flot.min.js');
echo $this->Html->script('assets/global/plugins/flot/jquery.flot.resize.min.js');
echo $this->Html->script('assets/global/plugins/flot/jquery.flot.pie.min.js');
echo $this->Html->script('assets/global/plugins/flot/jquery.flot.stack.min.js');
echo $this->Html->script('assets/global/plugins/flot/jquery.flot.crosshair.min.js');
echo $this->Html->script('assets/global/plugins/flot/jquery.flot.categories.min.js');
echo $this->Html->script('assets/global/plugins/select2/select2.min.js');
echo $this->Html->script('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js');
echo $this->Html->script('assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js');
echo $this->Html->script('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js');
echo $this->Html->script('assets/admin/pages/scripts/ui-datepaginator.js');
echo $this->Html->script('assets/global/plugins/moment.min.js');
echo $this->Html->script('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js');
echo $this->Html->script('assets/global/plugins/bootstrap-datepaginator/bootstrap-datepaginator.min.js');
//debug($attendance_results);
?>
<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- BEGIN PAGE HEAD -->
	<div class="page-head">
		<div class="container">
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<h1>日報一覧 <small>Daily Reports</small></h1>
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
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
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
							<input id="datepicker" data-date-format="yyyy-mm-dd" class="form-control input-small date-picker" type="text" value="<?= $working_day; ?>" readonly>
							<script>
								$('#datepicker').datepicker({
									dateFormat: "yy-mm-dd",
									numberOfMonths: 2,
									minDate: 0,
									maxDate: '+1M'
								});
							</script>
						</div>
						<div class="col-md-6">
							<button type="button" class="btn red" onClick="goNextDay();"><i class="fa fa-check"></i>日付を選択する</button>
							<script>
								function goNextDay(){
									var date  = $("#datepicker").val();
									var url   = location.href;
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
			<!-- BEGIN PAGE CONTENT INNER -->
			<?if(isset($summaries)):?>
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<a class="dashboard-stat dashboard-stat-light red-intense" href="javascript:;">
							<div class="visual">
								<i class="fa fa-jpy fa-icon-medium"></i>
							</div>
							<div class="details">
								<div class="number">
									<?
									if(isset($summaries)){
										$total=0;
										foreach($summaries as $summary){ $total+=$summary['total']; }
										echo "¥".number_format($total);
									}
									?>
								</div>
								<div class="desc">
									ブランド別売上
								</div>
								<div class="desc">
									<?
									if(isset($summaries)){ foreach($summaries as $key => $summary){ echo $key.":¥".number_format($summary['total'])." "; } }
									?>
								</div>
							</div>
						</a>
					</div>
				</div>
				<?foreach($summaries as $key => $summary):?>
					<div class="row">
						<?if(isset($summary['Breakdown'])):?>
							<?$cnt=count($summary['Breakdown']);?>
							<?foreach($summary['Breakdown'] as $breakdown_name => $breakdown):?>
								<div class="col-lg-<?=12/$cnt;?> col-md-<?=12/$cnt;?> col-sm-<?=12/$cnt;?> col-xs-12">
									<a class="dashboard-stat dashboard-stat-light red-sunglo" href="javascript:;">
										<div class="visual">
											<i class="fa fa-jpy fa-icon-medium"></i>
										</div>
										<div class="details">
											<div class="number">
												¥<?=number_format($breakdown['total']);?>
											</div>
											<div class="desc">
												<?=$key;?>
											</div>
											<div class="desc">
												<?=$breakdown_name;?>売上
											</div>
										</div>
									</a>
								</div>
							<?endforeach;?>
						<?endif;?>
					</div>
				<?endforeach;?>
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<a class="dashboard-stat dashboard-stat-light blue-steel" href="javascript:;">
							<div class="visual">
								<i class="fa fa-users fa-icon-medium"></i>
							</div>
							<div class="details">
								<div class="number">
									<?
									if(isset($summaries)){
										$t=0;
										foreach($summaries as $summary){ $t+=$summary['visitors']; }
										echo number_format($t)."人";
									}
									?>
								</div>
								<div class="desc">
									ブランド別客数
								</div>
								<div class="desc">
									<?
									if(isset($summaries)){ foreach($summaries as $key => $summary){ echo $key.":".number_format($summary['visitors'])."人 "; } }
									?>
								</div>
							</div>
						</a>
					</div>

				</div>
				<?foreach($summaries as $key => $summary):?>
					<div class="row">
						<?if(isset($summary['Breakdown'])):?>
							<?$cnt=count($summary['Breakdown']);?>
							<?foreach($summary['Breakdown'] as $breakdown_name => $breakdown):?>
								<div class="col-lg-<?=12/$cnt;?> col-md-<?=12/$cnt;?> col-sm-<?=12/$cnt;?> col-xs-12">
									<a class="dashboard-stat dashboard-stat-light blue-madison" href="javascript:;">
										<div class="visual">
											<i class="fa fa-jpy fa-icon-medium"></i>
										</div>
										<div class="details">
											<div class="number">
												<?=number_format($breakdown['visitors']);?>人
											</div>
											<div class="desc">
												<?=$key;?>
											</div>
											<div class="desc">
												<?=$breakdown_name;?>客数
											</div>
										</div>
									</a>
								</div>
							<?endforeach;?>
						<?endif;?>
					</div>
				<?endforeach;?>
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-bottom-10">
						<a class="dashboard-stat dashboard-stat-light yellow-crusta" href="javascript:;">
							<div class="visual">
								<i class="fa fa-shopping-cart fa-icon-medium"></i>
							</div>
							<div class="details">
								<div class="number">
									<?
									if(isset($summaries)){
										$t=0;$v=0;
										foreach($summaries as $summary){ $t+=$summary['total'];$v+=$summary['visitors']; }
										if($v!=0){echo "¥".number_format($t/$v);}else{ echo "¥0";}
									}
									?>
								</div>
								<div class="desc">
									ブランド別客単価
								</div>
								<div class="desc">
									<?
									if(isset($summaries)){ foreach($summaries as $key => $summary){ echo $key.":¥".number_format($summary['total']/$summary['visitors'])." "; } }
									?>
								</div>
							</div>
						</a>
					</div>
				</div>
				<?foreach($summaries as $key => $summary):?>
					<div class="row">
						<?if(isset($summary['Breakdown'])):?>
							<?$cnt=count($summary['Breakdown']);?>
							<?foreach($summary['Breakdown'] as $breakdown_name => $breakdown):?>
								<div class="col-lg-<?=12/$cnt;?> col-md-<?=12/$cnt;?> col-sm-<?=12/$cnt;?> col-xs-12">
									<a class="dashboard-stat dashboard-stat-light yellow" href="javascript:;">
										<div class="visual">
											<i class="fa fa-jpy fa-icon-medium"></i>
										</div>
										<div class="details">
											<div class="number">
												¥<?=number_format($breakdown['total']/$breakdown['visitors']);?>
											</div>
											<div class="desc">
												<?=$key;?>
											</div>
											<div class="desc">
												<?=$breakdown_name;?>客単
											</div>
										</div>
									</a>
								</div>
							<?endforeach;?>
						<?endif;?>
					</div>
				<?endforeach;?>
			<?endif;?>
			<div class="row">
				<div class="col-md-12">
					<!-- Begin stat blocks -->
					<div class="row">
						<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
							<div class="dashboard-stat grey">
								<div class="visual">
									<i class="fa fa-spinner"></i>
								</div>
								<div class="details">
									<div class="number">
										<?if(isset($other_informations)){echo $other_informations['OtherInformation']['weather'];}?>
									</div>
									<div class="desc">
										天気
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="dashboard-stat green">
								<div class="visual">
									<i class="fa fa-flash"></i>
								</div>
								<div class="details">
									<div class="number">
										¥<?=number_format($labor_cost['part']+$labor_cost['full']);?>
									</div>
									<div class="desc">
										バイト(¥<?=number_format($labor_cost['part']);?>),社員(¥<?=number_format($labor_cost['full']);?>)
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
							<div class="dashboard-stat purple-studio">
								<div class="visual">
									<i class="fa fa-users"></i>
								</div>
								<div class="details">
									<div class="number">
										<?if($total!=0){ echo floor(($labor_cost['part']+$labor_cost['full'])/$total*1000)/10; }else{ echo 0;}?>%
									</div>
									<div class="desc">
										人件費率
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- End stat blocks -->
				</div>
			</div>
			<!-- END PAGE CONTENT INNER -->
			<!-- BEGIN ACCORDION PORTLET-->
			<div class="row">
				<div class="col-md-6">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold uppercase">その他取引アイテム</span>
								<span class="caption-helper">other items</span>
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
							</div>
						</div>
						<div class="portlet-body">
							<div class="panel-group accordion scrollable" id="accordion2">
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_1">
											クレジットカード&売掛</a>
										</h4>
									</div>
									<div id="collapse_2_1" class="panel-collapse collapse">
										<!-- BEGIN CONDENSED TABLE PORTLET-->
										<div class="portlet light">
											<div class="portlet-body">
												<div class="table-scrollable">
													<table class="table table-condensed table-hover">
														<thead>
														<tr>
															<th>
																#
															</th>
															<th>
																種類
															</th>
															<th>
																金額
															</th>
														</tr>
														</thead>
														<tbody>
														<?$credit_total=0;?>
														<?if(isset($credit_data)):?>
															<?$n=0;?>
															<?foreach ($credit_data as $credit): ?>
																<tr>
																	<td>
																		<?$n+=1;echo h($n);?>
																	</td>
																	<td>
																		<?= $credit['ReceiptSummary']['brand_name']; ?>
																	</td>
																	<td>
																		¥<?$credit_total+=$credit['ReceiptSummary']['credit'];echo number_format($credit['ReceiptSummary']['credit']);?>
																	</td>
																</tr>
															<?endforeach; ?>
														<?endif;?>
														</tbody>
													</table>
												</div>
												<div class="panel-body">
													<h3>¥<?=number_format($credit_total);?></h3>
												</div>
											</div>
										</div>
										<!-- END CONDENSED TABLE PORTLET-->
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_3">
												ポイント&金券</a>
										</h4>
									</div>
									<div id="collapse_2_3" class="panel-collapse collapse">
										<div class="portlet light">
											<div class="portlet-body">
												<div class="table-scrollable">
													<table class="table table-condensed table-hover">
														<thead>
														<tr>
															<th>
																#
															</th>
															<th>
																種類
															</th>
															<th>
																名前
															</th>
															<th>
																金額
															</th>
														</tr>
														</thead>
														<tbody>
														<?$voucher_total=0;?>
														<?if(isset($voucher_data)):?>
															<?$n=0;?>
															<?foreach ($voucher_data as $voucher): ?>
																<tr>
																	<td>
																		<?$n+=1;echo h($n);?>
																	</td>
																	<td>
																		<?= $voucher['ReceiptSummary']['brand_name']; ?>
																	</td>
																	<td>
																		¥<?$voucher_total+=$voucher['ReceiptSummary']['voucher'];echo number_format($voucher['ReceiptSummary']['voucher']);?>
																	</td>
																</tr>
															<?endforeach; ?>
														<?endif;?>
														</tbody>
													</table>
												</div>
												<div class="panel-body">
													<h3>¥<?=number_format($voucher_total);?></h3>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_4">
												割引/割増</a>
										</h4>
									</div>
									<div id="collapse_2_4" class="panel-collapse collapse">
										<div class="portlet light">
											<div class="portlet-body">
												<div class="table-scrollable">
													<table class="table table-condensed table-hover">
														<thead>
														<tr>
															<th>
																#
															</th>
															<th>
																種類
															</th>
															<th>
																名前
															</th>
															<th>
																金額
															</th>
														</tr>
														</thead>
														<tbody>
														<?$discount_total=0;?>
														<?if(isset($discount_data)):?>
															<?$n=0;?>
															<?foreach ($discount_data as $discount): ?>
																<tr>
																	<td>
																		<?$n+=1;echo h($n);?>
																	</td>
																	<td>
																		<?= $discount['ReceiptSummary']['brand_name']; ?>
																	</td>
																	<td>
																		¥<?$discount_total+=$discount['ReceiptSummary']['discount'];echo number_format($discount['ReceiptSummary']['discount']);?>
																	</td>
																</tr>
															<?endforeach; ?>
														<?endif;?>
														</tbody>
													</table>
												</div>
												<div class="panel-body">
													<h3>¥<?=number_format($discount_total);?></h3>
												</div>
											</div>

										</div>
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_2">
												売掛集金</a>
										</h4>
									</div>
									<div id="collapse_2_2" class="panel-collapse collapse">
										<div class="portlet light">
											<div class="portlet-body">
												<div class="table-scrollable">
													<table class="table table-condensed table-hover">
														<thead>
														<tr>
															<th>
																#
															</th>
															<th>
																名前
															</th>
															<th>
																金額
															</th>
														</tr>
														</thead>
														<tbody>
														<?$add_total=0;?>
														<?if(isset($add_cashes)):?>
															<?$n=0;?>
															<?php foreach ($add_cashes as $add_cash): ?>
																<tr>
																	<th>
																		<?$n+=1;echo h($n);?>
																	</th>
																	<th>
																		<?=$add_cash['AddCash']['name'];?>
																	</th>
																	<th>
																		¥<?$add_total+=$add_cash['AddCash']['fee'];echo number_format($add_cash['AddCash']['fee']); ?>
																	</th>
																</tr>
															<?php endforeach; ?>
														<?endif;?>
														</tbody>
													</table>
												</div>
												<div class="panel-body">
													<h3>¥<?=number_format($add_total);?></h3>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_5">
												支出</a>
										</h4>
									</div>
									<div id="collapse_2_5" class="panel-collapse collapse">
										<!-- BEGIN SAMPLE TABLE PORTLET-->
										<div class="portlet light">
											<div class="portlet-body">
												<div class="table-scrollable">
													<table class="table table-condensed table-hover">
														<thead>
														<tr>
															<th>
																#
															</th>
															<th>
																カテゴリ
															</th>
															<th>
																支出先
															</th>
															<th>
																購入品
															</th>
															<th>
																金額
															</th>
														</tr>
														</thead>
														<tbody>
														<?$expense_total=0;?>
														<?if(isset($expenses)):?>
															<?$n=0;?>
															<?foreach ($expenses as $expense): ?>
																<tr>
																	<th>
																		<?$n+=1;echo h($n);?>
																	</th>
																	<th>
																		<?=$expense['Type']['name']; ?>
																	</th>
																	<th>
																		<?=$expense['Expense']['store_name']; ?>
																	</th>
																	<th>
																		<?=$expense['Expense']['product_name']; ?>
																	</th>
																	<th>
																		¥<?$expense_total+=$expense['Expense']['fee'];echo h(number_format($expense['Expense']['fee'])); ?>
																	</th>
																</tr>
															<?php endforeach; ?>
														<?endif;?>
														</tbody>
													</table>
												</div>
												<div class="panel-body">
													<h3>¥<?=number_format($expense_total);?></h3>
												</div>
											</div>
										</div>
										<!-- END SAMPLE TABLE PORTLET-->
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_6">
												外税計</a>
										</h4>
									</div>
									<div id="collapse_2_6" class="panel-collapse collapse">
										<div class="panel-body">
											<h2>¥<?if(isset($tax_daily)){ echo number_format($tax_daily);}?></h2>
										</div>
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_7">
												現金計</a>
										</h4>
									</div>
									<div id="collapse_2_7" class="panel-collapse collapse">
										<div class="panel-body">
											<h2>¥<?=number_format($total-$credit_total-$voucher_total+$discount_total+$add_total-$expense_total);?></h2>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- BEGIN PAGE CONTENT INNER -->
				<div class="col-md-3">
					<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption font-green-sharp">
								<i class="icon-speech font-green-sharp"></i>
								<span class="caption-subject bold uppercase">その他</span>
								<span class="caption-helper">other info</span>
							</div>
							<div class="actions">
								<a href="#" class="btn btn-circle btn-default btn-icon-only fullscreen"></a>
							</div>
						</div>
						<div class="portlet-body">
							<div class="scroller" style="height:200px" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">
								<h5>【日報報告者】</h5>
								<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?if(isset($other_informations)){echo $other_informations['Member']['name'];}?></p>
								<h5>【社員公休】</h5>
								<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?if(isset($absences['one']['Member']['name'])){echo $absences['one']['Member']['name'];}?>, <?if(isset($absences['two']['Member']['name'])){echo $absences['two']['Member']['name'];}?>, <?if(isset($absences['three']['Member']['name'])){echo $absences['three']['Member']['name'];}?></p>
								<h5>【伝票番号】</h5>
								<?if(isset($slip_numbers)):?>
									<?foreach($slip_numbers as $slip_number):?>
										<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?echo $slip_number['Type']['name'];?>:<?echo $slip_number['SlipNumber']['start_number']; ?> ~ <?echo $slip_number['SlipNumber']['end_number']; ?></p>
									<?endforeach;?>
								<?endif;?>
							</div>
						</div>
					</div>
					<!-- END Portlet PORTLET-->
				</div>
				<div class="col-md-3">
					<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption font-green-sharp">
								<i class="icon-speech font-green-sharp"></i>
								<span class="caption-subject bold uppercase"> 備考欄</span>
								<span class="caption-helper">message</span>
							</div>
							<div class="actions">
								<a href="#" class="btn btn-circle btn-default btn-icon-only fullscreen"></a>
							</div>
						</div>
						<div class="portlet-body">
							<div class="scroller" style="height:200px" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">
								<h5>【宴会情報】</h5>
								<?if(isset($party_informations)):?>
								<?foreach($party_informations as $party_information):?>
									<p>コース名:<?echo $party_information['Type']['name']; ?>, 開始時刻:<?echo $party_information['PartyInformation']['starting_time']; ?>, 人数:<?echo $party_information['PartyInformation']['customer_count']; ?>, お名前:<?echo $party_information['PartyInformation']['customer_name']; ?></p>
								<?endforeach;?>
								<?endif;?>
								<p></p>
								<h5>【その他】</h5>
								<p>
									<?if(isset($other_informations)){echo nl2br($other_informations['OtherInformation']['notes']);} ?>
								</p>
							</div>
						</div>
					</div>
					<!-- END Portlet PORTLET-->
				</div>
			</div>
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-rocket font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold uppercase">スタッフ出勤一覧</span>
								<span class="caption-helper">
									<?=$this->Form->postLink('人員配置シート', array('action'=>'daily_report'),array('data' => array('date' => $working_day))); ?>
								</span>
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
							</div>
						</div>
						<div class="portlet-body">
							<table class="table table-striped table-bordered table-hover" id="sample_3">
								<thead>
								<tr>
									<th>
										氏名
									</th>
									<th>
										時間帯
									</th>
									<th>
										担当業務
									</th>
									<th>
										開始時間
									</th>
									<th>
										終了時間
									</th>
									<th>
										通常実働
									</th>
									<th>
										深夜実働
									</th>
									<th>
										休憩時間
									</th>
									<th>
										合計実働
									</th>
								</tr>
								</thead>
								<tbody>
								<?if(isset($attendance_results)):?>
									<?foreach ($attendance_results as $attendance_result): ?>
									<tr>
										<td>
											<?php echo $attendance_result['Member']['name']; ?>
										</td>
										<td>
											<?php echo $attendance_result['timezone']; ?>
										</td>
										<td>
											<?php echo $attendance_result['Member']['Position']['name']; ?>
										</td>
										<th>
											<?php echo date("H:i", strtotime($attendance_result['AttendanceResult']['attendance_start'])); ?>
										</th>
										<th>
											<?php echo date("H:i", strtotime($attendance_result['AttendanceResult']['attendance_end'])); ?>
										</th>
										<td>
											<?php echo $attendance_result['AttendanceResult']['hours']; ?>
										</td>
										<td>
											<?php echo $attendance_result['AttendanceResult']['late_hours']; ?>
										</td>
										<td>
											<?php echo $attendance_result['break']; ?>
										</td>
										<td>
											<?php echo $attendance_result['AttendanceResult']['hours']+$attendance_result['AttendanceResult']['late_hours']; ?>
										</td>
									</tr>
									<?endforeach; ?>
								<?endif;?>
								</tbody>
							</table>
						</div>
					</div>
					<!-- END EXAMPLE TABLE PORTLET-->
				</div>
			</div>
			<!-- END ACCORDION PORTLET-->
		</div>
	</div>
</div>
<!-- END PAGE CONTENT -->
<script>
	jQuery(document).ready(function() {
		Metronic.init(); // init metronic core components
		Layout.init(); // init current layout
		Demo.init(); // init demo features
		UIDatepaginator.init();
		ChartsFlotcharts.init();
		ChartsFlotcharts.initCharts();
		ChartsFlotcharts.initBarCharts();
		TableAdvanced.init();
	});
</script>