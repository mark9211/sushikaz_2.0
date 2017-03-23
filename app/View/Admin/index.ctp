<div class="container">
	<div class="portlet light" style="margin: 50px">
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-cogs"></i>管理者画面
			</div>
			<div class="tools">
				<a href="javascript:;" class="collapse" data-original-title="" title="">
				</a>
			</div>
		</div>
		<div class="portlet-body flip-scroll">
			<ul class="list-group">
				<li class="list-group-item">
					<?echo $this->Html->link('店舗選択', array('controller'=>'locations', 'action'=>'login'));?>
				</li>
				<li class="list-group-item">
					<?echo $this->Html->link('売上目標値設定', array('controller'=>'sales', 'action'=>'target'));?>
				</li>
				<li class="list-group-item">
					<?echo $this->Html->link('売上目標値計算', array('controller'=>'sales', 'action'=>'calculate'));?>
				</li>
				<li class="list-group-item">
					<?echo $this->Html->link('買掛設定', array('controller'=>'accountTypes', 'action'=>'index'));?>
				</li>
				<li class="list-group-item">
					<?echo $this->Html->link('休業日設定', array('controller'=>'holidays', 'action'=>'edit'));?>
				</li>
				<li class="list-group-item">
					<?echo $this->Html->link('業務スケジュール', array('controller'=>'holidays', 'action'=>'index'));?>
				</li>
				<li class="list-group-item">
					<?echo $this->Html->link('月別棚卸入力', array('controller'=>'stocktakings', 'action'=>'index', '?' => array('month' => date('Y-m'))));?>
				</li>
			</ul>
		</div>
	</div>
</div>
<script>
	jQuery(document).ready(function() {
		// initiate layout and plugins
		Metronic.init(); // init metronic core components
		Layout.init(); // init current layout
		//sDemo.init(); // init demo features
	});
</script>
