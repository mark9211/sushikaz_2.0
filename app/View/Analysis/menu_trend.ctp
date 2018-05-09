<style>
    h3{ font-size: 16px; }
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
                                <option value="1">前月 vs 前々月</option>
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
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form">
                <div class="form-body">
                    <h3 class="form-section"><?=$start_date;?>-<?=$end_date;?> vs <?=$compare_start_date;?>-<?=$compare_end_date;?></h3>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-scrollable">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>カテゴリ</th>
                                        <th>メニュー</th>
                                        <th>売上差分</th>
                                        <th>売上（比較元）</th>
                                        <th>売上（比較先）</th>
                                        <th>出数（比較元）</th>
                                        <th>出数（比較先）</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?if(isset($menu_trend)):?>
                                        <?foreach ($menu_trend as $mt): ?>
                                            <tr class="<? if(abs($mt['diff'])>=10000){ if($mt['diff']<0){echo 'danger';}else{echo 'success';} }?>">
                                                <td><?= $mt['category_name']; ?></td>
                                                <td><?= $mt['menu_name']; ?></td>
                                                <td>¥<?= number_format($mt['diff']); ?></td>
                                                <td>¥<?= number_format($mt['sales']); ?></td>
                                                <td>¥<?= number_format($mt['compare_sales']); ?></td>
                                                <td><?= number_format($mt['order_num']); ?></td>
                                                <td><?= number_format($mt['compare_order_num']); ?></td>
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
