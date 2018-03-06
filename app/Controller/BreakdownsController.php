<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 18/02/07
 * Time: 14:48
 */
class BreakdownsController extends AppController{

    # 共通スクリプト
    public function beforeFilter(){
        parent::beforeFilter();
        $this->set('title_for_layout', 'システム連携 | 寿し和');
        #ログイン処理
        $this->to_login();
    }

    public function index(){
        if($this->request->is('post')){
            # クッキー値
            $location = $this->myData;
            # FileInfo
            $tmp = $this->request->params['form']['file']['tmp_name'];
            $name = $this->request->params['form']['file']['name'];
            $data = [];
            $order_data = [];
            # 店舗条件分岐
            if($location['Location']['name']=='池袋店'||$location['Location']['name']=='赤羽店'){
                # Airレジ出力CSV連携
                if(mb_substr($name, 0, 4,"UTF-8")=='会計明細'){
                    #アップロード処理
                    $ext = pathinfo($name, PATHINFO_EXTENSION);
                    $save_path = WWW_ROOT."files".DS."sql".DS.$name;
                    if(is_uploaded_file($tmp)) {
                        if($ext=='CSV'||$ext=='csv'){
                            if(move_uploaded_file($tmp, $save_path)){
                                $handle = fopen($save_path, "r");
                                if($handle!==false){
                                    # Data格納
                                    $records = [];
                                    while (($line = fgetcsv($handle, 1000, ",")) !== false) {
                                        if($line[0]!=null){ $records[] = $line; }
                                    }
                                    fclose($handle);
                                    #エンコードエラー
                                    if($records==null){ echo "Error:Character Encoding Error";exit; }
                                    else{
                                        #文字エンコード変換（SJIS=>UTF-8）
                                        mb_convert_variables('UTF-8','SJIS',$records);
                                    }
                                    # 不要カラム削除
                                    unset($records[0]);
                                    # CSV Rowデータ整形
                                    $shaped_records = $this->shape_array($records);
                                    # ドリンクカテゴリ
                                    $drink_arr = $this->init_categories($location);
                                    # 商品マート集計
                                    $order_data = $this->order_group($shaped_records, $drink_arr);
                                    # レシート毎集計
                                    $data = $this->group_array($shaped_records, $drink_arr);
                                }
                            }
                        }
                    }
                }
            }
            elseif($location['Location']['name']=='和光店'){
                # POS+出力CSV連携
                if(mb_substr($name, 15, 15,"UTF-8")=='general_purpose'){
                    #アップロード処理
                    $ext = pathinfo($name, PATHINFO_EXTENSION);
                    $save_path = WWW_ROOT."files".DS."sql".DS.$name;
                    if(is_uploaded_file($tmp)) {
                        if($ext=='CSV'||$ext=='csv'){
                            if(move_uploaded_file($tmp, $save_path)){
                                $handle = fopen($save_path, "r");
                                if($handle!==false){
                                    # Data格納
                                    $records = [];
                                    while (($line = fgetcsv($handle, 1000, ",")) !== false) {
                                        if($line[0]!=null){ $records[] = $line; }
                                    }
                                    fclose($handle);
                                    #エンコードエラー
                                    if($records==null){ echo "Error:Character Encoding Error";exit; }
                                    else{
                                        #文字エンコード変換（SJIS=>UTF-8）
                                        mb_convert_variables('UTF-8','SJIS',$records);
                                    }
                                    # 不要カラム削除
                                    unset($records[0]);
                                    # CSV Rowデータ整形
                                    $shaped_records = $this->shape_array_postas($records);
                                    # 商品マート集計
                                    $order_data = $this->order_group_postas($shaped_records);
                                    # レシート毎集計
                                    $data = $this->group_array_postas($shaped_records);
                                }
                            }
                        }
                    }
                }
            }
            # receipt_summaries DATA
            if($data!=null){
                foreach($data as $d){
                    # 既存レコード検索
                    $receipt_summary = $this->ReceiptSummary->find('first', array(
                        'conditions' => array('ReceiptSummary.location_id'=>$location['Location']['id'], 'ReceiptSummary.working_day'=>$d[0], 'ReceiptSummary.receipt_id'=>$d[1])
                    ));
                    if($receipt_summary==null){
                        # 新規インサート
                        $insert = array('ReceiptSummary' => array(
                            'location_id' => $location['Location']['id'],
                            'working_day' => $d[0],
                            'receipt_id' => $d[1],
                            'total' => $d[2],
                            'tax' => $d[3],
                            'visitors' => $d[4],
                            'quantity' => $d[15],
                            'brand_name' => $d[5],
                            'breakdown_name' => $d[6],
                            'food' => $d[7],
                            'drink' => $d[8],
                            'credit' => $d[9],
                            'voucher' => $d[10],
                            'discount' => $d[11],
                            'other' => $d[13],
                            'time' => $d[12],
                            'visiting_time' => $d[14],
                        ));
                        $this->ReceiptSummary->create(false);
                        $this->ReceiptSummary->save($insert);
                    }
                }
            }
            # order_summaries DATA
            if($order_data!=null){
                foreach($order_data as $receipt_id => $ods){
                    # 既存レコード検索
                    $order_summary = $this->OrderSummary->find('first', array(
                        'conditions' => array('OrderSummary.location_id'=>$location['Location']['id'], 'OrderSummary.receipt_id'=>$receipt_id)
                    ));
                    if($order_summary==null && $ods!=null){
                        foreach($ods as $od){
                            # 新規インサート
                            $insert = array('OrderSummary' => array(
                                'location_id' => $location['Location']['id'],
                                'working_day' => $od[0],
                                'receipt_id' => $od[1],
                                'brand_name' => $od[2],
                                'breakdown_name' => $od[3],
                                'fd' => $od[4],
                                'category_name' => $od[5],
                                'menu_name' => $od[6],
                                'price' => $od[7],
                                'order_num' => $od[8],
                            ));
                            $this->OrderSummary->create(false);
                            $this->OrderSummary->save($insert);
                        }
                    }
                }
            }
            $this->Session->setFlash('Import完了しました');
            $this->redirect(array('controller'=>'locations', 'action'=>'index'));
        }
    }

