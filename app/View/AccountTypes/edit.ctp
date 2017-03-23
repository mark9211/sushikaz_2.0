<div class="portlet box red" style="margin: 50px">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-cogs"></i>買掛仕入れ先編集
		</div>
		<div class="tools">
			<a href="javascript:;" class="collapse" data-original-title="" title="">
			</a>
		</div>
	</div>
	<div class="portlet-body flip-scroll">
		<form class="form-horizontal" role="form">
			<input type="hidden" name="AccountType[id]" value="<?echo $account_type['AccountType']['id'];?>">
			<div class="form-group">
				<label class="col-md-2 control-label">店舗</label>
				<div class="col-md-4">
					<select class="form-control input-small" name="AccountType[location_id]">
						<?foreach($locations as $location):?>
							<option value="<?echo $location['Location']['id'];?>" <?if($location['Location']['id']==$account_type['Location']['id']){echo "selected";}?>><?echo $location['Location']['name'];?></option>
						<?endforeach;?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">氏名</label>
				<div class="col-md-4">
					<div class="input-icon right">
						<i class="fa fa-user"></i>
						<input class="form-control" placeholder="name" value="<?echo $account_type['AccountType']['name'];?>" name="AccountType[name]">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-10">
					<button type="submit" class="btn green">編集完了</button>
				</div>
			</div>
		</form>
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
