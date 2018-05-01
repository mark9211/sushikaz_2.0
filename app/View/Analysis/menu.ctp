<style>
    h3{ font-size: 16px; }
    .grayOut{ color: #aaa; }
    .table-scrollable{ overflow-y: auto;max-height: 250px; }
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
                        <label class="control-label col-md-3">商品名</label>
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
                    <!--
                    <div class="form-group">
                        <label class="control-label col-md-3">ブランド名</label>
                        <div class="col-md-9">
                            <select class="form-control input-small" name="brand_name">
                                <?foreach($brands as $brand):?>
                                    <option value="<?=$brand['OrderSummary']['brand_name'];?>" <?if(isset($menu_info)&&$menu_info['brand_name']==$brand['OrderSummary']['brand_name']){ echo 'selected'; }?>>
                                        <?=$brand['OrderSummary']['brand_name'];?>
                                    </option>
                                <?endforeach;?>
                            </select>
                        </div>
                    </div>
                    -->
                    <div class="form-group">
                        <label class="control-label col-md-3">部門名</label>
                        <div class="col-md-9">
                            <select class="form-control input-small" name="breakdown_name">
                                <?foreach($breakdowns as $breakdown):?>
                                    <option value="<?=$breakdown['OrderSummary']['breakdown_name'];?>" <?if(isset($menu_info)&&$menu_info['breakdown_name']==$breakdown['OrderSummary']['breakdown_name']){ echo 'selected'; }?>>
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
                                    <option value="<?=$fd['OrderSummary']['fd'];?>" <?if(isset($menu_info)&&$menu_info['fd']==$fd['OrderSummary']['fd']){ echo 'selected'; }?>>
                                        <?=$fd['OrderSummary']['fd'];?>
                                    </option>
                                <?endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">分析開始日</label>
                        <div class="col-md-9">
                            <input class="form-control input-small" type="text" name="start_date" placeholder="20180401" value="<?if(isset($menu_info)){ echo $menu_info['start_date']; }?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">分析終了日</label>
                        <div class="col-md-9">
                            <input class="form-control input-small" type="text" name="end_date" placeholder="20180430" value="<?if(isset($menu_info)){ echo $menu_info['end_date']; }?>">
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
    <div class="portlet light">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-green sbold uppercase">分析結果</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form">
                <div class="form-body">
                    <?if(isset($menu_info)&&isset($receipt_info)):?>
                        <h3 class="form-section">メニュー情報</h3>
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
                        <h3 class="form-section">ABC（F/D別）</h3>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label col-md-6">売上観点</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static"> <?=$sales_rank['rank'];?>（<?=$sales_rank['denominator'];?> 中 <?=$sales_rank['order'];?>）</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label col-md-6">出数観点</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static"> - </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label col-md-6">粗利観点</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static"> - </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h3 class="form-section">注文情報</h3>
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
                                        <p class="form-control-static"> <?=number_format($receipt_info['menu_receipt_cnt']);?> </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row grayOut">
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
                                        <p class="form-control-static"> <?=number_format($receipt_info['quantity']);?> </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label col-md-6">注文レシート数</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static"> <?=number_format($receipt_info['receipt_cnt']);?> </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h3 class="form-section">レシート情報</h3>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label col-md-6">平均客単</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static">¥<?=number_format(floor($receipt_info['menu_total']/$receipt_info['menu_visitors']));?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label col-md-6">平均点数</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static"> <?=floor($receipt_info['menu_quantity']/$receipt_info['menu_visitors']*10)/10;?>品 </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label col-md-6">平均組人数</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static"> <?=floor($receipt_info['menu_visitors']/$receipt_info['menu_receipt_cnt']*10)/10;?>人 </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row grayOut">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label col-md-6">平均客単</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static">¥<?=number_format(floor($receipt_info['total']/$receipt_info['visitors']));?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label col-md-6">平均点数</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static"> <?=floor($receipt_info['quantity']/$receipt_info['visitors']*10)/10;?>品 </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label col-md-6">平均組人数</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static"> <?=floor($receipt_info['visitors']/$receipt_info['receipt_cnt']*10)/10;?>人 </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h3 class="form-section">一緒に頼まれやすいメニュー</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <span class="caption-subject font-green bold uppercase">フードメニューBEST10</span>
                                        </div>
                                        <div class="actions"></div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="table-scrollable">
                                            <table class="table table-hover">
                                                <thead>
                                                <tr>
                                                    <th> 順位 </th>
                                                    <th> 商品名 </th>
                                                    <th> カテゴリ </th>
                                                    <th> 出現回数 </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?if($food_menus!=null):?>
                                                <?foreach($food_menus as $key => $food_menu):?>
                                                    <tr>
                                                        <td> <?=$key+1;?> </td>
                                                        <td> <?=$food_menu['OrderSummary']['menu_name'];?> </td>
                                                        <td> <?=$food_menu['OrderSummary']['category_name'];?> </td>
                                                        <td> <?=$food_menu[0]['cnt'];?> </td>
                                                    </tr>
                                                <?endforeach;?>
                                                <?endif;?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <span class="caption-subject font-green bold uppercase">ドリンクメニューBEST10</span>
                                        </div>
                                        <div class="actions"></div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="table-scrollable">
                                            <table class="table table-hover">
                                                <thead>
                                                <tr>
                                                    <th> 順位 </th>
                                                    <th> 商品名 </th>
                                                    <th> カテゴリ </th>
                                                    <th> 出現回数 </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?if($drink_menus!=null):?>
                                                    <?foreach($drink_menus as $key => $drink_menu):?>
                                                        <tr>
                                                            <td> <?=$key+1;?> </td>
                                                            <td> <?=$drink_menu['OrderSummary']['menu_name'];?> </td>
                                                            <td> <?=$drink_menu['OrderSummary']['category_name'];?> </td>
                                                            <td> <?=$drink_menu[0]['cnt'];?> </td>
                                                        </tr>
                                                    <?endforeach;?>
                                                <?endif;?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?endif;?>
                </div>
            </form>
        </div>
    </div>
</div>