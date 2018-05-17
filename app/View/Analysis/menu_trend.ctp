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
    .borderBottom{ border-bottom: 2px solid #aaa !important; }
    .table-scrollable{ overflow-y: auto; }
    th,td{ text-align: center; }
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
                                <option value="4" <?if(isset($period_type)&&$period_type==4){ echo 'selected'; }?>>前月 vs 昨年同月</option>
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
                    <h3 class="form-section">全体</h3>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-scrollable">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>商品売上</th>
                                        <th>客数</th>
                                        <th>商品単価</th>
                                        <th>客あたり出数</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?if(isset($period_script) && isset($total) && isset($receipt_trend)):?>
                                        <tr>
                                            <td><?= $period_script[0];?></td>
                                            <td><?= '¥'.number_format($total['sales']); ?></td>
                                            <td><?= number_format($receipt_trend['visitors']); ?></td>
                                            <td><?= '¥'.number_format($total['per_num']); ?></td>
                                            <td>
                                                <?$ord_per_vis=0;?>
                                                <?=  $ord_per_vis = floor($total['order_num']/$receipt_trend['visitors']*100)/100; ?>
                                            </td>
                                        </tr>
                                        <tr class="borderBottom">
                                            <td><?= $period_script[1];?></td>
                                            <td><?= '¥'.number_format($total['compare_sales']); ?></td>
                                            <td><?= number_format($receipt_trend['compare_visitors']); ?></td>
                                            <td><?= '¥'.number_format($total['compare_per_num']); ?></td>
                                            <td>
                                                <?$compare_ord_per_vis=0;?>
                                                <?= $compare_ord_per_vis = floor($total['compare_order_num']/$receipt_trend['compare_visitors']*100)/100; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>差分</td>
                                            <td class="<? if($total['sales_diff']>0){ $arrow='fa fa-arrow-up'; }elseif($total['sales_diff']<0){ $arrow='fa fa-arrow-down'; }else{ $arrow='fa fa-arrow-right'; } ?>">
                                                <i class="<?=$arrow;?>" aria-hidden="true"></i>
                                                <?= number_format($total['sales_diff']); ?>
                                            </td>
                                            <td class="<? if($receipt_trend['visitors_diff']>0){ $arrow='fa fa-arrow-up'; }elseif($receipt_trend['visitors_diff']<0){ $arrow='fa fa-arrow-down'; }else{ $arrow='fa fa-arrow-right'; } ?>">
                                                <i class="<?=$arrow;?>" aria-hidden="true"></i>
                                                <?= number_format($receipt_trend['visitors_diff']); ?>
                                            </td>
                                            <td class="<? if($total['per_num_diff']>0){ $arrow='fa fa-arrow-up';echo 'success'; }elseif($total['per_num_diff']<0){ $arrow='fa fa-arrow-down';echo'danger'; }else{ $arrow='fa fa-arrow-right'; } ?>">
                                                <i class="<?=$arrow;?>" aria-hidden="true"></i>
                                                <?= number_format($total['per_num_diff']); ?>
                                            </td>
                                            <? $ord_per_vis_diff = $ord_per_vis - $compare_ord_per_vis; ?>
                                            <td class="<? if($ord_per_vis_diff>0){ $arrow='fa fa-arrow-up';echo 'success'; }elseif($ord_per_vis_diff<0){ $arrow='fa fa-arrow-down';echo'danger'; }else{ $arrow='fa fa-arrow-right'; } ?>">
                                                <i class="<?=$arrow;?>" aria-hidden="true"></i>
                                                <?= $ord_per_vis_diff;?>
                                            </td>
                                        </tr>
                                    <?endif;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <h3 class="form-section">カテゴリ別</h3>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-scrollable">
                                <table class="table table-bordered table-hover">
                                    <?if(isset($category_trend) && isset($period_script) && isset($receipt_trend)):?>
                                    <thead>
                                    <tr>
                                        <th style="min-width: 130px;">------------</th>
                                        <?foreach($category_trend as $key => $ct):?>
                                            <?if($ct['sales']>0):?>
                                                <!--Modal View-->
                                                <div id="categoryDetail_<?=$key;?>" class="modal fade in" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">客単価情報</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form class="form-horizontal" role="form">
                                                                    <div class="form-body">
                                                                        <h3 class="form-section">「<?=$ct['category_name'];?>」に属するメニューが頼まれた時の客単価</h3>
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label col-md-6">客単価</label>
                                                                                    <div class="col-md-6">
                                                                                        <p class="form-control-static"> ¥<?=number_format($ct['per_visitor']);?> </p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label col-md-6">平均客単</label>
                                                                                    <div class="col-md-6">
                                                                                        <p class="form-control-static"> ¥<?=number_format($ct['compare_per_visitor']);?> </p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label col-md-6">客単差分</label>
                                                                                    <div class="col-md-6">
                                                                                        <p class="form-control-static"> <?=number_format($ct['per_visitor_diff']);?> </p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" data-dismiss="modal" class="btn default">閉じる</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--Modal End-->
                                                <th style="min-width: 130px;">
                                                    <a data-toggle="modal" href="#categoryDetail_<?=$key;?>">
                                                        <?=$ct['category_name'];?>
                                                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                    </a>
                                                </th>
                                            <?endif;?>
                                        <?endforeach;?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>商品売上</td>
                                        <?foreach($category_trend as $ct):?>
                                            <?if($ct['sales']>0):?>
                                                <td class="<?if($ct['sales_diff']>0){ $arrow='fa fa-arrow-up';echo 'font-green'; }elseif($ct['sales_diff']<0){ $arrow='fa fa-arrow-down';echo 'font-red'; }else{ $arrow='fa fa-arrow-right'; }?>">
                                                    <span style="color: #333333;"><?= '¥'.number_format($ct['sales']);?></span><br>
                                                    (<i class="<?=$arrow;?>" aria-hidden="true"></i><?= number_format($ct['sales_diff']);?>)
                                                </td>
                                            <?endif;?>
                                        <?endforeach;?>
                                    </tr>
                                    <tr>
                                        <td>商品単価</td>
                                        <?foreach($category_trend as $ct):?>
                                            <?if($ct['sales']>0):?>
                                                <td class="<?if($ct['per_num_diff']>0){ $arrow='fa fa-arrow-up';echo 'font-green'; }elseif($ct['per_num_diff']<0){ $arrow='fa fa-arrow-down';echo 'font-red'; }else{ $arrow='fa fa-arrow-right'; }?>">
                                                    <span style="color: #333333;"><?= '¥'.number_format($ct['per_num']);?></span><br>
                                                    (<i class="<?=$arrow;?>" aria-hidden="true"></i><?= number_format($ct['per_num_diff']);?>)
                                                </td>
                                            <?endif;?>
                                        <?endforeach;?>
                                    </tr>
                                    <tr>
                                        <td>出数構成比</td>
                                        <?foreach($category_trend as $ct):?>
                                            <?if($ct['sales']>0):?>
                                                <?
                                                $ord_com_rat = 0;
                                                $compare_ord_com_rat = 0;
                                                if($total['order_num']){ $ord_com_rat = floor($ct['order_num']/$total['order_num']*1000)/10; }
                                                if($total['compare_order_num']){ $compare_ord_com_rat = floor($ct['compare_order_num']/$total['compare_order_num']*1000)/10; }
                                                $ord_com_rat_diff = $ord_com_rat - $compare_ord_com_rat;
                                                ?>
                                                <td class="<?if($ord_com_rat_diff>0){ $arrow='fa fa-arrow-up';echo 'font-green'; }elseif($ord_com_rat_diff<0){ $arrow='fa fa-arrow-down';echo 'font-red'; }else{ $arrow='fa fa-arrow-right'; }?>">
                                                    <span style="color: #333333;"><?= $ord_com_rat;?>%</span><br>
                                                    (<i class="<?= $arrow;?>" aria-hidden="true"></i><?= $ord_com_rat_diff;?>)
                                                </td>
                                            <?endif;?>
                                        <?endforeach;?>
                                    </tr>
                                    </tbody>
                                    <?endif;?>
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
                                    <th>出数差分</th>
                                    <th>メニュー</th>
                                    <th>カテゴリ</th>
                                    <th>売価</th>
                                    <th>出数</th>
                                    <th>構成比</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?if(isset($menu_trend)):?>
                                    <?foreach ($menu_trend as $key => $mt): ?>
                                        <?$rank=$key+1;$rank_diff=$mt['compare_rank']-$rank;?>
                                        <?if($rank_diff>0){ $arrow='fa fa-arrow-up'; }elseif($rank_diff<0){ $arrow='fa fa-arrow-down'; }else{ $arrow='fa fa-arrow-right'; } ?>
                                        <tr class="<?if(abs($rank_diff)>=5 || abs($mt['order_num']-$mt['compare_order_num'])>=10){ if($rank_diff>0){ echo 'success';}else{ echo 'danger';} } ?>">
                                            <td><?= $key+1; ?></td>
                                            <td><i class="<?=$arrow;?>" aria-hidden="true"></i> <?= $rank_diff; ?></td>
                                            <td><?= number_format($mt['order_num']-$mt['compare_order_num']); ?></td>
                                            <td><?= $mt['menu_name']; ?></td>
                                            <td><?= $mt['category_name']; ?></td>
                                            <td>¥<?= floor($mt['price']); ?></td>
                                            <td><?= $mt['order_num'];?></td>
                                            <td><?= floor($mt['c_rate']*10000)/100;?>%</td>
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