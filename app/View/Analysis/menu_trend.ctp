<style>
    h3{ font-size: 16px; }
    .hosoku{ font-size: 14px; }
    .grayOut{ color: #aaa; }
    .table-scrollable{ overflow-y: auto; }
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
                                <option value="1">先週 vs 先々週</option>
                                <option value="2">先々週 vs 三週間前</option>
                                <option value="3">前月 vs 前々月</option>
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
                <span class="hosoku">＊<?=$start_date;?>-<?=$end_date;?> vs <?=$compare_start_date;?>-<?=$compare_end_date;?></span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label col-md-6">合計（比較元）</label>
                                <div class="col-md-6">
                                    <p class="form-control-static">¥ <?=number_format($total_num);?> </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label col-md-6">合計（比較先）</label>
                                <div class="col-md-6">
                                    <p class="form-control-static">¥ <?=number_format($compare_total_num);?> </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label col-md-6">合計差分</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> <?=number_format($total_num-$compare_total_num);?> </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-scrollable">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>順位</th>
                                        <th>前回から</th>
                                        <th>メニュー</th>
                                        <th>カテゴリ</th>
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
                                            <tr class="<?if(abs($rank_diff)>5){ if($rank_diff>0){ echo 'success';}else{ echo 'danger';} } ?>">
                                                <td><?= $key+1; ?></td>
                                                <td><i class="<?=$arrow;?>" aria-hidden="true"></i> <?= $rank_diff; ?></td>
                                                <td><?= $mt['menu_name']; ?></td>
                                                <td><?= $mt['category_name']; ?></td>
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
                </div>
            </form>
        </div>
    </div>
</div>