    # Airレジ用ドリンクカテゴリinit設定
    private function init_categories($location){
        $arr = [];
        if($location['Location']['name']=='池袋店'){
            $arr=array("ビール", "ウイスキー", "ウィスキー", "焼酎", "サワー", "ワイン", "ソフトドリンク", "日本酒", "果実酒", "割物");
        }
        elseif($location['Location']['name']=='赤羽店'){
            $arr=array("ソフトドリンク", "割り物", "焼酎ボトル", "焼酎グラス", "サワー・カクテル", "ウイスキー", "ウィスキー", "ワイン", "日本酒", "ビール");
        }
        return $arr;
    }

    # Airレジから抽出した配列を、営業日/伝票をkeyとして整形
    private function shape_array($records){
        $arr=[];
        if($records!=null){
            foreach($records as $record){
                # 営業日判定
                if($record[1]!=null&&$record[2]!=null){
                    $time = date("Y-m-d H:i:s", strtotime("$record[1] $record[2]"));
                    $working_day = $this->judge24Hour($time);
                }
                $arr[$working_day][$record[34]][] = $record;
            }
        }
        return $arr;
    }

    # Airレジカテゴリ設定を元にorderの振り分けを行う
    private function order_group($shaped_records, $drink_arr){
        $arr=[];
        if($shaped_records!=null){
            foreach($shaped_records as $working_day => $order){
                if($order!=null){
                    foreach($order as $receipt_id => $order_g){
                        if($order_g!=null){
                            foreach($order_g as $o){
                                # init
                                $brand = "寿し和";
                                $flag = "アラカルト";
                                $fd = "フード";
                                # ランチメニューが入っているか否か
                                if($o[24]=="ランチ"&&$o[28]>0){
                                    $flag = "ランチ";
                                }
                                #  テイクアウトメニューが入っているか否か
                                elseif($o[24]=="出前"&&$o[28]>0){
                                    $flag = "テイクアウト";
                                }
                                # コースメニューが入っているか否か
                                elseif($o[24]=="コース"&&$o[28]>0){
                                    $flag = "コース";
                                }
                                # フード/ドリンク
                                if(in_array($o[24], $drink_arr)){
                                    $fd = "ドリンク";
                                }
                                $arr[$receipt_id][] = array(0=>$working_day, 1=>$receipt_id, 2=>$brand, 3=>$flag, 4=>$fd, 5=>$o[24], 6=>$o[25], 7=>$o[28], 8=>$o[29]);
                            }
                        }
                    }
                }
            }
        }
        return $arr;
    }

