<div class="portlet box green" style="margin: 50px">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-cogs"></i>売上目標値
		</div>
		<div class="tools">
			<a href="javascript:;" class="collapse" data-original-title="" title="">
			</a>
		</div>
	</div>
	<div class="portlet-body flip-scroll">
		<form class="form-horizontal" role="form" method="post">
			<?if(isset($target)):?>
				<input type="hidden" name="Target[id]" value="<?echo $target['Target']['id'];?>">
			<?endif;?>
			<?if(isset($location)):?>
				<input type="hidden" name="Target[location_id]" value="<?echo $location['Location']['id'];?>">
			<?endif;?>
			<div class="form-group">
				<label class="col-md-2 control-label">目標値①</label>
				<div class="col-md-4">
					<div class="input-icon right">
						<i class="fa fa-user"></i>
						<input type="number" class="form-control" placeholder="曜日）月〜木" value="<?if(isset($target)){echo $target['Target']['target_one'];}?>" name="Target[target_one]">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">目標値②</label>
				<div class="col-md-4">
					<div class="input-icon right">
						<i class="fa fa-user"></i>
						<input type="number" class="form-control" placeholder="曜日）金" value="<?if(isset($target)){echo $target['Target']['target_two'];}?>" name="Target[target_two]">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">目標値③</label>
				<div class="col-md-4">
					<div class="input-icon right">
						<i class="fa fa-user"></i>
						<input type="number" class="form-control" placeholder="曜日）土" value="<?if(isset($target['Target']['target_four'])){echo $target['Target']['target_four'];}?>" name="Target[target_four]">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">目標値④</label>
				<div class="col-md-4">
					<div class="input-icon right">
						<i class="fa fa-user"></i>
						<input type="number" class="form-control" placeholder="曜日）日" value="<?if(isset($target)){echo $target['Target']['target_three'];}?>" name="Target[target_three]">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-10">
					<button type="submit" class="btn green">設定</button>
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
