<style>
    .inputBox{
        border: 1px #ccc solid;
    }
</style>
<div class="container">
    <div class="portlet light">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-green sbold uppercase">分析条件</span>
            </div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="" class="form-horizontal form-bordered" method="post">
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-3">メニュー選択</label>
                        <div class="col-md-9">
                            <select class="form-control input-large" name="menu_name">
                                <?foreach($menus as $menu):?>
                                    <option value="<?=$menu['OrderSummary']['menu_name'];?>" <?if(isset($menu_info)&&$menu_info['menu_name']==$menu['OrderSummary']['menu_name']){ echo 'selected'; }?>>
                                        <?=$menu['OrderSummary']['menu_name'];?>
                                    </option>
                                <?endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">分析開始営業日</label>
                        <div class="col-md-9">
                            <input class="form-control input-small" type="text" name="start_date" value="<?if(isset($menu_info)){ echo $menu_info['start_date']; }?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">分析終了営業日</label>
                        <div class="col-md-9">
                            <input class="form-control input-small" type="text" name="end_date" value="<?if(isset($menu_info)){ echo $menu_info['end_date']; }?>">
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
            <!-- END FORM-->
        </div>
    </div>
    <?if(isset($menu_info)):?>
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-green sbold uppercase">分析結果</span>
                </div>
            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" role="form">
                    <div class="form-body">
                        <h3 class="form-section">Menu Info</h3>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label col-md-6">商品名</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static"> <?=$menu_info['menu_name'];?> </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label col-md-6">平均売価</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static"> ¥<?=floor($menu_info['menu_price']);?> </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label col-md-6">平均原価</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static"> ¥- </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label col-md-6">商品売上</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static">¥<?= number_format(floor($menu_info['menu_price']*$menu_info['menu_order_num']));?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label col-md-6">商品出数</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static"> <?=number_format($menu_info['menu_order_num']);?> </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label col-md-6">注文レシート数</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static"> <?=number_format($menu_info['menu_receipt_cnt']);?> </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h3 class="form-section">Period info</h3>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label col-md-6">商品売上</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static">¥<?=number_format($menu_info['sales']);?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label col-md-6">商品出数</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static"> <?=number_format($menu_info['order_num']);?> </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label col-md-6">注文レシート数</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static"> <?=number_format($menu_info['receipt_cnt']);?> </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h3 class="form-section">Receipt info</h3>
                        <div class="row">

                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?endif;?>
</div>