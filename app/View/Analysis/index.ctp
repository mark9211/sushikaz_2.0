<div class="container">
    <div class="portlet light" style="margin: 50px">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-cogs"></i>分析画面
            </div>
            <div class="tools">
                <a href="javascript:;" class="collapse" data-original-title="" title="">
                </a>
            </div>
        </div>
        <div class="portlet-body flip-scroll">
            <ul class="list-group">
                <li class="list-group-item">
                    <?= $this->Html->link('メニュー単体分析', array('controller'=>'analysis', 'action'=>'menu'));?>
                </li>
                <li class="list-group-item">
                    <?= $this->Html->link('メニュートレンド分析', array('controller'=>'analysis', 'action'=>'menu_trend'));?>
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
