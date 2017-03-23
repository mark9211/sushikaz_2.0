<?
#cssファイル
echo $this->Html->css('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css');
echo $this->Html->css('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css');
echo $this->Html->css('assets/global/plugins/jquery-tags-input/jquery.tagsinput.css');
echo $this->Html->css('assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css');
echo $this->Html->css('assets/global/plugins/typeahead/typeahead.css');

echo $this->Html->css('assets/global/plugins/clockface/css/clockface.css');
echo $this->Html->css('assets/global/plugins/bootstrap-datepicker/css/datepicker3.css');
echo $this->Html->css('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css');
echo $this->Html->css('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css');
echo $this->Html->css('assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css');
echo $this->Html->css('assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css');

echo $this->Html->css('assets/global/plugins/icheck/skins/all.css');

#jsファイル
echo $this->Html->script('jquery-ui-1.10.4.custom.js');
echo $this->Html->script('assets/global/plugins/fuelux/js/spinner.min.js');
echo $this->Html->script('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js');
echo $this->Html->script('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js');
echo $this->Html->script('assets/global/plugins/jquery.input-ip-address-control-1.0.min.js');
echo $this->Html->script('assets/global/plugins/bootstrap-pwstrength/pwstrength-bootstrap.min.js');
echo $this->Html->script('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js');
echo $this->Html->script('assets/global/plugins/jquery-tags-input/jquery.tagsinput.min.js');
echo $this->Html->script('assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js');
echo $this->Html->script('assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js');
echo $this->Html->script('assets/global/plugins/typeahead/handlebars.min.js');
echo $this->Html->script('assets/global/plugins/typeahead/typeahead.bundle.min.js');
echo $this->Html->script('assets/global/plugins/ckeditor/ckeditor.js');

echo $this->Html->script('assets/global/plugins/moment.min.js');
echo $this->Html->script('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js');
echo $this->Html->script('assets/global/plugins/bootstrap-datepaginator/bootstrap-datepaginator.min.js');

echo $this->Html->script('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js');
echo $this->Html->script('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js');
echo $this->Html->script('assets/global/plugins/clockface/js/clockface.js');
echo $this->Html->script('assets/global/plugins/bootstrap-daterangepicker/moment.min.js');
echo $this->Html->script('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js');
echo $this->Html->script('assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js');
echo $this->Html->script('assets/admin/pages/scripts/ui-datepaginator.js');
?>
<?
echo $this->Form->create('Stocktakings', array('action'=>'edit', 'id'=>'form_submit'));
?>
<div class="container">
    <div class="row">
        <!-- BEGIN PORTLET-->
        <div class="portlet light form-fit">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase">日付選択</span>
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <div class="form-body">
                    <div class="form-group">
                        <div class="col-md-2">
                            <input id="datepicker" name="month" data-date-format="yyyy-mm" class="form-control input-small date-picker" size="16" type="text" value="<?echo $month;?>" readonly>
                            <script>
                                $('#datepicker').datepicker({
                                    dateFormat: "yy-mm",
                                    numberOfMonths: 2,
                                    minDate: 0,
                                    maxDate: '+1M'
                                });
                            </script>
                            <!-- /input-group -->
                            <span class="help-block">
                                月を選択してください
                            </span>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn green-haze" onClick="goNextDay();">月選択</button>
                            <script>
                                function goNextDay(){
                                    var date  = $("#datepicker").val();
                                    var url   = location.href;
                                    var parameters    = url.split("?");
                                    var dateJob = parameters[1].split("=");
                                    if (date != dateJob[1]) {
                                        window.location.href = '?month='+date;
                                    };
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>

    <?foreach($stocking_types as $key => $stocking_type_arr):?>
        <div class="col-md-<?echo 12/$boxNum;?>">
            <div class="portlet box red" style="margin: 30px">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs"></i><?echo $associations[$key];?> 棚卸入力（<?echo date('Y年m月', strtotime($month));?>分）
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
                                <th width="20%">
                                    カテゴリー
                                </th>
                                <th width="30%">
                                    前月
                                </th>
                                <th class="30%">
                                    今月
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?foreach($stocking_type_arr as $stocking_type):?>
                                <tr>
                                    <td>
                                        <?echo $stocking_type['StocktakingType']['name']?>
                                    </td>
                                    <td class="numeric">
                                        <input name="Stocktaking[<?echo $key;?>][<?echo $stocking_type['StocktakingType']['id'];?>][last_month]" class="form-control" type="text" value="<?if(isset($stocking_type['ThisMonth'])){echo $stocking_type['ThisMonth']['Stocktaking']['last_month'];}elseif(isset($stocking_type['LastMonth'])){echo $stocking_type['LastMonth']['Stocktaking']['this_month'];}?>">
                                    </td>
                                    <td class="numeric">
                                        <input name="Stocktaking[<?echo $key;?>][<?echo $stocking_type['StocktakingType']['id'];?>][this_month]" class="form-control" type="text" value="<?if(isset($stocking_type['ThisMonth'])){echo $stocking_type['ThisMonth']['Stocktaking']['this_month'];}?>">
                                    </td>
                                </tr>
                            <?endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?endforeach;?>

    <div class="row">
        <div class="col-md-12">
            <input type="button" id="button_submit" onmouseover="this.style.backgroundColor='#36C3FF'"
                   onmouseout="this.style.backgroundColor='#ff5252'"; class="list-group-item list-group-item-danger" style="height:90px; width:90%; color:white; text-align:center; font-size:50px; font-weight:bold; background-color:#ff5252; letter-spacing:20px;margin: auto;margin-bottom: 50px;" value="送信">
        </div>
        <script>
            $('#button_submit').click(function() {
                //合計値正誤確認
                $('#form_submit').submit();
                $(this).attr("disabled", "disabled");
            });
        </script>
    </div>
</div>
<?echo $this->Form->end();?>
<script>
    jQuery(document).ready(function() {
        // initiate layout and plugins
        Metronic.init(); // init metronic core components
        Layout.init(); // init current layout
        Demo.init(); // init demo features
    });
</script>