<div class="container">
	<div class="portlet box green" style="margin: 50px">
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-cogs"></i>買掛一覧
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
					<th width="30%">
						店舗
					</th>
					<th width="30%">
						店名
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
				<?if(isset($account_types)):?>
					<?foreach($account_types as $account_type):?>
						<tr>
							<td>
								<?echo $account_type['Location']['name']?>
							</td>
							<td>
								<?echo $account_type['AccountType']['name']?>
							</td>
							<td class="numeric">
								<?
								echo $this->Form->postLink(
									'編集する',
									array('action'=>'edit', $account_type['AccountType']['id']),
									array('class'=>'btn green')
								);
								?>
							</td>
							<td class="numeric">
								<?
								echo $this->Form->postLink(
									'削除する',
									array('action'=>'delete', $account_type['AccountType']['id']),
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
			<input type="button" onclick="location.href='<?echo $this->Html->url(array('controller'=>'accountTypes', 'action'=>'add'));?>'" onmouseover="this.style.backgroundColor='#36C3FF'"
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