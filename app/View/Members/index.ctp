<div class="container">
	<div class="portlet box green" style="margin: 50px">
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-cogs"></i>従業員一覧
			</div>
			<div class="tools">
				<a href="javascript:;" class="collapse" data-original-title="" title="">
				</a>
			</div>
		</div>
		<div class="portlet-body flip-scroll">
			<table class="table table-bordered table-striped table-condensed flip-content">
				<thead class="flip-content">
				<tr>
					<th>
						店舗
					</th>
					<th>
						氏名
					</th>
					<th>
						役職
					</th>
					<th>
						持ち場
					</th>
					<th>
						勤務形態
					</th>
					<th class="numeric">
						給与
					</th>
					<th class="numeric">
						交通費（日別）
					</th>
					<th class="numeric">
						交通費（定期）
					</th>
					<th class="numeric">
						編集
					</th>
					<th class="numeric">
						削除
					</th>
				</tr>
				</thead>
				<tbody>
				<?if(isset($members)):?>
					<?foreach($members as $member):?>
						<tr>
							<td>
								<?echo $member['Location']['name'];?>
							</td>
							<td>
								<?echo $member['Member']['name'];?>
							</td>
							<td>
								<?echo $member['Post']['name'];?>
							</td>
							<td>
								<?echo $member['Position']['name'];?>
							</td>
							<td>
								<?echo $member['Type']['name'];?>
							</td>
							<td class="numeric">
								<?if($member['Type']['name']=='社員'):?>
									<?echo '...';?>
								<?else:?>
									<?echo $member['Member']['hourly_wage'];?>
								<?endif;?>
							</td>
							<td class="numeric">
								<?echo $member['Member']['compensation_daily'];?>
							</td>
							<td class="numeric">
								<?echo $member['Member']['compensation_monthly'];?>
							</td>
							<td class="numeric">
								<?
								if($member['Type']['name']=='社員'){
									echo $this->Form->postLink(
										'編集する',
										array('action'=>'edit', $member['Member']['id']),
										array('class'=>'btn green'),
										'あなたは社員ですか?'
									);
								}else{
									echo $this->Form->postLink(
										'編集する',
										array('action'=>'edit', $member['Member']['id']),
										array('class'=>'btn green')
									);
								}
								?>
							</td>
							<td class="numeric">
								<?
								echo $this->Form->postLink(
									'削除する',
									array('action'=>'delete', $member['Member']['id']),
									array('class'=>'btn red'),
									'本当に削除しますか?'
								);
								?>
							</td>
						</tr>
					<?endforeach;?>
				<?endif;?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<input type="button" onclick="location.href='<?echo $this->Html->url(array('controller'=>'members', 'action'=>'add'));?>'" onmouseover="this.style.backgroundColor='#36C3FF'"
			       onmouseout="this.style.backgroundColor='#ff5252'"; class="list-group-item list-group-item-danger" style="height:90px; width:90%; color:white; text-align:center; font-size:50px; font-weight:bold; background-color:#ff5252; letter-spacing:20px;margin: auto;margin-bottom: 50px;" value="新規追加">
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
