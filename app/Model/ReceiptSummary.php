<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 18/02/08
 * Time: 16:55
 */
class ReceiptSummary extends AppModel {
    //table指定
    public $useTable="receipt_summaries";

    #営業日取得byMonth
    public function getWorkingDay($location_id, $working_month){
        $working_days = $this->find('list', array(
            'fields' => array('ReceiptSummary.working_day'),
            'conditions' => array('ReceiptSummary.location_id' => $location_id, 'ReceiptSummary.working_day LIKE' => '%'.$working_month.'%'),
            'group' => array('ReceiptSummary.working_day'),
        ));
        return $working_days;
    }

    #月別&ブランド別サマリ
    public function monthlySummarize($location_id, $working_month, $brand){
        $receipt_summary = $this->find('first', array(
            'fields' => array(
                'sum(ReceiptSummary.total) as total',
                'sum(ReceiptSummary.tax) as tax',
                'sum(ReceiptSummary.food) as food',
                'sum(ReceiptSummary.drink) as drink',
                'sum(CASE WHEN ReceiptSummary.breakdown_name = "ランチ" THEN ReceiptSummary.total ELSE 0 END) as lunch',
                'sum(CASE WHEN ReceiptSummary.breakdown_name = "ランチ" THEN ReceiptSummary.visitors ELSE 0 END) as lunch_visitors',
                'sum(CASE WHEN ReceiptSummary.breakdown_name = "アラカルト" THEN ReceiptSummary.total ELSE 0 END) as dinner',
                'sum(CASE WHEN ReceiptSummary.breakdown_name = "アラカルト" THEN ReceiptSummary.visitors ELSE 0 END) as dinner_visitors',
                'sum(CASE WHEN ReceiptSummary.breakdown_name = "コース" THEN ReceiptSummary.total ELSE 0 END) as course',
                'sum(CASE WHEN ReceiptSummary.breakdown_name = "コース" THEN ReceiptSummary.visitors ELSE 0 END) as course_visitors',
                'sum(CASE WHEN ReceiptSummary.breakdown_name = "テイクアウト" THEN ReceiptSummary.total ELSE 0 END) as takeout',
                'sum(CASE WHEN ReceiptSummary.breakdown_name = "テイクアウト" THEN ReceiptSummary.visitors ELSE 0 END) as takeout_visitors',
                'sum(ReceiptSummary.credit) as credit',
                'sum(ReceiptSummary.voucher) as voucher',
                'sum(ReceiptSummary.discount) as discount',
                'sum(ReceiptSummary.other) as other',
            ),
            'conditions' => array(
                'ReceiptSummary.location_id' => $location_id,
                'ReceiptSummary.working_day LIKE' => '%'.$working_month.'%',
                'ReceiptSummary.brand_name' => $brand
            ),
            'group' => array('DATE_FORMAT(working_day, "%Y-%m")'),
        ));
        if(isset($receipt_summary[0])){
            return $receipt_summary[0];
        }
        else{
            return null;
        }
    }

    #日別サマリ
    public function dailySummarize($location_id, $working_day){
        $receipt_summary = $this->find('first', array(
            'fields' => array(
                'sum(ReceiptSummary.total) as total',
                'sum(ReceiptSummary.tax) as tax',
                'sum(ReceiptSummary.visitors) as visitors',
                'sum(ReceiptSummary.food) as food',
                'sum(ReceiptSummary.drink) as drink',
                'sum(ReceiptSummary.credit) as credit',
                'sum(ReceiptSummary.voucher) as voucher',
                'sum(ReceiptSummary.discount) as discount',
                'sum(ReceiptSummary.other) as other',
            ),
            'conditions' => array('ReceiptSummary.location_id' => $location_id, 'ReceiptSummary.working_day' => $working_day),
            'group' => array('ReceiptSummary.working_day'),
        ));
        return $receipt_summary;
    }

