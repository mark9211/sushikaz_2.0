<div class="page-container">
    <!-- BEGIN PAGE HEAD -->
    <div class="page-head">
        <div class="container">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1>目標値&大入値計算 <small>Monthly Reports</small></h1>
            </div>
            <!-- END PAGE TITLE -->
        </div>
    </div>
    <!-- END PAGE HEAD -->
    <!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
        <div class="container">

            <!-- Month -->
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs"></i>売上目標値計算
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse" data-original-title="" title="">
                        </a>
                    </div>
                </div>
                <div class="portlet-body flip-scroll">
                    <form class="form-horizontal" role="form" method="post">
                        <?if(isset($location)):?>
                            <input type="hidden" name="location_id" value="<?echo $location['Location']['id'];?>">
                        <?endif;?>
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-8 control-label">月選択</label>
                                        <div class="col-md-4" style="padding-top: 7px;">
                                            <div class="input-icon">
                                                <select name="month">
                                                    <option value="01" <?if(isset($month)&&$month=='01'){echo "selected";}?>>1月</option>
                                                    <option value="02" <?if(isset($month)&&$month=='02'){echo "selected";}?>>2月</option>
                                                    <option value="03" <?if(isset($month)&&$month=='03'){echo "selected";}?>>3月</option>
                                                    <option value="04" <?if(isset($month)&&$month=='04'){echo "selected";}?>>4月</option>
                                                    <option value="05" <?if(isset($month)&&$month=='05'){echo "selected";}?>>5月</option>
                                                    <option value="06" <?if(isset($month)&&$month=='06'){echo "selected";}?>>6月</option>
                                                    <option value="07" <?if(isset($month)&&$month=='07'){echo "selected";}?>>7月</option>
                                                    <option value="08" <?if(isset($month)&&$month=='08'){echo "selected";}?>>8月</option>
                                                    <option value="09" <?if(isset($month)&&$month=='09'){echo "selected";}?>>9月</option>
                                                    <option value="10" <?if(isset($month)&&$month=='10'){echo "selected";}?>>10月</option>
                                                    <option value="11" <?if(isset($month)&&$month=='11'){echo "selected";}?>>11月</option>
                                                    <option value="12" <?if(isset($month)&&$month=='12'){echo "selected";}?>>12月</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn green">計算</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- End Month -->

            <!-- Result -->
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i>Results </div>
                    <div class="tools">
                        <a href="javascript:;" class="" data-original-title="" title="" id="excel"> EXCEL</a>
                        <a href="" class="fullscreen" data-original-title="" title=""> </a>
                    </div>
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#portlet_tab2_1" data-toggle="tab" style="color:black;"> Dinner </a>
                        </li>
                        <li class="">
                            <a href="#portlet_tab2_2" data-toggle="tab" style="color:black;"> Lunch </a>
                        </li>
                    </ul>
                </div>
                <div class="portlet-body">
                    <?
                    echo $this->Form->create('Sales', array('action'=>'calculate_excel', 'id'=>'form_submit'));
                    ?>
                    <input type="hidden" name="month" value="<?if(isset($month)){echo $month;}?>">
                    <input type="hidden" name="location_id" value="<?if(isset($location)){echo $location['Location']['id'];}?>">
                    <div class="tab-content">
                        <!-- tab1 -->
                        <div class="tab-pane active" id="portlet_tab2_1">

                                <div class="form-body">
                                    <h3 class="form-section" style="font-weight: 600;">Buts</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">① 月〜木</label>
                                                <div class="col-md-4">
                                                    <input name="portlet_tab2_1[numOne][tOne]" readonly type="text" class="form-control numOne tOne" placeholder="金額を入力してください" value="<?if(isset($new_target_arr[1]['t1'])){echo $new_target_arr[1]['t1'];}?>">
                                                    <span class="help-block"> 目標額 </span>
                                                </div>
                                                <div class="col-md-4">
                                                    <input name="portlet_tab2_1[numOne][tTwo]" readonly type="text" class="form-control numOne tTwo" placeholder="金額を入力してください" value="<?if(isset($new_target_arr[1]['t2'])){echo $new_target_arr[1]['t2'];}?>">
                                                    <span class="help-block"> 大入額 </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">③ 土</label>
                                                <div class="col-md-4">
                                                    <input name="portlet_tab2_1[numThree][tOne]" readonly type="text" class="form-control numThree tOne" placeholder="金額を入力してください" value="<?if(isset($new_target_arr[3]['t1'])){echo $new_target_arr[3]['t1'];}?>">
                                                    <span class="help-block"> 目標額 </span>
                                                </div>
                                                <div class="col-md-4">
                                                    <input name="portlet_tab2_1[numThree][tTwo]" readonly type="text" class="form-control numThree tTwo" placeholder="金額を入力してください" value="<?if(isset($new_target_arr[3]['t2'])){echo $new_target_arr[3]['t2'];}?>">
                                                    <span class="help-block"> 大入額 </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">② 金</label>
                                                <div class="col-md-4">
                                                    <input name="portlet_tab2_1[numTwo][tOne]" readonly type="text" class="form-control numTwo tOne" placeholder="金額を入力してください" value="<?if(isset($new_target_arr[2]['t1'])){echo $new_target_arr[2]['t1'];}?>">
                                                    <span class="help-block"> 目標額 </span>
                                                </div>
                                                <div class="col-md-4">
                                                    <input name="portlet_tab2_1[numTwo][tTwo]" readonly type="text" class="form-control numTwo tTwo" placeholder="金額を入力してください" value="<?if(isset($new_target_arr[2]['t2'])){echo $new_target_arr[2]['t2'];}?>">
                                                    <span class="help-block"> 大入額 </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">④ 日</label>
                                                <div class="col-md-4">
                                                    <input name="portlet_tab2_1[numFour][tOne]" readonly type="text" class="form-control numFour tOne" placeholder="金額を入力してください" value="<?if(isset($new_target_arr[4]['t1'])){echo $new_target_arr[4]['t1'];}?>">
                                                    <span class="help-block"> 目標額 </span>
                                                </div>
                                                <div class="col-md-4">
                                                    <input name="portlet_tab2_1[numFour][tTwo]" readonly type="text" class="form-control numFour tTwo" placeholder="金額を入力してください" value="<?if(isset($new_target_arr[4]['t2'])){echo $new_target_arr[4]['t2'];}?>">
                                                    <span class="help-block"> 大入額 </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-offset-6 col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">⑤ 祝日</label>
                                                <div class="col-md-4">
                                                    <input name="portlet_tab2_1[numFive][tOne]" readonly type="text" class="form-control numFive tOne" placeholder="金額を入力してください" value="<?if(isset($new_target_arr[5]['t1'])){echo $new_target_arr[5]['t1'];}?>">
                                                    <span class="help-block"> 目標額 </span>
                                                </div>
                                                <div class="col-md-4">
                                                    <input name="portlet_tab2_1[numFive][tTwo]" readonly type="text" class="form-control numFive tTwo" placeholder="金額を入力してください" value="<?if(isset($new_target_arr[5]['t2'])){echo $new_target_arr[5]['t2'];}?>">
                                                    <span class="help-block"> 大入額 </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>

                                    <h3 class="form-section">Divided per day of the week</h3>
                                    <div class="row dividedByDay">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">① 月〜木</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" placeholder="金額を入力してください" value="<?if(isset($target_arr[1]['fee'])){echo $target_arr[1]['fee'];}?>">
                                                    <span class="help-block"> 金額 </span>
                                                </div>
                                                <div class="col-md-3">
                                                    <select class="form-control numOne">
                                                        <?for($i=0;$i<30;$i++):?>
                                                            <option value="<?echo $i;?>" <?if(isset($target_arr[1]['num'])&&$target_arr[1]['num']==$i){echo "selected";}?>><?echo $i;?></option>
                                                        <?endfor;?>
                                                    </select>
                                                    <span class="help-block"> 日数 </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">③ 土</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" placeholder="金額を入力してください" value="<?if(isset($target_arr[3]['fee'])){echo $target_arr[3]['fee'];}?>">
                                                    <span class="help-block"> 金額 </span>
                                                </div>
                                                <div class="col-md-3">
                                                    <select class="form-control numThree">
                                                        <?for($i=0;$i<30;$i++):?>
                                                            <option value="<?echo $i;?>" <?if(isset($target_arr[3]['num'])&&$target_arr[3]['num']==$i){echo "selected";}?>><?echo $i;?></option>
                                                        <?endfor;?>
                                                    </select>
                                                    <span class="help-block"> 日数 </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/row-->
                                    <div class="row dividedByDay">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">② 金</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" placeholder="金額を入力してください" value="<?if(isset($target_arr[2]['fee'])){echo $target_arr[2]['fee'];}?>">
                                                    <span class="help-block"> 金額 </span>
                                                </div>
                                                <div class="col-md-3">
                                                    <select class="form-control numTwo">
                                                        <?for($i=0;$i<30;$i++):?>
                                                            <option value="<?echo $i;?>" <?if(isset($target_arr[2]['num'])&&$target_arr[2]['num']==$i){echo "selected";}?>><?echo $i;?></option>
                                                        <?endfor;?>
                                                    </select>
                                                    <span class="help-block"> 日数 </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">④ 日</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" placeholder="金額を入力してください" value="<?if(isset($target_arr[4]['fee'])){echo $target_arr[4]['fee'];}?>">
                                                    <span class="help-block"> 金額 </span>
                                                </div>
                                                <div class="col-md-3">
                                                    <select class="form-control numFour">
                                                        <?for($i=0;$i<30;$i++):?>
                                                            <option value="<?echo $i;?>" <?if(isset($target_arr[4]['num'])&&$target_arr[4]['num']==$i){echo "selected";}?>><?echo $i;?></option>
                                                        <?endfor;?>
                                                    </select>
                                                    <span class="help-block"> 日数 </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row dividedByDay">
                                        <div class="col-md-offset-6 col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">⑤ 祝日</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" placeholder="金額を入力してください" value="<?if(isset($target_arr[5]['fee'])){echo $target_arr[5]['fee'];}?>">
                                                    <span class="help-block"> 金額 </span>
                                                </div>
                                                <div class="col-md-3">
                                                    <select class="form-control numFive">
                                                        <?for($i=0;$i<30;$i++):?>
                                                            <option value="<?echo $i;?>" <?if(isset($target_arr[5]['num'])&&$target_arr[5]['num']==$i){echo "selected";}?>><?echo $i;?></option>
                                                        <?endfor;?>
                                                    </select>
                                                    <span class="help-block"> 日数 </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <h3 class="form-section">Averages</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">① 月〜木</label>
                                                <div class="col-md-5">
                                                    <input readonly type="text" class="form-control numOne" placeholder="金額を入力してください" value="<?if(isset($new_target_arr[1]['fee'])){echo $new_target_arr[1]['fee'];}?>">
                                                    <span class="help-block"> 金額 </span>
                                                </div>
                                                <div class="col-md-2">
                                                    <select class="form-control numOne tOne">
                                                        <?for($i=101;$i<110;$i++):?>
                                                            <option value="<?echo $i/100;?>" <?if($i==$t1){echo "selected";}?>><?echo $i/100;?></option>
                                                        <?endfor;?>
                                                    </select>
                                                    <span class="help-block"> 目標率 </span>
                                                </div>
                                                <div class="col-md-2">
                                                    <select class="form-control numOne tTwo">
                                                        <?for($i=11;$i<20;$i++):?>
                                                            <option value="<?echo $i/10;?>" <?if($i==$t2){echo "selected";}?>><?echo $i/10;?></option>
                                                        <?endfor;?>
                                                    </select>
                                                    <span class="help-block"> 大入率 </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">③ 土</label>
                                                <div class="col-md-5">
                                                    <input readonly type="text" class="form-control numThree" placeholder="金額を入力してください" value="<?if(isset($new_target_arr[3]['fee'])){echo $new_target_arr[3]['fee'];}?>">
                                                    <span class="help-block"> 金額 </span>
                                                </div>
                                                <div class="col-md-2">
                                                    <select class="form-control numThree tOne">
                                                        <?for($i=101;$i<110;$i++):?>
                                                            <option value="<?echo $i/100;?>" <?if($i==$t1){echo "selected";}?>><?echo $i/100;?></option>
                                                        <?endfor;?>
                                                    </select>
                                                    <span class="help-block"> 目標率 </span>
                                                </div>
                                                <div class="col-md-2">
                                                    <select class="form-control numThree tTwo">
                                                        <?for($i=11;$i<20;$i++):?>
                                                            <option value="<?echo $i/10;?>" <?if($i==$t2){echo "selected";}?>><?echo $i/10;?></option>
                                                        <?endfor;?>
                                                    </select>
                                                    <span class="help-block"> 大入率 </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">② 金</label>
                                                <div class="col-md-5">
                                                    <input readonly type="text" class="form-control numTwo" placeholder="金額を入力してください" value="<?if(isset($new_target_arr[2]['fee'])){echo $new_target_arr[2]['fee'];}?>">
                                                    <span class="help-block"> 金額 </span>
                                                </div>
                                                <div class="col-md-2">
                                                    <select class="form-control numTwo tOne">
                                                        <?for($i=101;$i<110;$i++):?>
                                                            <option value="<?echo $i/100;?>" <?if($i==$t1){echo "selected";}?>><?echo $i/100;?></option>
                                                        <?endfor;?>
                                                    </select>
                                                    <span class="help-block"> 目標率 </span>
                                                </div>
                                                <div class="col-md-2">
                                                    <select class="form-control numTwo tTwo">
                                                        <?for($i=11;$i<20;$i++):?>
                                                            <option value="<?echo $i/10;?>" <?if($i==$t2){echo "selected";}?>><?echo $i/10;?></option>
                                                        <?endfor;?>
                                                    </select>
                                                    <span class="help-block"> 大入率 </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">④ 日</label>
                                                <div class="col-md-5">
                                                    <input readonly type="text" class="form-control numFour" placeholder="金額を入力してください" value="<?if(isset($new_target_arr[4]['fee'])){echo $new_target_arr[4]['fee'];}?>">
                                                    <span class="help-block"> 金額 </span>
                                                </div>
                                                <div class="col-md-2">
                                                    <select class="form-control numFour tOne">
                                                        <?for($i=101;$i<110;$i++):?>
                                                            <option value="<?echo $i/100;?>" <?if($i==$t1){echo "selected";}?>><?echo $i/100;?></option>
                                                        <?endfor;?>
                                                    </select>
                                                    <span class="help-block"> 目標率 </span>
                                                </div>
                                                <div class="col-md-2">
                                                    <select class="form-control numFour tTwo">
                                                        <?for($i=11;$i<20;$i++):?>
                                                            <option value="<?echo $i/10;?>" <?if($i==$t2){echo "selected";}?>><?echo $i/10;?></option>
                                                        <?endfor;?>
                                                    </select>
                                                    <span class="help-block"> 大入率 </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-offset-6 col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">⑤ 祝日</label>
                                                <div class="col-md-5">
                                                    <input readonly type="text" class="form-control numFive" placeholder="金額を入力してください" value="<?if(isset($new_target_arr[5]['fee'])){echo $new_target_arr[5]['fee'];}?>">
                                                    <span class="help-block"> 掛率 </span>
                                                </div>
                                                <div class="col-md-2">
                                                    <select class="form-control numFive tOne">
                                                        <?for($i=101;$i<110;$i++):?>
                                                            <option value="<?echo $i/100;?>" <?if($i==$t1){echo "selected";}?>><?echo $i/100;?></option>
                                                        <?endfor;?>
                                                    </select>
                                                    <span class="help-block"> 目標率 </span>
                                                </div>
                                                <div class="col-md-2">
                                                    <select class="form-control numFive tTwo">
                                                        <?for($i=11;$i<20;$i++):?>
                                                            <option value="<?echo $i/10;?>" <?if($i==$t2){echo "selected";}?>><?echo $i/10;?></option>
                                                        <?endfor;?>
                                                    </select>
                                                    <span class="help-block"> 大入率 </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                        </div>
                        <!-- END tab1 -->
                        <!-- tab2 -->
                        <div class="tab-pane" id="portlet_tab2_2">

                                <div class="form-body">
                                    <h3 class="form-section" style="font-weight: 600;">Buts</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">① 月〜木</label>
                                                <div class="col-md-4">
                                                    <input name="portlet_tab2_2[numOne][tOne]" readonly type="text" class="form-control numOne tOne" placeholder="金額を入力してください" value="<?if(isset($new_target_arr_lunch[1]['t1'])){echo $new_target_arr_lunch[1]['t1'];}?>">
                                                    <span class="help-block"> 目標額 </span>
                                                </div>
                                                <div class="col-md-4">
                                                    <input name="portlet_tab2_2[numOne][tTwo]" readonly type="text" class="form-control numOne tTwo" placeholder="金額を入力してください" value="<?if(isset($new_target_arr_lunch[1]['t2'])){echo $new_target_arr_lunch[1]['t2'];}?>">
                                                    <span class="help-block"> 大入額 </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">③ 土</label>
                                                <div class="col-md-4">
                                                    <input name="portlet_tab2_2[numThree][tOne]" readonly type="text" class="form-control numThree tOne" placeholder="金額を入力してください" value="<?if(isset($new_target_arr_lunch[3]['t1'])){echo $new_target_arr_lunch[3]['t1'];}?>">
                                                    <span class="help-block"> 目標額 </span>
                                                </div>
                                                <div class="col-md-4">
                                                    <input name="portlet_tab2_2[numThree][tTwo]" readonly type="text" class="form-control numThree tTwo" placeholder="金額を入力してください" value="<?if(isset($new_target_arr_lunch[3]['t2'])){echo $new_target_arr_lunch[3]['t2'];}?>">
                                                    <span class="help-block"> 大入額 </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">② 金</label>
                                                <div class="col-md-4">
                                                    <input name="portlet_tab2_2[numTwo][tOne]" readonly type="text" class="form-control numTwo tOne" placeholder="金額を入力してください" value="<?if(isset($new_target_arr_lunch[2]['t1'])){echo $new_target_arr_lunch[2]['t1'];}?>">
                                                    <span class="help-block"> 目標額 </span>
                                                </div>
                                                <div class="col-md-4">
                                                    <input name="portlet_tab2_2[numTwo][tTwo]" readonly type="text" class="form-control numTwo tTwo" placeholder="金額を入力してください" value="<?if(isset($new_target_arr_lunch[2]['t2'])){echo $new_target_arr_lunch[2]['t2'];}?>">
                                                    <span class="help-block"> 大入額 </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">④ 日</label>
                                                <div class="col-md-4">
                                                    <input name="portlet_tab2_2[numFour][tOne]" readonly type="text" class="form-control numFour tOne" placeholder="金額を入力してください" value="<?if(isset($new_target_arr_lunch[4]['t1'])){echo $new_target_arr_lunch[4]['t1'];}?>">
                                                    <span class="help-block"> 目標額 </span>
                                                </div>
                                                <div class="col-md-4">
                                                    <input name="portlet_tab2_2[numFour][tTwo]" readonly type="text" class="form-control numFour tTwo" placeholder="金額を入力してください" value="<?if(isset($new_target_arr_lunch[4]['t2'])){echo $new_target_arr_lunch[4]['t2'];}?>">
                                                    <span class="help-block"> 大入額 </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-offset-6 col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">⑤ 祝日</label>
                                                <div class="col-md-4">
                                                    <input name="portlet_tab2_2[numFive][tOne]" readonly type="text" class="form-control numFive tOne" placeholder="金額を入力してください" value="<?if(isset($new_target_arr_lunch[5]['t1'])){echo $new_target_arr_lunch[5]['t1'];}?>">
                                                    <span class="help-block"> 目標額 </span>
                                                </div>
                                                <div class="col-md-4">
                                                    <input name="portlet_tab2_2[numFive][tTwo]" readonly type="text" class="form-control numFive tTwo" placeholder="金額を入力してください" value="<?if(isset($new_target_arr_lunch[5]['t2'])){echo $new_target_arr_lunch[5]['t2'];}?>">
                                                    <span class="help-block"> 大入額 </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>

                                    <h3 class="form-section">Divided per day of the week</h3>
                                    <div class="row dividedByDay">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">① 月〜木</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" placeholder="金額を入力してください" value="<?if(isset($target_arr_lunch[1]['fee'])){echo $target_arr_lunch[1]['fee'];}?>">
                                                    <span class="help-block"> 金額 </span>
                                                </div>
                                                <div class="col-md-3">
                                                    <select class="form-control numOne">
                                                        <?for($i=0;$i<30;$i++):?>
                                                            <option value="<?echo $i;?>" <?if(isset($target_arr_lunch[1]['num'])&&$target_arr_lunch[1]['num']==$i){echo "selected";}?>><?echo $i;?></option>
                                                        <?endfor;?>
                                                    </select>
                                                    <span class="help-block"> 日数 </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">③ 土</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" placeholder="金額を入力してください" value="<?if(isset($target_arr_lunch[3]['fee'])){echo $target_arr_lunch[3]['fee'];}?>">
                                                    <span class="help-block"> 金額 </span>
                                                </div>
                                                <div class="col-md-3">
                                                    <select class="form-control numThree">
                                                        <?for($i=0;$i<30;$i++):?>
                                                            <option value="<?echo $i;?>" <?if(isset($target_arr_lunch[3]['num'])&&$target_arr_lunch[3]['num']==$i){echo "selected";}?>><?echo $i;?></option>
                                                        <?endfor;?>
                                                    </select>
                                                    <span class="help-block"> 日数 </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/row-->
                                    <div class="row dividedByDay">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">② 金</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" placeholder="金額を入力してください" value="<?if(isset($target_arr_lunch[2]['fee'])){echo $target_arr_lunch[2]['fee'];}?>">
                                                    <span class="help-block"> 金額 </span>
                                                </div>
                                                <div class="col-md-3">
                                                    <select class="form-control numTwo">
                                                        <?for($i=0;$i<30;$i++):?>
                                                            <option value="<?echo $i;?>" <?if(isset($target_arr_lunch[2]['num'])&&$target_arr_lunch[2]['num']==$i){echo "selected";}?>><?echo $i;?></option>
                                                        <?endfor;?>
                                                    </select>
                                                    <span class="help-block"> 日数 </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">④ 日</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" placeholder="金額を入力してください" value="<?if(isset($target_arr_lunch[4]['fee'])){echo $target_arr_lunch[4]['fee'];}?>">
                                                    <span class="help-block"> 金額 </span>
                                                </div>
                                                <div class="col-md-3">
                                                    <select class="form-control numFour">
                                                        <?for($i=0;$i<30;$i++):?>
                                                            <option value="<?echo $i;?>" <?if(isset($target_arr_lunch[4]['num'])&&$target_arr_lunch[4]['num']==$i){echo "selected";}?>><?echo $i;?></option>
                                                        <?endfor;?>
                                                    </select>
                                                    <span class="help-block"> 日数 </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row dividedByDay">
                                        <div class="col-md-offset-6 col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">⑤ 祝日</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" placeholder="金額を入力してください" value="<?if(isset($target_arr_lunch[5]['fee'])){echo $target_arr_lunch[5]['fee'];}?>">
                                                    <span class="help-block"> 金額 </span>
                                                </div>
                                                <div class="col-md-3">
                                                    <select class="form-control numFive">
                                                        <?for($i=0;$i<30;$i++):?>
                                                            <option value="<?echo $i;?>" <?if(isset($target_arr_lunch[5]['num'])&&$target_arr_lunch[5]['num']==$i){echo "selected";}?>><?echo $i;?></option>
                                                        <?endfor;?>
                                                    </select>
                                                    <span class="help-block"> 日数 </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <h3 class="form-section">Averages</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">① 月〜木</label>
                                                <div class="col-md-5">
                                                    <input readonly type="text" class="form-control numOne" placeholder="金額を入力してください" value="<?if(isset($new_target_arr_lunch[1]['fee'])){echo $new_target_arr_lunch[1]['fee'];}?>">
                                                    <span class="help-block"> 金額 </span>
                                                </div>
                                                <div class="col-md-2">
                                                    <select class="form-control numOne tOne">
                                                        <?for($i=101;$i<110;$i++):?>
                                                            <option value="<?echo $i/100;?>" <?if($i==$t1){echo "selected";}?>><?echo $i/100;?></option>
                                                        <?endfor;?>
                                                    </select>
                                                    <span class="help-block"> 目標率 </span>
                                                </div>
                                                <div class="col-md-2">
                                                    <select class="form-control numOne tTwo">
                                                        <?for($i=11;$i<20;$i++):?>
                                                            <option value="<?echo $i/10;?>" <?if($i==$t2){echo "selected";}?>><?echo $i/10;?></option>
                                                        <?endfor;?>
                                                    </select>
                                                    <span class="help-block"> 大入率 </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">③ 土</label>
                                                <div class="col-md-5">
                                                    <input readonly type="text" class="form-control numThree" placeholder="金額を入力してください" value="<?if(isset($new_target_arr_lunch[3]['fee'])){echo $new_target_arr_lunch[3]['fee'];}?>">
                                                    <span class="help-block"> 金額 </span>
                                                </div>
                                                <div class="col-md-2">
                                                    <select class="form-control numThree tOne">
                                                        <?for($i=101;$i<110;$i++):?>
                                                            <option value="<?echo $i/100;?>" <?if($i==$t1){echo "selected";}?>><?echo $i/100;?></option>
                                                        <?endfor;?>
                                                    </select>
                                                    <span class="help-block"> 目標率 </span>
                                                </div>
                                                <div class="col-md-2">
                                                    <select class="form-control numThree tTwo">
                                                        <?for($i=11;$i<20;$i++):?>
                                                            <option value="<?echo $i/10;?>" <?if($i==$t2){echo "selected";}?>><?echo $i/10;?></option>
                                                        <?endfor;?>
                                                    </select>
                                                    <span class="help-block"> 大入率 </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">② 金</label>
                                                <div class="col-md-5">
                                                    <input readonly type="text" class="form-control numTwo" placeholder="金額を入力してください" value="<?if(isset($new_target_arr_lunch[2]['fee'])){echo $new_target_arr_lunch[2]['fee'];}?>">
                                                    <span class="help-block"> 金額 </span>
                                                </div>
                                                <div class="col-md-2">
                                                    <select class="form-control numTwo tOne">
                                                        <?for($i=101;$i<110;$i++):?>
                                                            <option value="<?echo $i/100;?>" <?if($i==$t1){echo "selected";}?>><?echo $i/100;?></option>
                                                        <?endfor;?>
                                                    </select>
                                                    <span class="help-block"> 目標率 </span>
                                                </div>
                                                <div class="col-md-2">
                                                    <select class="form-control numTwo tTwo">
                                                        <?for($i=11;$i<20;$i++):?>
                                                            <option value="<?echo $i/10;?>" <?if($i==$t2){echo "selected";}?>><?echo $i/10;?></option>
                                                        <?endfor;?>
                                                    </select>
                                                    <span class="help-block"> 大入率 </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">④ 日</label>
                                                <div class="col-md-5">
                                                    <input readonly type="text" class="form-control numFour" placeholder="金額を入力してください" value="<?if(isset($new_target_arr_lunch[4]['fee'])){echo $new_target_arr_lunch[4]['fee'];}?>">
                                                    <span class="help-block"> 金額 </span>
                                                </div>
                                                <div class="col-md-2">
                                                    <select class="form-control numFour tOne">
                                                        <?for($i=101;$i<110;$i++):?>
                                                            <option value="<?echo $i/100;?>" <?if($i==$t1){echo "selected";}?>><?echo $i/100;?></option>
                                                        <?endfor;?>
                                                    </select>
                                                    <span class="help-block"> 目標率 </span>
                                                </div>
                                                <div class="col-md-2">
                                                    <select class="form-control numFour tTwo">
                                                        <?for($i=11;$i<20;$i++):?>
                                                            <option value="<?echo $i/10;?>" <?if($i==$t2){echo "selected";}?>><?echo $i/10;?></option>
                                                        <?endfor;?>
                                                    </select>
                                                    <span class="help-block"> 大入率 </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-offset-6 col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">⑤ 祝日</label>
                                                <div class="col-md-5">
                                                    <input readonly type="text" class="form-control numFive" placeholder="金額を入力してください" value="<?if(isset($new_target_arr_lunch[5]['fee'])){echo $new_target_arr_lunch[5]['fee'];}?>">
                                                    <span class="help-block"> 掛率 </span>
                                                </div>
                                                <div class="col-md-2">
                                                    <select class="form-control numFive tOne">
                                                        <?for($i=101;$i<110;$i++):?>
                                                            <option value="<?echo $i/100;?>" <?if($i==$t1){echo "selected";}?>><?echo $i/100;?></option>
                                                        <?endfor;?>
                                                    </select>
                                                    <span class="help-block"> 目標率 </span>
                                                </div>
                                                <div class="col-md-2">
                                                    <select class="form-control numFive tTwo">
                                                        <?for($i=11;$i<20;$i++):?>
                                                            <option value="<?echo $i/10;?>" <?if($i==$t2){echo "selected";}?>><?echo $i/10;?></option>
                                                        <?endfor;?>
                                                    </select>
                                                    <span class="help-block"> 大入率 </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                        </div>
                        <!-- END tab2 -->
                    </div>
                    <?
                    echo $this->Form->end();
                    ?>
                </div>
            </div>
            <!-- End Result -->

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
<script>
    $(function() {
        // 曜日別売上平均計算
        $(".dividedByDay").find("select").change(function() {
            // Tab取得
            var tab = $(this).parent().parent().parent().parent().parent().parent().attr("id");
            // 日数取得
            var days = $(this).val();
            // 売上取得
            var fee = $(this).parent().parent().parent().find("input").val();
            // 平均値計算
            if(days!=null&&days!=0&&fee!=null&&fee!=0){
                var average = Math.floor(fee/days);
                // クラス名取得
                var className =  $(this).attr("class").split(" ")[1];
                // クラス対応input取得&値設定
                $("#"+tab).find("input[class='form-control "+className+"']").val(average);
            }
        });
        // 曜日別目標額計算
        $(".tOne").change(function() {
            // Tab取得
            var tab = $(this).parent().parent().parent().parent().parent().parent().attr("id");
            // 掛率取得
            var per = $(this).val();
            // 売上取得
            var fee = $(this).parent().parent().parent().find("input").val();
            // 目標額計算
            if(per!=null&&fee!=null){
                var score = Math.floor(fee*per);
                // クラス名取得
                var className =  $(this).attr("class").split(" ")[1];
                // クラス対応input取得&値設定
                $("#"+tab).find("input[class='form-control "+className+" tOne"+"']").val(score);
            }
        });
        // 曜日別大入額計算
        $(".tTwo").change(function() {
            // Tab取得
            var tab = $(this).parent().parent().parent().parent().parent().parent().attr("id");
            // 掛率取得
            var per = $(this).val();
            // 売上取得
            var fee = $(this).parent().parent().parent().find("input").val();
            // 目標額計算
            if(per!=null&&fee!=null){
                var score = Math.floor(fee*per);
                // クラス名取得
                var className =  $(this).attr("class").split(" ")[1];
                // クラス対応input取得&値設定
                $("#"+tab).find("input[class='form-control "+className+" tTwo"+"']").val(score);
            }
        });

        // Excel出力
        $("#excel").click(function(){
            if (confirm('設定を保存してExcel出力します\nよろしいですか？')) {
                $("#form_submit").submit();
            }
            else{
                return false;
            }
        });

    });
</script>
