<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/06/14
 * Time: 17:46
 */
class MemberPositionsController extends AppController {
	var $scaffold;
	#共通スクリプト
	public function beforeFilter(){
		parent::beforeFilter();
		#ページタイトル設定
		$this->set('title_for_layout', '寿し和 | 管理システム');
	}
}
