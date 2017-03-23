<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/06/08
 * Time: 3:44
 */
class AdminController extends AppController{
	#フォームヘルパー
	public $helpers = array('Html', 'Form');
	#Cookieの使用
	var $components = array('Cookie');

	#共通スクリプト
	public function beforeFilter(){
		#ページタイトル設定
		parent::beforeFilter();
		$this->set('title_for_layout', '管理者ページ');
		#使用モデル
		$this->loadModel("Location");
	}

	#インデックス
	public function index(){
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


}