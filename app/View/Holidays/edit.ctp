<?
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/07/23
 * Time: 18:08
 */
?>
<div class="container">
	<div class="row">
		<div class="portlet box blue-hoki" style="margin: 50px">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-cogs"></i>休業日設定
				</div>
				<div class="tools">
					<a href="javascript:;" class="collapse">
					</a>
				</div>
			</div>
			<div class="portlet-body">
				<form id="holiday_form" class="form-horizontal" role="form" method="post">
					<div class="form-actions right" style="text-align: right;">
						<button type="submit" class="btn green"><i class="fa fa-check"></i>設定</button>
						<button id="credit_button" type="button" class="btn blue" onClick="addHoliday();"><i class="fa fa-check"></i>追加</button>
					</div>
					<?if(isset($holidays)):?>
						<?$ct=count($holidays);?>
						<?foreach($holidays as $holiday):?>
							<div class="form-group">
								<label class="col-md-2 control-label">休業日 <?echo $ct;?></label>
								<div class="col-md-4">
									<select class="form-control" name="holidays[]">
										<option value="">選択してください</option>
										<option value="1" <?if($holiday['Holiday']['day']==1){echo "selected";}?>>月曜日</option>
										<option value="2" <?if($holiday['Holiday']['day']==2){echo "selected";}?>>火曜日</option>
										<option value="3" <?if($holiday['Holiday']['day']==3){echo "selected";}?>>水曜日</option>
										<option value="4" <?if($holiday['Holiday']['day']==4){echo "selected";}?>>木曜日</option>
										<option value="5" <?if($holiday['Holiday']['day']==5){echo "selected";}?>>金曜日</option>
										<option value="6" <?if($holiday['Holiday']['day']==6){echo "selected";}?>>土曜日</option>
										<option value="7" <?if($holiday['Holiday']['day']==7){echo "selected";}?>>日曜日</option>
									</select>
								</div>
								<!--削除ボタン-->
								<div class="col-md-4">
									<div class="input-group">
										<input type="button" value="削除する" class="btn red" onclick='var ok=confirm("本当に削除してもよろしいですか？");if (ok) location.href="<?echo $this->Html->url(array('controller'=>'holidays', 'action'=>'delete', '?' => array('id' => $holiday['Holiday']['id'])));?>"'>
									</div>
								</div>
								<!--削除ボタンEND-->
							</div>
						<?endforeach;?>
					<?else:?>
						<?$ct=0;?>
						<p id="holiday_msg">休業日はありません</p>
					<?endif;?>
					<input id="holiday_num" type="hidden" value="<?echo $ct;?>">
					<script type="text/javascript">
						function addHoliday(){
							//inum
							var inum = Number($('#holiday_num').val())+1;
							//７日まで
							if(inum >= 7){
								alert("休業日は6日まで設定できます");
								return;
							}
							//初めて
							if(inum == 1){
								$("#holiday_msg").remove();
							}
							$('#holiday_num').val(inum);
							//種類
							var d1 = $('<div>').addClass('form-group');
							var l1 = $('<label>').addClass('col-md-2').addClass('control-label').text('休業日 '+inum);
							var dc1 = $('<div>').addClass('col-md-4');
							var s1 = $('<select>').addClass('form-control').attr('name', "holidays[]");
							var o1 = $('<option>').text('選択してください').attr('value', '');
							var o2 = $('<option>').text('月曜日').attr('value', '1');
							var o3 = $('<option>').text('火曜日').attr('value', '2');
							var o4 = $('<option>').text('水曜日').attr('value', '3');
							var o5 = $('<option>').text('木曜日').attr('value', '4');
							var o6 = $('<option>').text('金曜日').attr('value', '5');
							var o7 = $('<option>').text('土曜日').attr('value', '6');
							var o8 = $('<option>').text('日曜日').attr('value', '7');
							s1.append(o1).append(o2).append(o3).append(o4).append(o5).append(o6).append(o7).append(o8);
							dc1.append(s1);
							d1 = d1.append(l1).append(dc1);
							$('#holiday_form').append(d1);
						}
					</script>
				</form>
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
