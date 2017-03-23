<div class="portlet box red" style="margin: 50px">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-cogs"></i>従業員情報編集
		</div>
		<div class="tools">
			<a href="javascript:;" class="collapse" data-original-title="" title="">
			</a>
		</div>
	</div>
	<div class="portlet-body flip-scroll">
		<form class="form-horizontal" role="form">
			<input type="hidden" name="Member[id]" value="<?echo $member['Member']['id'];?>">
			<div class="form-group">
				<label class="col-md-2 control-label">店舗</label>
				<div class="col-md-4">
					<select class="form-control input-small" name="Member[location_id]">
						<?foreach($locations as $location):?>
							<option value="<?echo $location['Location']['id'];?>" <?if($location['Location']['id']==$member['Location']['id']){echo "selected";}?>><?echo $location['Location']['name'];?></option>
						<?endforeach;?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">氏名</label>
				<div class="col-md-4">
					<div class="input-icon right">
						<i class="fa fa-user"></i>
						<input class="form-control" placeholder="name" value="<?echo $member['Member']['name'];?>" name="Member[name]">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">役職</label>
				<div class="col-md-4">
					<select class="form-control input-small" name="Member[post_id]">
						<?foreach($posts as $post):?>
							<option value="<?echo $post['MemberPost']['id'];?>" <?if($post['MemberPost']['id']==$member['Post']['id']){echo "selected";}?>><?echo $post['MemberPost']['name'];?></option>
						<?endforeach;?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">持ち場</label>
				<div class="col-md-4">
					<select class="form-control input-small" name="Member[position_id]">
						<?foreach($positions as $position):?>
							<option value="<?echo $position['MemberPosition']['id'];?>" <?if($position['MemberPosition']['id']==$member['Position']['id']){echo "selected";}?>><?echo $position['MemberPosition']['name'];?></option>
						<?endforeach;?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">勤務形態</label>
				<div class="col-md-4">
					<select class="form-control input-small" name="Member[type_id]">
						<?foreach($types as $type):?>
							<option value="<?echo $type['MemberType']['id'];?>" <?if($type['MemberType']['id']==$member['Type']['id']){echo "selected";}?>><?echo $type['MemberType']['name'];?></option>
						<?endforeach;?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">給与</label>
				<div class="col-md-4">
					<div class="input-icon right">
						<i class="fa fa-user"></i>
						<input type="number" class="form-control" placeholder="給与" value="<?echo $member['Member']['hourly_wage'];?>" name="Member[hourly_wage]">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">交通費（日別）</label>
				<div class="col-md-4">
					<div class="input-icon right">
						<i class="fa fa-user"></i>
						<input type="number" class="form-control" placeholder="交通費（日別）" value="<?echo $member['Member']['compensation_daily'];?>" name="Member[compensation_daily]">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">交通費（定期）</label>
				<div class="col-md-4">
					<div class="input-icon right">
						<i class="fa fa-user"></i>
						<input type="number" class="form-control" placeholder="交通費（定期）" value="<?echo $member['Member']['compensation_monthly'];?>" name="Member[compensation_monthly]">
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