    # Airレジカテゴリ設定を元にレシートの振り分けを行う
    private function group_array($shaped_records, $drink_arr){
        $arr=[];
        if($shaped_records!=null){
            foreach($shaped_records as $working_day => $receipt){
                #レシート振り分け
                if($receipt!=null){
                    foreach($receipt as $receipt_id => $receipt_g){
                        if($receipt_g!=null){
                            $total = 0;
                            $tax = 0;
                            $visitor = 0;
                            $credit = 0;
                            $voucher = 0;
                            $discount = 0;
                            $other = 0;
                            $drink = 0;
                            $quantity = 0;
                            $time = null;
                            $visiting_time = null;
                            $brand = "寿し和";
                            $flag = "アラカルト";
                            foreach($receipt_g as $r){
                                # ランチメニューが入っているか否か
                                if($r[24]=="ランチ"&&$r[28]>0){
                                    $flag = "ランチ";
                                }
                                #  テイクアウトメニューが入っているか否か
                                elseif($r[24]=="出前"&&$r[28]>0){
                                    $flag = "テイクアウト";
                                }
                                # コースメニューが入っているか否か
                                elseif($r[24]=="コース"&&$r[28]>0){
                                    $flag = "コース";
                                }
                                # フード/ドリンク内訳
                                if(in_array($r[24], $drink_arr)){
                                    $drink+=$r[28]*$r[29];
                                }
                                # 合計/小計/客数/売掛/金券/割引
                                if($r[3]!=null){ $total = (int)$r[3]; }
                                if($r[5]!=null){ $tax = (int)$r[5]; }
                                if($r[18]!=null){ $visitor = (int)$r[18]; }
                                if($r[19]!=null){ $quantity = (int)$r[19]; }
                                if($r[14]!=null){ $credit = (int)$r[14]; }
                                if($r[13]!=null){ $voucher = (int)$r[13]; }
                                if($r[17]!=null){ $discount = (int)$r[17]; }
                                if($r[1]!=null&&$r[2]!=null){ $time = date("Y-m-d H:i:s", strtotime("$r[1] $r[2]")); }
                                if($r[1]!=null&&$r[20]!=null){
                                    $h = date("G", strtotime($r[20]));
                                    $i = date("i", strtotime($r[20]));
                                    $s = date("s", strtotime($r[20]));
                                    $visiting_time = date("Y-m-d H:i:s",strtotime($time."-$h hours -$i minutes -$s seconds"));
                                }
                            }
                            if($total!=0){
                                $arr[] = array(0=>$working_day, 1=>$receipt_id, 2=>$total, 3=>$tax, 4=>$visitor, 5=>$brand, 6=>$flag, 7=>$total-$drink, 8=>$drink, 9=>$credit, 10=>$voucher, 11=>$discount, 12=>$time, 13=>$other, 14=>$visiting_time, 15=>$quantity);
                            }
                        }
                    }
                }
            }
        }
        return $arr;
    }

    # POS+用卓番init設定&Judge関数
    private function judge_by_table_number($r){
        # 寿し和エリア卓番配列
        $arr1 = ['CT4', 'CT5', 'CT6', 'CT7', 'CT8', 'CT9', 'CT10', 'CT11', 'CT12', 'CT13', 'CT14', 'CT15', 'CT16', 'CT17', 'CT18', 'CT19', 'CT20', 'T25', 'T26', 'T27', 'T28', 'T29', 'T30', 'T31', 'T100'];
        # 和香苑エリア卓番配列
        $arr2 = ['T51', 'T52', 'T53', 'T54', 'T55', 'T56', 'T57', 'T58', 'T59', 'T60', 'T65', 'T66', 'T67', 'T68', 'T70', 'T73', 'T74', 'T75', 'T76', 'T77', 'T78', 'T79', 'T80', 'T200'];
        # 配列判定
        $table_number = mb_substr($r[14], 10, null,"UTF-8");
        if(in_array($table_number, $arr1)){
            $brand = "寿し和";
        }
        elseif(in_array($table_number, $arr2)){
            $brand = "和香苑";
        }
        else{
            $brand = null;
        }
        return $brand;
    }

    # POS+から抽出した配列を、営業日/伝票をkeyとして整形
    private function shape_array_postas($records){
        $arr=[];
        if($records!=null){
            foreach($records as $record){
                # 営業日判定
                if($record[12]!=null){
                    $time = date("Y-m-d H:i:s", strtotime("$record[12]"));
                    $working_day = $this->judge24Hour($time);
                }
                $arr[$working_day][$record[2]][] = $record;
            }
        }
        return $arr;
    }

