<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/06/08
 * Time: 3:44
 */
class AdminController extends AppController{

	#共通スクリプト
	public function beforeFilter(){
		#ページタイトル設定
		parent::beforeFilter();
		$this->set('title_for_layout', '管理者ページ');
		$this->to_login();
	}

	#インデックス
	public function index(){

	}

}