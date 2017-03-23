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

echo $this->Html->script('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js');
echo $this->Html->script('assets/global/plugins/bootstrap-datepaginator/bootstrap-datepaginator.min.js');
echo $this->Html->script('assets/global/plugins/clockface/js/clockface.js');
echo $this->Html->script('assets/global/plugins/bootstrap-daterangepicker/moment.min.js');
echo $this->Html->script('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js');
echo $this->Html->script('assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js');
echo $this->Html->script('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js');

echo $this->Html->script('assets/admin/pages/scripts/ui-datepaginator.js');
echo $this->Html->script('assets/admin/pages/scripts/components-form-tools.js');
echo $this->Html->script('assets/admin/pages/scripts/components-pickers.js');

//debug($location);
//exit;

?>
<?
echo $this->Form->create('Sales', array('action'=>'add', 'id'=>'form_submit'));
?>
<div class="page-container">
	<!-- BEGIN PAGE HEAD -->
	<div class="page-head">
		<div class="container">
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<h1>日報入力 <small>Daily Reports Entry</small></h1>
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
										<input id="datepicker" data-date-format="yyyy-mm-dd" class="form-control input-large date-picker" size="16" type="text" value="<?echo $working_day; ?>" readonly>
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
											//inputリセット
											$(document).ready(function () {
												$('#tab_4 .form-control').click(function () {
													$(this).val('');
												})
												$('#tab_5 .form-control').click(function () {
													$(this).val('');
												})
											})
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
				<input type="hidden" name="working_day" value="<?echo $working_day; ?>">
				<div class="row">
					<div class="col-md-12">
						<div class="tabbable tabbable-custom tabbable-noborder tabbable-reversed">
							<ul class="nav nav-tabs">
								<li class="active">
									<a href="#tab_0" data-toggle="tab">
										売上成績</a>
								</li>
								<li>
									<a href="#tab_1" data-toggle="tab">
										客数</a>
								</li>
								<li>
									<a href="#tab_2" data-toggle="tab">
										取引アイテム</a>
								</li>
								<li>
									<a href="#tab_3" data-toggle="tab">
										支出情報</a>
								</li>
								<li>
									<a href="#tab_4" data-toggle="tab">
										在庫管理</a>
								</li>
								<li>
									<a href="#tab_5" data-toggle="tab">
										買掛管理</a>
								</li>
								<li>
									<a href="#tab_6" data-toggle="tab">
										その他</a>
								</li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tab_0">
									<div class="row">
										<div class="col-md-6">
											<div class="portlet box red">
												<div class="portlet-title">
													<div class="caption">
														<i class="fa fa-gift"></i>売上内訳入力
													</div>
													<div class="tools">
														<a href="javascript:;" class="collapse">
														</a>
													</div>
												</div>
												<div class="portlet-body form">
													<!-- BEGIN FORM-->
													<div class="form-body">
														<?if(isset($total_fee)):?>
															<h3>合計値：¥<span id="totalSales"><?echo $total_fee;?></span></h3>
														<?endif;?>
														<?if(isset($sales_types['寿司'])):?>
															<h3 class="form-section">寿し和</h3>
															<?foreach($sales_types['寿司'] as $sales_type):?>
																<div class="row">
																	<div class="col-md-12">
																		<div class="form-group">
																			<label class="control-label"><?echo $sales_type['SalesType']['name'];?></label>
																			<div class="input-group">
																				<span class="input-group-addon"><i class="fa fa-jpy"></i></span>
																				<input type="hidden" name="sales[<?echo $sales_type['SalesType']['id'];?>][id]" value="<?if($sales_type['Today']!=null){echo $sales_type['Today']['Sales']['id'];}?>">
																				<input type="number" class="form-control" placeholder="例）100000" name="sales[<?echo $sales_type['SalesType']['id'];?>][fee]" value="<?if($sales_type['Today']!=null){echo $sales_type['Today']['Sales']['fee'];}?>">
																			</div>
																		</div>
																	</div>
																</div>
															<?endforeach;?>
														<?endif;?>
														<?if(isset($sales_types['焼肉'])):?>
															<h3 class="form-section">和光苑</h3>
															<?foreach($sales_types['焼肉'] as $sales_type):?>
																<div class="row">
																	<div class="col-md-12">
																		<div class="form-group">
																			<label class="control-label"><?echo $sales_type['SalesType']['name'];?></label>
																			<div class="input-group">
																				<span class="input-group-addon"><i class="fa fa-jpy"></i></span>
																				<input type="hidden" name="sales[<?echo $sales_type['SalesType']['id'];?>][id]" value="<?if($sales_type['Today']!=null){echo $sales_type['Today']['Sales']['id'];}?>">
																				<input type="number" class="form-control" placeholder="例）100000" name="sales[<?echo $sales_type['SalesType']['id'];?>][fee]" value="<?if($sales_type['Today']!=null){echo $sales_type['Today']['Sales']['fee'];}?>">
																			</div>
																		</div>
																	</div>
																</div>
															<?endforeach;?>
														<?endif;?>
														<?if(isset($sales_types['寿司・焼肉'])):?>
															<h3 class="form-section">寿司・焼肉</h3>
															<?foreach($sales_types['寿司・焼肉'] as $sales_type):?>
																<div class="row">
																	<div class="col-md-12">
																		<div class="form-group">
																			<label class="control-label"><?echo $sales_type['SalesType']['name'];?></label>
																			<div class="input-group">
																				<span class="input-group-addon"><i class="fa fa-jpy"></i></span>
																				<input type="hidden" name="sales[<?echo $sales_type['SalesType']['id'];?>][id]" value="<?if($sales_type['Today']!=null){echo $sales_type['Today']['Sales']['id'];}?>">
																				<input type="number" class="form-control" placeholder="例）100000" name="sales[<?echo $sales_type['SalesType']['id'];?>][fee]" value="<?if($sales_type['Today']!=null){echo $sales_type['Today']['Sales']['fee'];}elseif(isset($sales)){echo 0;}?>">
																			</div>
																		</div>
																	</div>
																</div>
															<?endforeach;?>
														<?endif;?>
													</div>
													<!-- END FORM-->
												</div>
											</div>
										</div>

										<?if(isset($sales_lunches)):?>
											<div class="col-md-6">
												<div class="portlet box green">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-gift"></i>ランチ売上入力
														</div>
														<div class="tools">
															<a href="javascript:;" class="collapse">
															</a>
														</div>
													</div>
													<div class="portlet-body form">
														<!-- BEGIN FORM-->
														<div class="form-body">
															<div class="row">
																<?if(isset($sales_lunches['寿司'])):?>
																	<div class="col-md-6">
																		<div class="form-group">
																			<label class="control-label">寿し和</label>
																			<div class="input-group">
																				<span class="input-group-addon">
																					<i class="fa fa-jpy"></i>
																				</span>
																				<input type="hidden" name="sales_lunch[<?echo $sales_lunches['寿司']['SalesLunch']['id'];?>][id]" value="<?if($sales_lunches['寿司']['SalesLunch']!=null){echo $sales_lunches['寿司']['SalesLunch']['id'];}?>">
																				<input type="text" class="form-control" placeholder="Enter Number" name="sales_lunch[<?echo $sales_lunches['寿司']['SalesLunch']['id'];?>][fee]" value="<?if($sales_lunches['寿司']['SalesLunch']!=null){echo $sales_lunches['寿司']['SalesLunch']['fee'];}?>">
																			</div>
																		</div>
																	</div>
																<?endif;?>
																<!--/span-->
																<?if(isset($sales_lunches['焼肉'])):?>
																	<div class="col-md-6">
																		<div class="form-group">
																			<label class="control-label">和光苑</label>
																			<div class="input-group">
																				<span class="input-group-addon">
																					<i class="fa fa-jpy"></i>
																				</span>
																				<input type="hidden" name="sales_lunch[<?echo $sales_lunches['焼肉']['SalesLunch']['id'];?>][id]" value="<?if($sales_lunches['焼肉']['SalesLunch']!=null){echo $sales_lunches['焼肉']['SalesLunch']['id'];}?>">
																				<input type="text" class="form-control" placeholder="Enter Number" name="sales_lunch[<?echo $sales_lunches['焼肉']['SalesLunch']['id'];?>][fee]" value="<?if($sales_lunches['焼肉']['SalesLunch']!=null){echo $sales_lunches['焼肉']['SalesLunch']['fee'];}?>">
																			</div>
																		</div>
																	</div>
																<?endif;?>
																<!--/span-->
															</div>
														</div>
														<!-- END FORM-->
													</div>
												</div>
											</div>
										<?endif;?>

										<div class="col-md-6">
											<div class="portlet box blue">
												<div class="portlet-title">
													<div class="caption">
														<i class="fa fa-gift"></i>カード売上入力
													</div>
													<div class="tools">
														<a href="javascript:;" class="collapse">
														</a>
													</div>
												</div>
												<div class="portlet-body form">
													<!-- BEGIN FORM-->

													<div class="form-body">
														<div id="credit_row" class="row">

															<?php if(isset($credit_sales)): ?><!--既に存在する-->
															<?php foreach ($credit_sales as $credit_sales_one): ?>
																<div class="row" style="padding-left: 20px;">
																<div class="col-md-4">
																	<label class="control-label">種類</label>
																	<div class="form-group">
																		<select class="form-control" name="credit[<?echo $credit_sales_one['CreditSales']['id'];?>][type_id]">
																			<option value="">選択してください</option>
																			<?php foreach ($credit_types as $credit_type): ?>
																				<option value="<?php echo $credit_type['CreditType']['id']; ?>" <?if($credit_sales_one['CreditSales']['type_id']==$credit_type['CreditType']['id']){echo "selected";}?>><?php echo $credit_type['CreditType']['name']; ?></option>
																			<?php endforeach; ?>
																		</select>
																	</div>
																</div>
																<div class="col-md-4">
																	<label class="control-label">金額</label>
																	<div class="form-group">
																		<div class="input-group">
																				<span class="input-group-addon">
																				<i class="fa fa-jpy"></i>
																				</span>
																			<input type="number" class="form-control" placeholder="例）2000" name="credit[<?echo $credit_sales_one['CreditSales']['id'];?>][fee]" value="<?echo $credit_sales_one['CreditSales']['fee']?>">
																		</div>
																	</div>
																</div>
																<div class="col-md-4">
																	<label class="control-label">削除</label>
																	<div class="form-group">
																		<div class="input-group">
																			<input type="button" value="削除する" class="btn red" onclick='var ok=confirm("本当に削除してもよろしいですか？");if (ok) location.href="<?echo $this->Html->url(array('controller'=>'sales', 'action'=>'credit_delete', '?' => array('id' => $credit_sales_one['CreditSales']['id'])));?>"'>
																		</div>
																	</div>
																</div>
																</div>
															<?php endforeach; ?>

															<?php else: ?><!--新規-->
														<?php for ($i=0; $i < 3; $i++): ?>
															<div class="col-md-6">
																<label class="control-label">種類</label>
																<div class="form-group">
																	<select class="form-control" name="new_credit[<?echo $i;?>][type_id]">
																		<option value="">選択してください</option>
																		<?php foreach ($credit_types as $credit_type): ?>
																			<option value="<?php echo $credit_type['CreditType']['id']; ?>"><?php echo $credit_type['CreditType']['name']; ?></option>
																		<?php endforeach; ?>
																	</select>
																</div>
															</div>
															<div class="col-md-6">
																<label class="control-label">金額</label>
																<div class="form-group">
																	<div class="input-group">
																				<span class="input-group-addon">
																				<i class="fa fa-jpy"></i>
																				</span>
																		<input type="number" class="form-control" placeholder="例）2000" name="new_credit[<?echo $i;?>][fee]" value="">
																	</div>
																</div>
															</div>
														<?php endfor; ?>
														<?php endif; ?>
															<!--/span-->
															<!--/span-->

														</div>
													</div>

													<div class="form-actions right">
														<button id="credit_button" type="button" class="btn green" onClick="addCredit();"><i class="fa fa-check"></i>追加</button>
														<input type="hidden" id="credit_i" value="<?if(isset($i)){echo $i;}else{$i=0;echo$i;}?>">
													</div>
													<script type="text/javascript">
														function addCredit(){
															//inum
															var inum = Number($('#credit_i').val());
															$('#credit_i').val(inum+1);
															//種類
															var d1 = $('<div>').addClass('col-md-6');
															var l1 = $('<label>').addClass('control-label').text('種類');
															var dc1 = $('<div>').addClass('form-group');

															var s1 = $('<select>').addClass('form-control').attr('name', "new_credit["+inum+"][type_id]");
															var o1 = $('<option>').text('選択してください').attr('value', '');

															s1 = s1.append(o1);
															var num = 0;
															var arr = [];
															<?foreach($credit_types as $credit_type):?>
															arr[num] =  $('<option>').text("<?echo $credit_type['CreditType']['name'];?>").attr('value', "<?echo $credit_type['CreditType']['id'];?>");
															num += 1;
															<?endforeach;?>
															for ( var i = 0; i < arr.length; ++i ) {
																// 配列の名前[i]を使った処理
																s1 = s1.append(arr[i]);
															}

															dc1 = dc1.append(s1);
															d1 = d1.append(l1).append(dc1);
															//金額
															var d2 = $('<div>').addClass('col-md-6');
															var l2 = $('<label>').addClass('control-label').text('金額');
															var dc2 = $('<div>').addClass('form-group');
															var dc3 = $('<div>').addClass('input-group');
															var sp1 = $('<span>').addClass('input-group-addon');
															var i1 = $('<i>').addClass('fa fa-jpy');
															var in1 = $('<input>').addClass('form-control').attr('placeholder', 'Enter Number').attr('type', 'text').attr('name', "new_credit["+inum+"][fee]");

															sp1 = sp1.append(i1);
															dc3 = dc3.append(sp1).append(in1);
															dc2 = dc2.append(dc3);
															d2 = d2.append(l2).append(dc2);
															$('#credit_row').append(d1);
															$('#credit_row').append(d2);
														}
													</script>
													<!-- END FORM-->
												</div>
											</div>
										</div>

									</div>
								</div>
								<!--BEGIN TAB 1-->
								<div class="tab-pane" id="tab_1">
									<div class="row">
										<?if(isset($customer_timezones['寿司'])):?>
											<div class="col-md-6">
												<div class="portlet box green-meadow">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-gift"></i>寿し和
														</div>
														<div class="tools">
															<a href="javascript:;" class="collapse">
															</a>
														</div>
													</div>
													<div class="portlet-body form">
														<!-- BEGIN FORM-->
														<div class="form-body">
															<?foreach($customer_timezones['寿司'] as $customer_timezone):?>
																<?if($customer_timezone['Attribute']['name']=='寿司'):?>
																<div class="row">
																	<label class="control-label col-md-2"><?echo date('H',strtotime($customer_timezone['CustomerTimezone']['name']));?>時</label>
																	<div class="col-md-9">
																		<div class="input-group" style="width:150px;">
																			<input type="hidden" name="customer[<?echo $customer_timezone['CustomerTimezone']['id'];?>][id]" value="<?if($customer_timezone['Today']!=null){echo $customer_timezone['Today']['CustomerCount']['id'];}?>">
																			<select class="form-control" name="customer[<?echo $customer_timezone['CustomerTimezone']['id'];?>][count]">
																				<option value="" <?if($customer_timezone['Today']==null){echo "selected";}?>>選択してください</option>
																				<?for($i=0; $i < 80; $i++):?>
																					<option value="<?echo $i; ?>" <?if($customer_timezone['Today']!=null&&$customer_timezone['Today']['CustomerCount']['count']==$i){echo "selected";}?>><?echo $i; ?></option>
																				<?php endfor; ?>
																			</select>
																		</div>
																	</div>
																</div>
																<?endif;?>
															<?endforeach;?>
														</div>
														<!-- END FORM-->
													</div>
												</div>
											</div>
										<?endif;?>
										<?if(isset($customer_timezones['焼肉'])):?><!--焼肉あり -->
											<div class="col-md-6">
												<div class="portlet box purple">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-gift"></i>和光苑
														</div>
														<div class="tools">
															<a href="javascript:;" class="collapse">
															</a>
														</div>
													</div>
													<div class="portlet-body form">
														<!-- BEGIN FORM-->
														<div class="form-body">
															<?foreach($customer_timezones['焼肉'] as $customer_timezone):?>
															<?if($customer_timezone['Attribute']['name']=='焼肉'):?>
																<div class="row">
																	<label class="control-label col-md-2"><?echo date('H',strtotime($customer_timezone['CustomerTimezone']['name']));?>時</label>
																	<div class="col-md-9">
																		<div class="input-group" style="width:150px;">
																			<input type="hidden" name="customer[<?echo $customer_timezone['CustomerTimezone']['id'];?>][id]" value="<?if($customer_timezone['Today']!=null){echo $customer_timezone['Today']['CustomerCount']['id'];}?>">
																			<select class="form-control" name="customer[<?echo $customer_timezone['CustomerTimezone']['id'];?>][count]">
																				<?for($i=0; $i < 80; $i++):?>
																					<option value="<?echo $i; ?>" <?if($customer_timezone['Today']['CustomerCount']['count']==$i){echo "selected";}?>><?echo $i; ?></option>
																				<?php endfor; ?>
																			</select>
																		</div>
																	</div>
																</div>
															<?endif;?>
															<?endforeach;?>
														</div>
														<!-- END FORM-->
													</div>
												</div>
											</div>
										<?endif;?>
									</div>
								</div>
								<!--END TAB1-->
								<!--BEGIN TAB 2-->
								<div class="tab-pane" id="tab_2">
									<div class="row">
										<div class="col-md-12">
											<div class="portlet box red-sunglo">
												<div class="portlet-title">
													<div class="caption">
														<i class="fa fa-gift"></i>クーポン割引入力
													</div>
													<div class="tools">
														<a href="javascript:;" class="collapse">
														</a>
													</div>
												</div>
												<div class="portlet-body form">
													<!-- BEGIN FORM-->

													<div class="form-body" id="ten_percent_row" >

														<?php if(isset($coupon_discounts)): ?>
															<?php foreach ($coupon_discounts as $coupon_discount): ?>
																<div class="row">
																	<div class="col-md-3">
																		<label class="control-label">種類</label>
																		<div class="form-group">
																			<select class="form-control" name="coupon[<?echo $coupon_discount['CouponDiscount']['id'];?>][type_id]">
																				<option value="">選択してください</option>
																				<?php foreach ($coupon_types as $coupon_type): ?>
																					<option value="<?php echo $coupon_type['CouponType']['id']; ?>" <?if($coupon_discount['CouponDiscount']['type_id']==$coupon_type['CouponType']['id']){echo "selected";}?>><?php echo $coupon_type['CouponType']['name']; ?></option>
																				<?php endforeach; ?>
																			</select>
																		</div>
																	</div>
																	<div class="col-md-3">
																		<label class="control-label">名前</label>
																		<div class="input-group">
																<span class="input-group-addon">
																<i class="fa fa-group"></i>
																</span>
																			<input type="text" class="form-control" placeholder="Enter Name" name="coupon[<?echo $coupon_discount['CouponDiscount']['id'];?>][customer_name]" value="<?echo $coupon_discount['CouponDiscount']['customer_name']; ?>">
																		</div>
																	</div>
																	<div class="col-md-3">
																		<div class="form-group">
																			<label class="control-label">金額</label>
																			<div class="input-group">
																				<span class="input-group-addon">
																				<i class="fa fa-jpy"></i>
																				</span>
																				<input type="number" class="form-control" placeholder="例）3000" name="coupon[<?echo $coupon_discount['CouponDiscount']['id'];?>][fee]" value="<?echo $coupon_discount['CouponDiscount']['fee']; ?>">
																			</div>
																		</div>
																	</div>
																	<div class="col-md-3">
																		<label class="control-label">削除</label>
																		<div class="form-group">
																			<input type="button" value="削除する" class="btn red" onclick='var ok=confirm("本当に削除してもよろしいですか？");if (ok) location.href="<?echo $this->Html->url(array('controller'=>'sales', 'action'=>'coupon_delete', '?' => array('id' => $coupon_discount['CouponDiscount']['id'])));?>"'>
																		</div>
																	</div>
																</div>
															<?php endforeach; ?>

														<?php else: ?>
															<?php for ($i=0; $i < 3; $i++): ?>
																<div class="row">
																	<div class="col-md-4">
																		<label class="control-label">種類</label>
																		<div class="form-group">
																			<select class="form-control" name="new_coupon[<?echo $i;?>][type_id]">
																				<option value="">選択してください</option>
																				<?php foreach ($coupon_types as $coupon_type): ?>
																					<option value="<?php echo $coupon_type['CouponType']['id']; ?>"><?php echo $coupon_type['CouponType']['name']; ?></option>
																				<?php endforeach; ?>
																			</select>
																		</div>
																	</div>
																	<div class="col-md-4">
																		<label class="control-label">名前</label>
																		<div class="input-group">
																<span class="input-group-addon">
																<i class="fa fa-group"></i>
																</span>
																			<input type="text" class="form-control" placeholder="Enter Name" name="new_coupon[<?echo $i;?>][customer_name]">
																		</div>
																	</div>
																	<div class="col-md-4">
																		<div class="form-group">
																			<label class="control-label">金額</label>
																			<div class="input-group">
																<span class="input-group-addon">
																<i class="fa fa-jpy"></i>
																</span>
																				<input type="number" class="form-control" placeholder="例）3000" name="new_coupon[<?echo $i;?>][fee]">
																			</div>
																		</div>
																	</div>
																</div>
															<?php endfor; ?>
														<?php endif; ?>
														<!--/span-->

														<!--/span-->

													</div>
												</div>
												<div class="form-actions right">
													<button type="button" class="btn green" onClick="addTenPercent();"><i class="fa fa-check"></i> 追加</button>
													<input type="hidden" id="coupon_i" value="<?if(isset($i)){echo $i;}else{$i=0;echo$i;}?>">
													<script type="text/javascript">
														function addTenPercent(){
															//inum
															var inum = Number($('#coupon_i').val());
															$('#coupon_i').val(inum+1);
															//種類
															var d1 = $('<div>').addClass('row');
															var dc1 = $('<div>').addClass('col-md-4');
															var l1 = $('<label>').addClass('control-label').text('種類');
															var dcc1 = $('<div>').addClass('form-group');
															var se1 = $('<select>').addClass('form-control').attr('name', 'new_coupon['+inum+'][type_id]');
															var o1 = $('<option>').attr('value', '').text('選択してください');

															se1 = se1.append(o1);
															var num = 0;
															var arr = [];
															<?foreach($coupon_types as $coupon_type):?>
															arr[num] =  $('<option>').text("<?echo $coupon_type['CouponType']['name'];?>").attr('value', "<?echo $coupon_type['CouponType']['id'];?>");
															num += 1;
															<?endforeach;?>
															for ( var i = 0; i < arr.length; ++i ) {
																// 配列の名前[i]を使った処理
																se1 = se1.append(arr[i]);
															}
															//挿入
															dcc1 = dcc1.append(se1);
															dc1 = dc1.append(l1).append(dcc1);

															var dc3 = $('<div>').addClass('col-md-4');
															var l3 = $('<label>').addClass('control-label').text('名前');
															var dcc3 = $('<div>').addClass('input-group');
															var sp2 = $('<span>').addClass('input-group-addon');
															var i2 = $('<i>').addClass('fa fa-group');
															var in2 = $('<input>').addClass('form-control').attr('type', 'text').attr('placeholder', 'Enter Name').attr('name', 'new_coupon['+inum+'][customer_name]');
															sp2 = sp2.append(i2);
															dcc3 = dcc3.append(sp2).append(in2);
															dc3 = dc3.append(l3).append(dcc3);

															var dc4 = $('<div>').addClass('col-md-4');
															var l4 = $('<label>').addClass('control-label').text('金額');
															var dcc4 = $('<div>').addClass('form-group');
															var dccc2 = $('<div>').addClass('input-group');
															var sp3 = $('<span>').addClass('input-group-addon');
															var i3 = $('<i>').addClass('fa fa-jpy');
															var in3 = $('<input>').addClass('form-control').attr('type', 'text').attr('placeholder', 'Enter Name').attr('name', 'new_coupon['+inum+'][fee]');
															sp3 = sp3.append(i3);
															dccc2 = dccc2.append(sp3).append(in3);
															dcc4 = dcc4.append(dccc2);
															dc4 = dc4.append(l4).append(dcc4);

															d1 = d1.append(dc1).append(dc3).append(dc4);
															//$(d1).appendTo("#check_row").hide().fadeIn(1000);
															$('#ten_percent_row').append(d1);

														}
													</script>
												</div>

												<!-- END FORM-->
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="portlet box yellow-crusta">
												<div class="portlet-title">
													<div class="caption">
														<i class="fa fa-gift"></i>支払いオプション入力
													</div>
													<div class="tools">
														<a href="javascript:;" class="collapse">
														</a>
													</div>
												</div>
												<div class="portlet-body form">
													<!-- BEGIN FORM-->

													<div id="check_row" class="form-body">
														<?php if(isset($other_discounts)): ?>
															<?php foreach ($other_discounts as $other_discount): ?>
																<div class="row">
																	<div class="col-md-3">
																		<label class="control-label">種類</label>
																		<div class="form-group">
																			<select class="form-control" name="other[<?echo $other_discount['OtherDiscount']['id'];?>][type_id]">
																				<option value="">選択してください</option>
																				<?php foreach ($other_types as $other_type): ?>
																					<option value="<?echo $other_type['OtherType']['id']; ?>" <?if($other_discount['OtherDiscount']['type_id']==$other_type['OtherType']['id']){echo "selected";}?>><?echo $other_type['OtherType']['name']; ?></option>
																				<?php endforeach; ?>
																			</select>
																		</div>
																	</div>
																	<div class="col-md-3">
																		<label class="control-label">名前</label>
																		<div class="input-group">
																<span class="input-group-addon">
																<i class="fa fa-group"></i>
																</span>
																			<input type="text" class="form-control" placeholder="Enter Name" name="other[<?echo $other_discount['OtherDiscount']['id'];?>][customer_name]" value="<?php echo $other_discount['OtherDiscount']['customer_name']; ?>">
																		</div>
																	</div>
																	<div class="col-md-3">
																		<div class="form-group">
																			<label class="control-label">金額</label>
																			<div class="input-group">
																<span class="input-group-addon">
																<i class="fa fa-jpy"></i>
																</span>
																				<input type="number" class="form-control" placeholder="例）3000" name="other[<?echo $other_discount['OtherDiscount']['id'];?>][fee]" value="<?php echo $other_discount['OtherDiscount']['fee']; ?>">
																			</div>
																		</div>
																	</div>
																	<div class="col-md-3">
																		<label class="control-label">削除</label>
																		<div class="form-group">
																			<input type="button" value="削除する" class="btn red" onclick='var ok=confirm("本当に削除してもよろしいですか？");if (ok) location.href="<?echo $this->Html->url(array('controller'=>'sales', 'action'=>'discount_delete', '?' => array('id' => $other_discount['OtherDiscount']['id'])));?>"'>
																		</div>
																	</div>
																</div>
															<?php endforeach; ?>
														<?php else: ?>
															<?php for ($i=0; $i < 3; $i++): ?>
																<div class="row">
																	<div class="col-md-4">
																		<label class="control-label">種類</label>
																		<div class="form-group">
																			<select class="form-control" name="new_other[<?echo $i;?>][type_id]">
																				<option value="">選択してください</option>
																				<?php foreach ($other_types as $other_type): ?>
																					<option value="<?echo $other_type['OtherType']['id']; ?>"><?echo $other_type['OtherType']['name']; ?></option>
																				<?php endforeach; ?>
																			</select>
																		</div>
																	</div>
																	<div class="col-md-4">
																		<label class="control-label">名前</label>
																		<div class="input-group">
																<span class="input-group-addon">
																<i class="fa fa-group"></i>
																</span>
																			<input type="text" class="form-control" placeholder="Enter Name" name="new_other[<?echo $i;?>][customer_name]">
																		</div>
																	</div>
																	<div class="col-md-4">
																		<div class="form-group">
																			<label class="control-label">金額</label>
																			<div class="input-group">
																<span class="input-group-addon">
																<i class="fa fa-jpy"></i>
																</span>
																				<input type="number" class="form-control" placeholder="例）3000" name="new_other[<?echo $i;?>][fee]">
																			</div>
																		</div>
																	</div>
																</div>
															<?php endfor; ?>
														<?php endif; ?>
														<!--/span-->
														<!--/span-->

													</div>
												</div>
												<div class="form-actions right">
													<button id="check_button" type="button" class="btn green" onClick="addCheck();"><i class="fa fa-check"></i> 追加</button>
													<input type="hidden" id="other_i" value="<?if(isset($i)){echo $i;}else{$i=0;echo$i;}?>">
												</div>
												<script type="text/javascript">
													function addCheck(){
														//inum
														var inum = Number($('#other_i').val());
														$('#other_i').val(inum+1);
														//種類
														var d1 = $('<div>').addClass('row');
														var dc1 = $('<div>').addClass('col-md-4');
														var l1 = $('<label>').addClass('control-label').text('種類');
														var dcc1 = $('<div>').addClass('form-group');
														var se1 = $('<select>').addClass('form-control').attr('name', 'new_other['+inum+'][type_id]');
														var o1 = $('<option>').attr('value', '').text('選択してください');

														se1 = se1.append(o1);
														var num = 0;
														var arr = [];
														<?foreach($other_types as $other_type):?>
														arr[num] =  $('<option>').text("<?echo $other_type['OtherType']['name'];?>").attr('value', "<?echo $other_type['OtherType']['id'];?>");
														num += 1;
														<?endforeach;?>
														for ( var i = 0; i < arr.length; ++i ) {
															// 配列の名前[i]を使った処理
															se1 = se1.append(arr[i]);
														}

														//挿入
														dcc1 = dcc1.append(se1);
														dc1 = dc1.append(l1).append(dcc1);

														var dc3 = $('<div>').addClass('col-md-4');
														var l3 = $('<label>').addClass('control-label').text('名前');
														var dcc3 = $('<div>').addClass('input-group');
														var sp2 = $('<span>').addClass('input-group-addon');
														var i2 = $('<i>').addClass('fa fa-group');
														var in2 = $('<input>').addClass('form-control').attr('type', 'text').attr('placeholder', 'Enter Name').attr('name', 'new_other['+inum+'][customer_name]');
														sp2 = sp2.append(i2);
														dcc3 = dcc3.append(sp2).append(in2);
														dc3 = dc3.append(l3).append(dcc3);

														var dc4 = $('<div>').addClass('col-md-4');
														var l4 = $('<label>').addClass('control-label').text('金額');
														var dcc4 = $('<div>').addClass('form-group');
														var dccc2 = $('<div>').addClass('input-group');
														var sp3 = $('<span>').addClass('input-group-addon');
														var i3 = $('<i>').addClass('fa fa-jpy');
														var in3 = $('<input>').addClass('form-control').attr('type', 'text').attr('placeholder', 'Enter Name').attr('name', 'new_other['+inum+'][fee]');
														sp3 = sp3.append(i3);
														dccc2 = dccc2.append(sp3).append(in3);
														dcc4 = dcc4.append(dccc2);
														dc4 = dc4.append(l4).append(dcc4);

														d1 = d1.append(dc1).append(dc3).append(dc4);
														//$(d1).appendTo("#check_row").hide().fadeIn(1000);
														$('#check_row').append(d1);

													}
												</script>
												<!-- END FORM-->
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="portlet box purple">
												<div class="portlet-title">
													<div class="caption">
														<i class="fa fa-gift"></i>売掛集金入力
													</div>
													<div class="tools">
														<a href="javascript:;" class="collapse">
														</a>
													</div>
												</div>
												<div class="portlet-body form">
													<div class="form-body">
														<?php if(isset($add_cashes)): ?>
															<?php foreach ($add_cashes as $add_cash): ?>
																<div class="row">
																	<div class="col-md-5">
																		<label class="control-label">名前</label>
																		<div class="form-group">
																			<div class="input-group">
																				<span class="input-group-addon">
																					<i class="fa fa-group"></i>
																				</span>
																				<input type="text" class="form-control" placeholder="Enter Number" name="addCash[<?echo $add_cash['AddCash']['id'];?>][name]" value="<?echo $add_cash['AddCash']['name'];?>">
																			</div>
																		</div>
																	</div>
																	<div class="col-md-5">
																		<label class="control-label">金額</label>
																		<div class="form-group">

																			<div class="input-group">
																				<span class="input-group-addon">
																					<i class="fa fa-jpy"></i>
																				</span>
																				<input type="text" class="form-control" placeholder="Enter Name" name="addCash[<?echo $add_cash['AddCash']['id'];?>][fee]" value="<?echo $add_cash['AddCash']['fee'];?>">
																			</div>
																		</div>
																	</div>
																	<div class="col-md-2">
																		<label class="control-label">削除</label>
																		<div class="form-group">
																			<input type="button" value="削除する" class="btn red" onclick='var ok=confirm("本当に削除してもよろしいですか？");if (ok) location.href="<?echo $this->Html->url(array('controller'=>'sales', 'action'=>'addCash_delete', '?' => array('id' => $add_cash['AddCash']['id'])));?>"'>
																		</div>
																	</div>
																</div>
															<?php endforeach; ?>
														<?php else: ?>
															<?php for ($i=0; $i < 4; $i++): ?>
																<div class="row">
																	<div class="col-md-6">
																		<label class="control-label">名前</label>
																		<div class="form-group">
																			<div class="input-group">
																				<span class="input-group-addon">
																					<i class="fa fa-group"></i>
																				</span>
																				<input type="text" class="form-control" placeholder="例）山田たろう" name="new_addCash[<?echo $i;?>][name]">
																			</div>
																		</div>
																	</div>
																	<div class="col-md-6">
																		<label class="control-label">金額</label>
																		<div class="form-group">
																			<div class="input-group">
																				<span class="input-group-addon">
																					<i class="fa fa-jpy"></i>
																				</span>
																				<input type="text" class="form-control" placeholder="例）10000" name="new_addCash[<?echo $i;?>][fee]">
																			</div>
																		</div>
																	</div>
																</div>
															<?php endfor; ?>
														<?php endif; ?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!--END TAB1-->
								<!--BEGIN TAB 3-->
								<div class="tab-pane" id="tab_3">
									<div class="row">
										<div class="col-md-12">
											<div class="portlet box blue-madison">
												<div class="portlet-title">
													<div class="caption">
														<i class="fa fa-gift"></i>支出情報入力
													</div>
													<div class="tools">
														<a href="javascript:;" class="collapse">
														</a>
													</div>
												</div>
												<div class="portlet-body form">
													<!-- BEGIN FORM-->

													<div id="expense_row" class="form-body">
														<?php if(isset($expenses)): ?>
															<?php foreach ($expenses as $expense): ?>
																<div class="row">
																	<div class="col-md-2">
																		<label class="control-label">種類</label>
																		<div class="form-group">
																			<select class="form-control" name="expense[<?echo $expense['Expense']['id'];?>][type_id]">
																				<option value="">選択してください</option>
																				<?php foreach ($expense_types as $expense_type): ?>
																					<option value="<?echo $expense_type['ExpenseType']['id']; ?>" <?if($expense['Expense']['type_id']==$expense_type['ExpenseType']['id']){echo "selected";}?>><?echo $expense_type['ExpenseType']['name']; ?></option>
																				<?php endforeach; ?>
																			</select>
																		</div>
																	</div>
																	<div class="col-md-3">
																		<label class="control-label">支出先名</label>
																		<div class="form-group">

																			<div class="input-group">
																<span class="input-group-addon">
																<i class="fa fa-truck"></i>
																</span>
																				<input type="text" class="form-control" placeholder="Enter Name" name="expense[<?echo $expense['Expense']['id'];?>][store_name]" value="<?echo $expense['Expense']['store_name']; ?>">
																			</div>
																		</div>
																	</div>
																	<div class="col-md-3">
																		<label class="control-label">購入品名</label>
																		<div class="input-group">
																<span class="input-group-addon">
																<i class="fa fa-ticket"></i>
																</span>
																			<input type="text" class="form-control" placeholder="Enter Name" name="expense[<?echo $expense['Expense']['id'];?>][product_name]" value="<?echo $expense['Expense']['product_name']; ?>">
																		</div>
																	</div>
																	<div class="col-md-2">
																		<label class="control-label">金額</label>
																		<div class="form-group">

																			<div class="input-group">
																<span class="input-group-addon">
																<i class="fa fa-jpy"></i>
																</span>
																				<input type="number" class="form-control" placeholder="例）5000" name="expense[<?echo $expense['Expense']['id'];?>][fee]" value="<?echo $expense['Expense']['fee']; ?>">
																			</div>
																		</div>
																	</div>
																	<div class="col-md-1">
																		<label class="control-label">削除</label>
																		<div class="form-group">
																			<input type="button" value="削除する" class="btn red" onclick='var ok=confirm("本当に削除してもよろしいですか？");if (ok) location.href="<?echo $this->Html->url(array('controller'=>'sales', 'action'=>'expense_delete', '?' => array('id' => $expense['Expense']['id'])));?>"'>
																		</div>
																	</div>
																</div>
															<?php endforeach; ?>

														<?php else: ?>
															<?php for ($i=0; $i < 5; $i++): ?>
																<div class="row">
																	<div class="col-md-3">
																		<label class="control-label">種類</label>
																		<div class="form-group">
																			<select class="form-control" name="new_expense[<?echo $i;?>][type_id]">
																				<option value="">選択してください</option>
																				<?php foreach ($expense_types as $expense_type): ?>
																					<option value="<?echo $expense_type['ExpenseType']['id']; ?>"><?echo $expense_type['ExpenseType']['name']; ?></option>
																				<?php endforeach; ?>
																			</select>
																		</div>
																	</div>
																	<div class="col-md-3">
																		<label class="control-label">支出先名</label>
																		<div class="form-group">

																			<div class="input-group">
																<span class="input-group-addon">
																	<i class="fa fa-truck"></i>
																</span>
																				<input type="text" class="form-control" placeholder="Enter Name" name="new_expense[<?echo $i;?>][store_name]">
																			</div>
																		</div>
																	</div>
																	<div class="col-md-3">
																		<label class="control-label">購入品名</label>
																		<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-ticket"></i>
															</span>
																			<input type="text" class="form-control" placeholder="Enter Name" name="new_expense[<?echo $i;?>][product_name]">
																		</div>
																	</div>
																	<div class="col-md-3">
																		<label class="control-label">金額</label>
																		<div class="form-group">

																			<div class="input-group">
																<span class="input-group-addon">
																<i class="fa fa-jpy"></i>
																</span>
																				<input type="number" class="form-control" placeholder="例）5000" name="new_expense[<?echo $i;?>][fee]">
																			</div>
																		</div>
																	</div>
																</div>
															<?php endfor; ?>

														<?php endif; ?>

														<!--/span-->
													</div>
													<div class="form-actions right">
														<button id="expense_button" type="button" class="btn green" onClick="addExpense();"><i class="fa fa-check"></i> 追加</button>
														<input type="hidden" id="expense_i" value="<?if(isset($i)){echo $i;}else{$i=0;echo$i;}?>">
													</div>
													<script type="text/javascript">
														function addExpense(){
															//inum
															var inum = Number($('#expense_i').val());
															$('#expense_i').val(inum+1);
															//種類
															var d1 = $('<div>').addClass('row');
															var dc1 = $('<div>').addClass('col-md-3');
															var l1 = $('<label>').addClass('control-label').text('種類');
															var dcc1 = $('<div>').addClass('form-group');
															var se1 = $('<select>').addClass('form-control').attr('name', 'new_expense['+inum+'][type_id]');
															var o1 = $('<option>').attr('value', '').text('選択してください');

															se1 = se1.append(o1);
															var num = 0;
															var arr = [];
															<?foreach($expense_types as $expense_type):?>
															arr[num] =  $('<option>').text("<?echo $expense_type['ExpenseType']['name'];?>").attr('value', "<?echo $expense_type['ExpenseType']['id'];?>");
															num += 1;
															<?endforeach;?>
															for ( var i = 0; i < arr.length; ++i ) {
																// 配列の名前[i]を使った処理
																se1 = se1.append(arr[i]);
															}

															//挿入
															dcc1 = dcc1.append(se1);
															dc1 = dc1.append(l1).append(dcc1);

															var dc2 = $('<div>').addClass('col-md-3');
															var l2 = $('<label>').addClass('control-label').text('支出先名');
															var dcc2 = $('<div>').addClass('form-group');
															var dccc1 = $('<div>').addClass('input-group');
															var sp1 = $('<span>').addClass('input-group-addon');
															var i1 = $('<i>').addClass('fa fa-truck');
															var in1 = $('<input>').addClass('form-control').attr('type', 'text').attr('placeholder', 'Enter Name').attr('name', 'new_expense['+inum+'][store_name]');
															sp1 = sp1.append(i1);
															dccc1 = dccc1.append(sp1).append(in1);
															dcc2 = dcc2.append(dccc1);
															dc2 = dc2.append(l2).append(dcc2);

															var dc3 = $('<div>').addClass('col-md-3');
															var l3 = $('<label>').addClass('control-label').text('購入品名');
															var dcc3 = $('<div>').addClass('input-group');
															var sp2 = $('<span>').addClass('input-group-addon');
															var i2 = $('<i>').addClass('fa fa-ticket');
															var in2 = $('<input>').addClass('form-control').attr('type', 'text').attr('placeholder', 'Enter Name').attr('name', 'new_expense['+inum+'][product_name]');
															sp2 = sp2.append(i2);
															dcc3 = dcc3.append(sp2).append(in2);
															dc3 = dc3.append(l3).append(dcc3);

															var dc4 = $('<div>').addClass('col-md-3');
															var l4 = $('<label>').addClass('control-label').text('金額');
															var dcc4 = $('<div>').addClass('form-group');
															var dccc2 = $('<div>').addClass('input-group');
															var sp3 = $('<span>').addClass('input-group-addon');
															var i3 = $('<i>').addClass('fa fa-jpy');
															var in3 = $('<input>').addClass('form-control').attr('type', 'text').attr('placeholder', 'Enter Name').attr('name', 'new_expense['+inum+'][fee]');
															sp3 = sp3.append(i3);
															dccc2 = dccc2.append(sp3).append(in3);
															dcc4 = dcc4.append(dccc2);
															dc4 = dc4.append(l4).append(dcc4);

															d1 = d1.append(dc1).append(dc2).append(dc3).append(dc4);
															$('#expense_row').append(d1);

														}
													</script>

													<!-- END FORM-->
												</div>
											</div>
										</div>
									</div>
								</div>
								<!--END TAB3-->
								<!--BEGIN TAB 4-->
								<div class="tab-pane" id="tab_4">
									<div class="row">
										<div class="col-md-12">
											<div class="portlet box green">
												<div class="portlet-title">
													<div class="caption">
														<i class="fa fa-gift"></i>在庫管理
													</div>
													<div class="tools">
														<a href="javascript:;" class="collapse">
														</a>
													</div>
												</div>
												<div class="portlet-body form">
													<!-- BEGIN FORM-->
													<table class="table table-bordered table-striped table-condensed flip-content">
														<thead class="flip-content">
														<tr>
															<th width="20%">
																品名
															</th>
															<th class="numeric">
																前日残
															</th>
															<th class="numeric">
																仕入
															</th>
															<th class="numeric">
																本日残
															</th>
														</tr>
														</thead>
														<tbody>
															<?if(isset($inventory_types)):?>
																<?$num = 0;?>
															<?foreach($inventory_types as $inventory_type):?>
															<tr>
																<td>
																	<div class="panel panel-warning">
																		<div class="panel-heading">
																			<?echo $inventory_type['InventoryType']['name'];?>
																		</div>
																	</div>
																</td>
																<td class="numeric">
																	<div class="panel panel-info">
																		<div class="panel-heading">
																			<?if($inventory_type['Before']!=null){echo $inventory_type['Before']['Inventory']['rest'];}?>
																			<input type="hidden" name="inventory[<?echo $inventory_type['InventoryType']['id'];?>][before_rest]" value="<?if($inventory_type['Before']!=null){echo $inventory_type['Before']['Inventory']['rest'];}?>">
																		</div>
																	</div>
																</td>
																<td class="numeric">
																	<div class="input-group">
																		<span class="input-group-addon">
																			<i class="fa fa-sign-in"></i>
																		</span>
																		<input type="number" class="form-control" placeholder="例）5" name="inventory[<?echo $inventory_type['InventoryType']['id'];?>][income]" value="<?if($inventory_type['Today']==null){echo 0;}else{echo $inventory_type['Today']['Inventory']['income'];}?>">
																	</div>
																</td>
																<td class="numeric">
																	<div class="input-group">
																		<span class="input-group-addon">
																			<i class="fa fa-sign-out"></i>
																		</span>
																		<input type="number" class="form-control" placeholder="例）10" name="inventory[<?echo $inventory_type['InventoryType']['id'];?>][outcome]" value="<?if($inventory_type['Today']==null){echo 0;}else{echo $inventory_type['Today']['Inventory']['rest'];}?>">
																	</div>
																</td>
															</tr>
															<?endforeach;?>
															<?endif;?>
														</tbody>
													</table>
													<!-- END FORM-->
												</div>
											</div>
										</div>
									</div>
								</div>
								<!--END TAB4-->
								<!--BEGIN TAB 5-->
								<div class="tab-pane" id="tab_5">
									<div class="row">
										<div class="col-md-12">
											<div class="portlet box purple">
												<div class="portlet-title">
													<div class="caption">
														<i class="fa fa-gift"></i>買掛管理
													</div>
													<div class="tools">
														<a href="javascript:;" class="collapse">
														</a>
													</div>
												</div>
												<!--20150829改変-->
												<div class="portlet-body form">
													<div class="form-body">
														<?if(isset($account_types)):?>
															<?foreach($account_types as $account_type):?>
																<div class="row">
																	<div class="col-md-12">
																		<div class="form-group">
																			<label class="control-label"><?echo $account_type['AccountType']['name'];?>合計</label>
																			<div class="input-group">
																				<span class="input-group-addon"><i class="fa fa-jpy"></i></span>
																				<input type="hidden" name="account[<?echo $account_type['AccountType']['id'];?>][id]" value="<?if($account_type['Today']!=null){echo $account_type['Today']['PayableAccount']['id'];}?>">
																				<input type="number" class="form-control" placeholder="例）8000" name="account[<?echo $account_type['AccountType']['id'];?>][fee]" value="<?if($account_type['Today']==null){echo 0;}else{echo $account_type['Today']['PayableAccount']['fee'];}?>">
																			</div>
																		</div>
																	</div>
																</div>
															<?endforeach;?>
														<?endif;?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!--END TAB5-->
								<!--BEGIN TAB 6-->
								<div class="tab-pane" id="tab_6">
									<div class="row">
										<div class="col-md-3" >
											<div class="portlet box red">
												<div class="portlet-title">
													<div class="caption">
														<i class="fa fa-gift"></i>日報入力者名
													</div>
													<div class="tools">
														<a href="javascript:;" class="collapse">
														</a>
													</div>
												</div>
												<div class="portlet-body form">
													<!-- BEGIN FORM-->

													<div class="form-body">
														<div class="row">
															<div class="col-md-12">
																<div class="form-group">
																	<select class="form-control" name="OtherInformation[member_id]">
																		<option value="">選択してください</option>
																		<?php foreach ($members as $member): ?>
																			<option value="<?echo $member['Member']['id']; ?>" <?if(isset($other_informations)&&$other_informations['OtherInformation']['member_id']==$member['Member']['id']){echo "selected";}?>><?echo $member['Member']['name']; ?></option>
																		<?php endforeach; ?>
																	</select>
																</div>
															</div>

														</div>
													</div>

													<!-- END FORM-->
												</div>
											</div>
										</div>
										<div class="col-md-3">
											<div class="portlet box yellow">
												<div class="portlet-title">
													<div class="caption">
														<i class="fa fa-gift"></i>天候情報
													</div>
													<div class="tools">
														<a href="javascript:;" class="collapse">
														</a>
													</div>
												</div>
												<div class="portlet-body form">
													<!-- BEGIN FORM-->

													<div class="form-body">
														<div class="row">
															<div class="col-md-12">
																<div class="form-group">
																	<select class="form-control" name="OtherInformation[weather]">
																		<option value="">選択してください</option>
																		<option value="晴" <?php if(isset($other_informations)&&$other_informations['OtherInformation']['weather'] == '晴'){ echo h('selected'); } ?>>晴</option>
																		<option value="曇" <?php if(isset($other_informations)&&$other_informations['OtherInformation']['weather'] == '曇'){ echo h('selected'); } ?>>曇</option>
																		<option value="雨" <?php if(isset($other_informations)&&$other_informations['OtherInformation']['weather'] == '雨'){ echo h('selected'); } ?>>雨</option>
																		<option value="雪" <?php if(isset($other_informations)&&$other_informations['OtherInformation']['weather'] == '雪'){ echo h('selected'); } ?>>雪</option>
																	</select>
																</div>
															</div>
															<!--/span-->

														</div>
													</div>


													<!-- END FORM-->
												</div>
											</div>
										</div>

										<div class="col-md-3">
											<div class="portlet box blue">
												<div class="portlet-title">
													<div class="caption">
														<i class="fa fa-gift"></i>外税欄
													</div>
													<div class="tools">
														<a href="javascript:;" class="collapse">
														</a>
													</div>
												</div>
												<div class="portlet-body form">
													<!-- BEGIN FORM-->
													<div class="form-body">
														<div class="row">
															<div class="col-md-12">
																<div class="form-group">
																	<div class="input-group">
																		<span class="input-group-addon">
																			<i class="fa fa-jpy"></i>
																		</span>
																		<input type="number" class="form-control" placeholder="Enter Number" name="OtherInformation[tax]" value="<?if(isset($other_informations['OtherInformation']['tax'])){echo $other_informations['OtherInformation']['tax'];}else{echo 0;}?>">
																	</div>
																</div>
															</div>
															<!--/span-->
														</div>
													</div>
													<!-- END FORM-->
												</div>
											</div>
										</div>

										<div class="col-md-3">
											<div class="portlet box blue">
												<div class="portlet-title">
													<div class="caption">
														<i class="fa fa-gift"></i>備考欄
													</div>
													<div class="tools">
														<a href="javascript:;" class="collapse">
														</a>
													</div>
												</div>
												<div class="portlet-body form">
													<!-- BEGIN FORM-->
													<div class="form-body">
														<div class="row">
															<div class="col-md-12">
																<div class="form-group">
																	<textarea class="form-control" rows="1" placeholder="Enter Text Here" name="OtherInformation[notes]"><?if(isset($other_informations['OtherInformation']['notes'])){echo $other_informations['OtherInformation']['notes'];}?></textarea>
																	<?if(isset($other_informations)):?>
																		<input type="hidden" name="OtherInformation[id]" value="<?echo $other_informations['OtherInformation']['id'];?>">
																	<?endif;?>
																</div>
															</div>
															<!--/span-->
														</div>
													</div>
													<!-- END FORM-->
												</div>
											</div>
										</div>

										<div class="col-md-4">
											<div class="portlet box green">
												<div class="portlet-title">
													<div class="caption">
														<i class="fa fa-gift"></i>社員公休1
													</div>
													<div class="tools">
														<a href="javascript:;" class="collapse">
														</a>
													</div>
												</div>
												<div class="portlet-body form">
													<!-- BEGIN FORM-->

													<div class="form-body">
														<div class="row">
															<div class="col-md-12">
																<div class="form-group">
																	<select class="form-control" name="OtherInformation[absence_one_id]">
																		<option value="">選択してください</option>
																		<?php foreach ($members as $member): ?>
																			<?if($member['Type']['name']=="社員"):?>
																				<option value="<?echo $member['Member']['id']; ?>" <?if(isset($other_informations)&&$other_informations['OtherInformation']['absence_one_id']==$member['Member']['id']){echo "selected";}?>><?echo $member['Member']['name']; ?></option>
																			<?endif;?>
																		<?php endforeach; ?>
																	</select>
																</div>
															</div>

														</div>
													</div>

													<!-- END FORM-->
												</div>
											</div>
										</div>

										<div class="col-md-4">
											<div class="portlet box green">
												<div class="portlet-title">
													<div class="caption">
														<i class="fa fa-gift"></i>社員公休2
													</div>
													<div class="tools">
														<a href="javascript:;" class="collapse">
														</a>
													</div>
												</div>
												<div class="portlet-body form">
													<!-- BEGIN FORM-->

													<div class="form-body">
														<div class="row">
															<div class="col-md-12">
																<div class="form-group">
																	<select class="form-control" name="OtherInformation[absence_two_id]">
																		<option value="">選択してください</option>
																		<?php foreach ($members as $member): ?>
																			<?if($member['Type']['name']=="社員"):?>
																				<option value="<?echo $member['Member']['id']; ?>" <?if(isset($other_informations)&&$other_informations['OtherInformation']['absence_two_id']==$member['Member']['id']){echo "selected";}?>><?echo $member['Member']['name']; ?></option>
																			<?endif;?>
																		<?php endforeach; ?>
																	</select>
																</div>
															</div>

														</div>
													</div>

													<!-- END FORM-->
												</div>
											</div>
										</div>

										<div class="col-md-4">
											<div class="portlet box green">
												<div class="portlet-title">
													<div class="caption">
														<i class="fa fa-gift"></i>社員公休3
													</div>
													<div class="tools">
														<a href="javascript:;" class="collapse">
														</a>
													</div>
												</div>
												<div class="portlet-body form">
													<!-- BEGIN FORM-->

													<div class="form-body">
														<div class="row">
															<div class="col-md-12">
																<div class="form-group">
																	<select class="form-control" name="OtherInformation[absence_three_id]">
																		<option value="">選択してください</option>
																		<?php foreach ($members as $member): ?>
																			<?if($member['Type']['name']=="社員"):?>
																				<option value="<?echo $member['Member']['id']; ?>" <?if(isset($other_informations)&&$other_informations['OtherInformation']['absence_three_id']==$member['Member']['id']){echo "selected";}?>><?echo $member['Member']['name']; ?></option>
																			<?endif;?>
																		<?php endforeach; ?>
																	</select>
																</div>
															</div>

														</div>
													</div>

													<!-- END FORM-->
												</div>
											</div>
										</div>


		<div class="col-md-12">
			<div class="portlet box purple">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-gift"></i>宴会情報入力
					</div>
					<div class="tools">
						<a href="javascript:;" class="collapse">
						</a>
					</div>
				</div>
				<div class="portlet-body form">
					<div id="party_row" class="form-body">
						<?php if(isset($party_informations)): ?>
							<?php foreach ($party_informations as $party_information): ?>
								<div class="row">
									<div class="col-md-2">
										<label class="control-label">コース名</label>
										<div class="form-group">
											<select class="form-control" name="party[<?echo $party_information['PartyInformation']['id'];?>][type_id]">
												<option value="">選択してください</option>
												<?php foreach ($party_types as $party_type): ?>
													<option value="<?echo $party_type['PartyType']['id']; ?>" <?if($party_information['PartyInformation']['type_id']==$party_type['PartyType']['id']){echo "selected";}?>><?echo $party_type['PartyType']['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
									<div class="col-md-3">
										<label class="control-label">開始時間</label>
										<div class="input-group">
											<input type="text" class="form-control" placeholder="Enter Hours" name="party[<?echo $party_information['PartyInformation']['id'];?>][starting_time]" value="<?echo $party_information['PartyInformation']['starting_time'];?>">
											<span class="input-group-btn">
												<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
											</span>
										</div>
									</div>
									<div class="col-md-2">
										<label class="control-label">人数</label>
										<div class="form-group">

											<div class="input-group">
																<span class="input-group-addon">
																<i class="fa fa-truck"></i>
																</span>
												<input type="text" class="form-control" placeholder="Enter Name" name="party[<?echo $party_information['PartyInformation']['id'];?>][customer_count]" value="<?echo $party_information['PartyInformation']['customer_count'];?>">
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<label class="control-label">名前</label>
										<div class="form-group">

											<div class="input-group">
																<span class="input-group-addon">
																<i class="fa fa-jpy"></i>
																</span>
												<input type="text" class="form-control" placeholder="Enter Number" name="party[<?echo $party_information['PartyInformation']['id'];?>][customer_name]" value="<?echo $party_information['PartyInformation']['customer_name'];?>">
											</div>
										</div>
									</div>
									<div class="col-md-2">
										<label class="control-label">削除</label>
										<div class="form-group">
											<input type="button" value="削除する" class="btn red" onclick='var ok=confirm("本当に削除してもよろしいですか？");if (ok) location.href="<?echo $this->Html->url(array('controller'=>'sales', 'action'=>'party_delete', '?' => array('id' => $party_information['PartyInformation']['id'])));?>"'>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						<?php else: ?>
							<?php for ($i=0; $i < 4; $i++): ?>
								<div class="row">
									<div class="col-md-3">
										<label class="control-label">コース名</label>
										<div class="form-group">
											<select class="form-control" name="new_party[<?echo $i;?>][type_id]">
												<option value="">選択してください</option>
												<?php foreach ($party_types as $party_type): ?>
													<option value="<?echo $party_type['PartyType']['id']; ?>"><?echo $party_type['PartyType']['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
									<div class="col-md-3">
										<label class="control-label">開始時間</label>
										<div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-clock-o"></i>
											</span>
											<input type="text" class="form-control" placeholder="例）16:00" name="new_party[<?echo $i;?>][starting_time]" value="">
										</div>
									</div>
									<div class="col-md-3">
										<label class="control-label">人数</label>
										<div class="form-group">

											<div class="input-group">
												<span class="input-group-addon">
													<i class="fa fa-sort-numeric-asc"></i>
												</span>
												<input type="text" class="form-control" placeholder="例）10" name="new_party[<?echo $i;?>][customer_count]">
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<label class="control-label">名前</label>
										<div class="form-group">

											<div class="input-group">
																<span class="input-group-addon">
																<i class="fa fa-jpy"></i>
																</span>
												<input type="text" class="form-control" placeholder="例）山田たろう" name="new_party[<?echo $i;?>][customer_name]">
											</div>
										</div>
									</div>
								</div>
							<?php endfor; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>


										<div class="col-md-12">
											<div class="portlet box blue-hoki">
												<div class="portlet-title">
													<div class="caption">
														<i class="fa fa-gift"></i>伝票番号
													</div>
													<div class="tools">
														<a href="javascript:;" class="collapse">
														</a>
													</div>
												</div>
												<div class="portlet-body form">
													<!-- BEGIN FORM-->
													<div class="form-body">
														<?foreach($slip_types as $slip_type):?>
															<div class="row">
																<div class="col-md-6">
																	<div class="form-group">
																		<label class="control-label"><?echo $slip_type['SlipType']['name'];?>(開始)</label>
																		<div class="input-group">
																			<span class="input-group-addon">
																				<i class="fa fa-sort-numeric-asc"></i>
																			</span>
																			<input type="hidden" name="slip[<?echo $slip_type['SlipType']['id'];?>][id]" value="<?if($slip_type['Today']!=null){echo $slip_type['Today']['SlipNumber']['id'];}?>">
																			<input type="number" class="form-control" placeholder="例）100" name="slip[<?echo $slip_type['SlipType']['id'];?>][start_number]" value="<?if($slip_type['Today']!=null){echo $slip_type['Today']['SlipNumber']['start_number'];}elseif($slip_type['Before']!=null){echo $slip_type['Before']['SlipNumber']['end_number']+1;}?>">
																		</div>
																	</div>
																</div>
																<div class="col-md-6">
																	<div class="form-group">
																		<label class="control-label">(終了)</label>
																		<div class="input-group">
																			<span class="input-group-addon">
																				<i class="fa fa-sort-numeric-asc"></i>
																			</span>
																			<input type="number" class="form-control" placeholder="例）120" name="slip[<?echo $slip_type['SlipType']['id'];?>][end_number]" value="<?if($slip_type['Today']!=null){echo $slip_type['Today']['SlipNumber']['end_number'];}?>">
																		</div>
																	</div>
																</div>
															</div>
														<?endforeach;?>
													</div>
													<!-- END FORM-->
												</div>
											</div>
										</div>


									</div>
								</div>
								<!--END TAB6-->
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<input type="button" id="button_submit" onmouseover="this.style.backgroundColor='#36C3FF'"
						       onmouseout="this.style.backgroundColor='#ff5252'"; class="list-group-item list-group-item-danger" style="height:90px; width:100%; color:white; text-align:center; font-size:50px; font-weight:bold; background-color:#ff5252; letter-spacing:20px;" value="送信する">
						<h3 id="salesError" style="color: red;"></h3>
					</div>
					<script>
						$('#button_submit').click(function() {
							//合計値正誤確認
							<?if(isset($sales)&&$location['Location']['name']=='和光店'):?>
								var totalSales = parseInt($('#totalSales').html());
								var num = 0;
								<?foreach($sales as $sales_one):?>
								num += parseInt($('input[name="sales[<?echo $sales_one['Type']['id']?>][fee]"]').val());
								<?endforeach;?>
								if(totalSales==num){
									$('#form_submit').submit();
									$(this).attr("disabled", "disabled");
								}else{
									$('#salesError').html("合計売上金額と入力された内訳金額が正しくありません。(内訳金額を訂正してください！)");
								}
							<?else:?>
								$('#form_submit').submit();
								$(this).attr("disabled", "disabled");
							<?endif;?>
						});
					</script>
				</div>
<!-- END PAGE CONTENT INNER -->

			</div>
		</div>
</div>
<?echo $this->Form->end();?>
<script>
	jQuery(document).ready(function() {
		// initiate layout and plugins
		Metronic.init(); // init metronic core components
		Layout.init(); // init current layout
		//sDemo.init(); // init demo features
		UIDatepaginator.init();
		ComponentsFormTools.init();
		ComponentsPickers.init();
	});
</script>