    # POS+用orderの振り分けを行う
    private function order_group_postas($shaped_records){
        $arr=[];
        if($shaped_records!=null){
            foreach($shaped_records as $working_day => $order){
                if($order!=null){
                    foreach($order as $receipt_id => $order_g){
                        if($order_g!=null){
                            foreach($order_g as $o){
                                # init
                                $brand = "寿し和";
                                $flag = "アラカルト";
                                # brand
                                if(strpos($o[54],'寿し和')!==false){
                                    $brand = "寿し和";
                                }
                                elseif(strpos($o[54],'和香苑')!==false){
                                    $brand = "和香苑";
                                }
                                elseif(strpos($o[54],'ドリンク')!==false){
                                    $brand = $this->judge_by_table_number($o);
                                }
                                # breakdown
                                if(strpos($o[55],'ランチ')!==false){
                                    $flag = "ランチ";
                                }
                                elseif(strpos($o[55],'テイクアウト')!==false){
                                    $flag = "テイクアウト";
                                }
                                elseif(strpos($o[55],'コース')!==false){
                                    $flag = "コース";
                                }
                                $arr[$receipt_id][] = array(0=>$working_day, 1=>$receipt_id, 2=>$brand, 3=>$flag, 4=>$o[56], 5=>$o[57], 6=>$o[60], 7=>$o[64], 8=>$o[65]);
                            }
                        }
                    }
                }
            }
        }
        return $arr;
    }

    # POS+用レシートの振り分けを行う
    private function group_array_postas($shaped_records){
        $arr=[];
        if($shaped_records!=null){
            foreach($shaped_records as $working_day => $receipt){
                if($receipt!=null){
                    foreach($receipt as $receipt_id => $receipt_g){
                        if($receipt_g!=null){
                            # ブランド&内訳振り分け
                            $total = 0;
                            $tax = 0;
                            $visitor = 0;
                            $quantity = 0;
                            $credit = 0;
                            $voucher = 0;
                            $discount = 0;
                            $other = 0;
                            $drink = 0;
                            $time = null;
                            $visiting_time = null;
                            $brand = "寿し和";
                            $flag = "アラカルト";
                            foreach($receipt_g as $r){
                                # ブランド切り分け
                                $brand = $this->judge_by_table_number($r);
                                if($brand==null){
                                    if($r[54]=="寿し和"||$r[54]=="和香苑"){ $brand = $r[54]; }else{ $brand = "寿し和"; }
                                }
                                # ランチメニューが入っているか否か
                                if(strpos($r[55],'ランチ')!==false && $r[64]>0){
                                    $flag = "ランチ";
                                }
                                #  テイクアウトメニューが入っているか否か
                                elseif(strpos($r[55],'テイクアウト')!==false && $r[64]>0){
                                    $flag = "テイクアウト";
                                }
                                # コースメニューが入っているか否か
                                elseif(strpos($r[55],'コース')!==false && $r[64]>0){
                                    $flag = "コース";
                                }
                                # フード/ドリンク内訳
                                if($r[56]=="ドリンク"){
                                    $drink+=$r[64]*$r[65];
                                }
                                # 合計/小計/客数/売掛/金券/割引
                                if($r[22]!=null){ $total = (int)$r[22]; }
                                if($r[23]!=null){ $tax = (int)$r[23]; }
                                if($r[15]!=null){ $visitor = (int)$r[15]; }
                                if($r[21]!=null){ $quantity = (int)$r[21]; }
                                if($r[30]!=null){ $credit = (int)$r[30]; }
                                if($r[31]!=null){ $voucher = (int)$r[31]; }
                                if($r[28]!=null){ $discount = (int)$r[28]*-1; }
                                if($r[35]!=null){ $other = (int)$r[35]; }
                                if($r[13]!=null){ $time = date("Y-m-d H:i:s", strtotime("$r[13]")); }
                                if($r[12]!=null){ $visiting_time = date("Y-m-d H:i:s", strtotime("$r[12]")); }
                            }
                            if($total!=0){
                                $arr[] = array(0=>$working_day, 1=>$receipt_id, 2=>$total, 3=>$tax, 4=>$visitor, 5=>$brand, 6=>$flag, 7=>$total-$drink, 8=>$drink, 9=>$credit, 10=>$voucher, 11=>$discount, 12=>$time, 13=>$other, 14=>$visiting_time, 15=>$quantity);
                            }
                        }
                    }
                }
            }
        }
        return $arr;
    }

    # 営業日ジャッジ ＊引数（文字列）
    private function judge24Hour($now){
        #日付
        $working_day = date('Y-m-d', strtotime($now));
        #時刻
        $hour = date('G', strtotime($now));
        if ($hour < 8) {
            $working_day = date('Y-m-d', strtotime("$working_day -1 day"));
            return $working_day;
        } else{
            return $working_day;
        }
    }

}