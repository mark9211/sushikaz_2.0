<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/07/23
 * Time: 12:24
 */
class StocktakingsController extends AppController{
    #フォームヘルパー
    public $helpers = array('Html', 'Form');
    #Cookieの使用
    var $components = array('Cookie');

    #共通スクリプト
    public function beforeFilter(){
        #ページタイトル設定
        parent::beforeFilter();
        $this->set('title_for_layout', '月別棚卸入力');
        #使用モデル
        $this->loadModel("Location");
        #ログイン処理
        if(!$this->Cookie->check('myData')){
            #loginページへ
            $this->redirect(array('controller'=>'locations','action'=>'login'));
        }else{
            #クッキー値
            $location = $this->Location->findById($this->Cookie->read('myData'));
            $this->set('location', $location);
        }
    }

    #カレンダー
    public function index(){
        # 使用モデル
        $this->loadModel("StocktakingType");
        $this->loadModel("Association");
        # クッキー値
        $location = $this->Location->findById($this->Cookie->read('myData'));
        $this->set('location', $location);
        # Association
        $associations = $this->Association->find('all', array(
            'conditions' => array('Association.location_id' => $location['Location']['id'])
        ));
        $association_arr = array();
        foreach($associations as $association){
            $association_arr[$association['Association']['id']] = $association['Attribute']['name'];
        }
        $this->set("associations", $association_arr);
        $this->set("boxNum", count($associations));
        # Month
        $month = $this->params['url']['month'];
        if($month!=null){
            $this->set('month', $month);
            #棚卸カテゴリー
            $stocking_types = $this->StocktakingType->find('all');
            if($stocking_types!=null){
                $data_set = array();
                foreach($stocking_types as $stocking_type){
                    # 既存レコード
                    foreach($associations as $association){
                        $stocktaking = $this->Stocktaking->find('first', array(
                            'conditions' => array('Stocktaking.association_id' => $association['Association']['id'], 'Stocktaking.type_id' => $stocking_type['StocktakingType']['id'], 'Stocktaking.working_month LIKE' => '%'.$month.'%')
                        ));
                        if($stocktaking!=null){
                            $stocking_type['ThisMonth'] = $stocktaking;
                        }else{
                            $date = $month.'-01';$last = date('Y-m-d', strtotime("$date -1 month"));
                            $stocktaking = $this->Stocktaking->find('first', array(
                                'conditions' => array('Stocktaking.association_id' => $association['Association']['id'], 'Stocktaking.type_id' => $stocking_type['StocktakingType']['id'], 'Stocktaking.working_month LIKE' => '%'.$last.'%')
                            ));
                            if($stocktaking!=null){
                                $stocking_type['LastMonth'] = $stocktaking;
                            }
                        }
                        $data_set[$association['Association']['id']][] = $stocking_type;
                    }
                }
                $this->set("stocking_types", $data_set);
            }else{
                echo "Category Error!!";
                exit;
            }
        }else{
            echo "Month Error!!";
            exit;
        }

    }

    #編集
    public function edit(){
        #クッキー値
        $location = $this->Location->findById($this->Cookie->read('myData'));
        $this->set('location', $location);
        $month = $this->request->data['month'];
        $stocktakings = $this->request->data['Stocktaking'];
        if($stocktakings!=null){
            foreach($stocktakings as $association_id => $stocktaking_arr){
                foreach($stocktaking_arr as $type_id => $stocktaking){
                    $history_stocktaking = $this->Stocktaking->find('first', array(
                        'conditions' => array('Stocktaking.association_id' => $association_id, 'Stocktaking.type_id' => $type_id, 'Stocktaking.working_month LIKE' => '%'.$month.'%')
                    ));
                    if($history_stocktaking!=null){ //既存
                        $data = array('Stocktaking' => array(
                            'id' => $history_stocktaking['Stocktaking']['id'],
                            'last_month' => $stocktaking['last_month'],
                            'this_month' => $stocktaking['this_month']
                        ));
                    }else{  //新規
                        $data = array('Stocktaking' => array(
                            'association_id' => $association_id,
                            'type_id' => $type_id,
                            'working_month' => $month.'-01',
                            'last_month' => $stocktaking['last_month'],
                            'this_month' => $stocktaking['this_month']
                        ));
                    }
                    #ループ実行文
                    $this->Stocktaking->create(false);
                    $this->Stocktaking->save($data);
                }
            }
        }
        $this->Session->setFlash("棚卸入力を受け付けました。");
        $this->redirect($this->referer());
    }

}
