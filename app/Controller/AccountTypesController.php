<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/07/08
 * Time: 15:30
 */
class AccountTypesController extends AppController {
	#フォームヘルパー
	public $helpers = array('Html', 'Form');
	#Cookieの使用
	var $components = array('Cookie');
	#scaffold
	var $scaffold;

	#共通スクリプト
	public function beforeFilter(){
		#ページタイトル設定
		parent::beforeFilter();
		$this->set('title_for_layout', '買掛支出先設定 | 寿し和');
		#共通使用モデル
		$this->loadModel("Location");
		$this->loadModel("AccountType");
		if(!$this->Cookie->check('myData')){
			#loginページへ
			$this->redirect(array('controller'=>'locations','action'=>'login'));
		}else{
			$location = $this->Location->findById($this->Cookie->read('myData'));
			$this->set('location', $location);
		}
	}

	#index上書き
	public function index(){
		#従業員取得byLocationId
		$account_types = $this->AccountType->find('all', array(
			'conditions' => array('AccountType.location_id'=>$this->Cookie->read('myData'))
		));
		$this->set('account_types', $account_types);
	}

	#edit上書き
	public function edit($id){
		if($this->request->is('post')){
			#従業員情報
			$account_type = $this->AccountType->findById($id);
			if ($account_type != null) {
				$this->set('account_type', $account_type);
				#店舗
				$locations = $this->Location->find('all');
				$this->set('locations', $locations);
			} else {
				debug("えらー！");
				exit;
			}
		}elseif($this->request->is('get')){
			if($this->AccountType->save($this->request->query)){
				$this->Session->setFlash("編集完了しました");
				$this->redirect(array("controller"=>"accountTypes", 'action'=>'index'));
			}
		}
	}

	#add上書き
	public function add(){
		if($this->request->is('post')){
			if($this->AccountType->save($this->request->data)){
				$this->Session->setFlash("新規登録しました");
				$this->redirect(array("controller"=>"accountTypes", 'action'=>'index'));
			}
		}else{
			#店舗
			$locations = $this->Location->find('all');
			$this->set('locations', $locations);
		}
	}

}