    #日別ブランド別サマリ
    public function brandSummarize($location_id, $working_day){
        $arr = [];
        $brands = $this->brand_init();
        foreach ($brands as $brand){
            $receipt_summary = $this->find('first', array(
                'fields' => array('sum(ReceiptSummary.total) as total','sum(ReceiptSummary.tax) as tax','sum(ReceiptSummary.visitors) as visitors','sum(ReceiptSummary.food) as food','sum(ReceiptSummary.drink) as drink'),
                'conditions' => array('ReceiptSummary.location_id' => $location_id, 'ReceiptSummary.working_day' => $working_day, 'ReceiptSummary.brand_name' =>$brand),
                'group' => array('ReceiptSummary.working_day'),
            ));
            if(isset($receipt_summary[0])){ $arr[$brand] = $receipt_summary[0]; }
        }
        return $arr;
    }

    #日別内訳別サマリ
    public function breakdownSummarize($location_id, $working_day, $brand){
        $arr = [];
        $breakdowns = $this->breakdown_init();
        foreach ($breakdowns as $breakdown){
            $receipt_summary = $this->find('first', array(
                'fields' => array('sum(ReceiptSummary.total) as total','sum(ReceiptSummary.tax) as tax','sum(ReceiptSummary.visitors) as visitors','sum(ReceiptSummary.food) as food','sum(ReceiptSummary.drink) as drink'),
                'conditions' => array('ReceiptSummary.location_id' => $location_id, 'ReceiptSummary.working_day' => $working_day, 'ReceiptSummary.brand_name' => $brand, 'ReceiptSummary.breakdown_name' => $breakdown),
                'group' => array('ReceiptSummary.working_day'),
            ));
            if(isset($receipt_summary[0])){ $arr[$breakdown] = $receipt_summary[0]; }
        }
        return $arr;
    }

    #日別売掛データ
    public function creditData($location_id, $working_day){
        $receipt_summaries = $this->find('all', array(
            'conditions' => array('ReceiptSummary.location_id' => $location_id, 'ReceiptSummary.working_day' => $working_day, 'ReceiptSummary.credit >' => 0),
        ));
        return $receipt_summaries;
    }

    #日別金券データ
    public function voucherData($location_id, $working_day){
        $receipt_summaries = $this->find('all', array(
            'conditions' => array('ReceiptSummary.location_id' => $location_id, 'ReceiptSummary.working_day' => $working_day, 'ReceiptSummary.voucher >' => 0),
        ));
        return $receipt_summaries;
    }

    #日別割引/割り増しデータ
    public function discountData($location_id, $working_day){
        $receipt_summaries = $this->find('all', array(
            'conditions' => array('ReceiptSummary.location_id' => $location_id, 'ReceiptSummary.working_day' => $working_day, "NOT" =>array('ReceiptSummary.discount' => 0)),
        ));
        return $receipt_summaries;
    }

    #税日次集計
    public function taxDaily($location_id, $working_day){
        $receipt_summary = $this->find('first', array(
            'fields' => array('sum(ReceiptSummary.tax) as tax'),
            'conditions' => array('ReceiptSummary.location_id' => $location_id, 'ReceiptSummary.working_day' => $working_day),
            'group' => array('ReceiptSummary.working_day'),
        ));
        if(isset($receipt_summary[0])){
            return $receipt_summary[0]['tax'];
        }
        else{
            return null;
        }
    }

    #日次時間帯別サマリ
    public function timezoneSummarize($location_id, $working_day){
        $receipt_summary = $this->find('all', array(
            'fields' => array(
                'time_format(ReceiptSummary.time, "%H") as hour',
                'sum(ReceiptSummary.total) as total',
                'sum(ReceiptSummary.tax) as tax',
                'sum(ReceiptSummary.visitors) as visitors',
                'sum(ReceiptSummary.food) as food',
                'sum(ReceiptSummary.drink) as drink',
            ),
            'conditions' => array('ReceiptSummary.location_id' => $location_id, 'ReceiptSummary.working_day' => $working_day),
            'group' => array('time_format(ReceiptSummary.time, "%H")'),
        ));
        return $receipt_summary;
    }

    private function brand_init(){
        $arr = ['寿し和', '和香苑'];
        return $arr;
    }

    private function breakdown_init(){
        $arr = ['ランチ', 'アラカルト', 'コース', 'テイクアウト'];
        return $arr;
    }

}