<?
#cssファイル
echo $this->Html->css('assets/global/plugins/select2/select2.css');
echo $this->Html->css('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css');
#jsファイル
echo $this->Html->script('jquery-ui-1.10.4.custom.js');
#客数グラフ
echo $this->Html->script('assets/admin/pages/scripts/ecommerce-index.js');
echo $this->Html->script('assets/admin/pages/scripts/charts-flotcharts.js');
echo $this->Html->script('assets/admin/pages/scripts/table-advanced.js');
echo $this->Html->script('assets/global/plugins/select2/select2.min.js');
echo $this->Html->script('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js');
echo $this->Html->script('assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js');
echo $this->Html->script('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js');
echo $this->Html->script('assets/admin/pages/scripts/ui-datepaginator.js');
?>
<style>
    h3{ font-size: 16px; }
    .hosoku{ font-size: 14px; }
    .grayZone{ background: #eee; }
    .grayCell{ border-right: 1px solid #000 !important; }
    .borderBottom{ border-bottom: 2px solid #000 !important; }
    .table-scrollable{ overflow-y: auto; }
    th,td{ text-align: center;}
</style>
<div class="container">
    <div class="portlet light">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-green sbold uppercase">分析条件</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form action="" class="form-horizontal form-bordered" method="post">
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-3">部門名</label>
                        <div class="col-md-9">
                            <select class="form-control input-small" name="breakdown_name">
                                <?foreach($breakdowns as $breakdown):?>
                                    <option value="<?=$breakdown['OrderSummary']['breakdown_name'];?>" <?if(isset($breakdown_name)&&$breakdown_name==$breakdown['OrderSummary']['breakdown_name']){ echo 'selected'; }?>>
                                        <?=$breakdown['OrderSummary']['breakdown_name'];?>
                                    </option>
                                <?endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">F/D</label>
                        <div class="col-md-9">
                            <select class="form-control input-small" name="fd">
                                <?foreach($fds as $fd):?>
                                    <option value="<?=$fd['OrderSummary']['fd'];?>" <?if(isset($fd_name)&&$fd_name==$fd['OrderSummary']['fd']){ echo 'selected'; }?>>
                                        <?=$fd['OrderSummary']['fd'];?>
                                    </option>
                                <?endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">分析期間</label>
                        <div class="col-md-9">
                            <select class="form-control input-medium" name="period_type">
                                <option value="1" <?if(isset($period_type)&&$period_type==1){ echo 'selected'; }?>>先週 vs 先々週</option>
                                <option value="2" <?if(isset($period_type)&&$period_type==2){ echo 'selected'; }?>>先々週 vs 3週前</option>
                                <option value="3" <?if(isset($period_type)&&$period_type==3){ echo 'selected'; }?>>前月 vs 前々月</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button class="btn green" type="submit">
                                <i class="fa fa-check"></i> 分析Go！
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="portlet light">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-green sbold uppercase">分析結果</span>
                <?if(isset($start_date)&&isset($end_date)&&isset($compare_start_date)&&isset($compare_end_date)):?>
                <span class="hosoku">＊<?=$start_date;?>-<?=$end_date;?> vs <?=$compare_start_date;?>-<?=$compare_end_date;?></span>
                <?endif;?>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form">
                <div class="form-body">
                    <h3 class="form-section">カテゴリ別商品売上</h3>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-scrollable">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>------------</th>
                                        <th class="grayCell">合計</th>
                                        <?if(isset($category_trend)):?>
                                            <?foreach($category_trend as $ct):?>
                                                <?if($ct['sales']>0):?>
                                                <th><?=$ct['category_name'];?></th>
                                                <?endif;?>
                                            <?endforeach;?>
                                        <?endif;?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><?if(isset($period_script)){ echo $period_script[0]; }?></td>
                                        <th class="grayCell"><?if(isset($total)){ echo '¥'.number_format($total['sales']); }?></th>
                                        <?if(isset($category_trend)):?>
                                            <?foreach($category_trend as $ct):?>
                                                <?if($ct['sales']>0):?>
                                                    <td>¥<?=number_format($ct['sales']);?>（<?=floor($ct['sales']/$total['sales']*100);?>%）</td>
                                                <?endif;?>
                                            <?endforeach;?>
                                        <?endif;?>
                                    </tr>
                                    <tr class="borderBottom">
                                        <td><?if(isset($period_script)){ echo $period_script[1]; }?></td>
                                        <th class="grayCell"><?if(isset($total)){ echo '¥'.number_format($total['compare_sales']); }?></th>
                                        <?if(isset($category_trend)):?>
                                            <?foreach($category_trend as $ct):?>
                                                <?if($ct['sales']>0):?>
                                                    <td>¥<?=number_format($ct['compare_sales']);?>（<?=floor($ct['compare_sales']/$total['compare_sales']*100);?>%）</td>
                                                <?endif;?>
                                            <?endforeach;?>
                                        <?endif;?>
                                    </tr>
                                    <tr>
                                        <td><?if(isset($period_script)){ echo '売上差分'; }?></td>
                                        <th class="grayCell <? if(isset($total)){ if($total['sales_diff']>0){ $arrow='fa fa-arrow-up';echo 'success'; }elseif($total['sales_diff']<0){ $arrow='fa fa-arrow-down';echo'danger'; }else{ $arrow='fa fa-arrow-right'; } } ?>">
                                            <i class="<?=$arrow;?>" aria-hidden="true"></i>
                                            <?if(isset($total)){ echo number_format($total['sales_diff']); }?>
                                        </th>
                                        <?if(isset($category_trend)):?>
                                            <?foreach($category_trend as $ct):?>
                                                <?if($ct['sales']>0):?>
                                                    <td class="<?if($ct['sales_diff']>0){ $arrow='fa fa-arrow-up';echo 'success'; }elseif($ct['sales_diff']<0){ $arrow='fa fa-arrow-down';echo 'danger'; }else{ $arrow='fa fa-arrow-right'; }?>">
                                                        <i class="<?=$arrow;?>" aria-hidden="true"></i>
                                                        <?=number_format($ct['sales_diff']);?>
                                                    </td>
                                                <?endif;?>
                                            <?endforeach;?>
                                        <?endif;?>
                                    </tr>
                                    <tr class="grayZone">
                                        <td style="background: #fff;"><?if(isset($period_script)){ echo '単価差分'; }?></td>
                                        <td class="grayCell <?if(isset($total)){ if($total['per_num_diff']>0){ $arrow='fa fa-arrow-up';echo 'font-green'; }elseif($total['per_num_diff']<0){ $arrow='fa fa-arrow-down';echo 'font-red'; }else{ $arrow='fa fa-arrow-right'; } } ?>">
                                            <i class="<?=$arrow;?>" aria-hidden="true"></i>
                                            <?if(isset($total)){ echo number_format($total['per_num_diff']); }?>
                                        </td>
                                        <?if(isset($category_trend)):?>
                                            <?foreach($category_trend as $ct):?>
                                                <?if($ct['sales']>0):?>
                                                    <td class="<?if($ct['per_num_diff']>0){ $arrow='fa fa-arrow-up';echo 'font-green'; }elseif($ct['per_num_diff']<0){ $arrow='fa fa-arrow-down';echo 'font-red'; }else{ $arrow='fa fa-arrow-right'; }?>">
                                                        <i class="<?=$arrow;?>" aria-hidden="true"></i>
                                                        <?=number_format($ct['per_num_diff']);?>
                                                    </td>
                                                <?endif;?>
                                            <?endforeach;?>
                                        <?endif;?>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <h3 class="form-section">メニュー別ランキング</h3>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-scrollable table-bordered table-hover" id="sample_1">
                                <thead>
                                <tr>
                                    <th>順位</th>
                                    <th>前回から</th>
                                    <th>メニュー</th>
                                    <th>カテゴリ</th>
                                    <th>売価</th>
                                    <th>出数（比較元）</th>
                                    <th>出数（比較先）</th>
                                    <th>出数差分</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?if(isset($menu_trend)):?>
                                    <?foreach ($menu_trend as $key => $mt): ?>
                                        <?$rank=$key+1;$rank_diff=$mt['compare_rank']-$rank;?>
                                        <?if($rank_diff>0){ $arrow='fa fa-arrow-up'; }elseif($rank_diff<0){ $arrow='fa fa-arrow-down'; }else{ $arrow='fa fa-arrow-right'; } ?>
                                        <tr class="<?if(abs($rank_diff)>=5 && abs($mt['order_num']-$mt['compare_order_num'])>=5){ if($rank_diff>0){ echo 'success';}else{ echo 'danger';} } ?>">
                                            <td><?= $key+1; ?></td>
                                            <td><i class="<?=$arrow;?>" aria-hidden="true"></i> <?= $rank_diff; ?></td>
                                            <td><?= $mt['menu_name']; ?></td>
                                            <td><?= $mt['category_name']; ?></td>
                                            <td>¥<?= floor($mt['price']); ?></td>
                                            <td><?= number_format($mt['order_num']); ?></td>
                                            <td><?= number_format($mt['compare_order_num']); ?></td>
                                            <td><?= number_format($mt['order_num']-$mt['compare_order_num']); ?></td>
                                        </tr>
                                    <?endforeach; ?>
                                <?endif;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function() {
        TableAdvanced.init();
    });
</script>