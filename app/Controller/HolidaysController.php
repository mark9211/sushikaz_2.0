<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 2015/07/23
 * Time: 12:24
 */
class HolidaysController extends AppController{

	#共通スクリプト
	public function beforeFilter(){
		#ページタイトル設定
		parent::beforeFilter();
		$this->set('title_for_layout', '休業日設定');
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

	}

	#カレンダー
	public function edit(){
		#クッキー値
		$location = $this->Location->findById($this->Cookie->read('myData'));
		$this->set('location', $location);
		if($this->request->is('get')){
			#休業日取得
			$holidays = $this->Holiday->find('all', array(
				'conditions' => array('Holiday.location_id' => $location['Location']['id'])
			));
			if($holidays!=null){
				$this->set('holidays', $holidays);
			}
		}
		if($this->request->is('post')){
			if(isset($this->request->data['holidays'])){
				foreach($this->request->data['holidays'] as $holiday){
					if($holiday!=null){
						#既存かどうか
						$ex_holiday = $this->Holiday->find('first', array(
							'conditions' => array('Holiday.location_id' => $location['Location']['id'], 'Holiday.day' => $holiday)
						));
						if($ex_holiday==null){
							$data = array('Holiday' => array(
								'location_id' => $location['Location']['id'],
								'day' => $holiday
							));
							#ループ実行文
							$this->Holiday->create(false);
							$this->Holiday->save($data);
						}
					}
				}
				$this->Session->setFlash("休業日を設定が完了しました");
			}else{
				$this->Session->setFlash("休業日を設定してください");
			}
			$this->redirect($this->referer());
		}
	}

	#削除
	public function delete(){
		if($this->request->is('get')){
			#リファラチェック
			if($this->referer()=='/'){
				throw new NotFoundException('このページは見つかりませんでした');
			}
			if(isset($this->params['url']['id'])){
				$this->Holiday->delete($this->params['url']['id'], false);
				$this->Session->setFlash("休業日の削除が完了しました");
				$this->redirect($this->referer());
			}
		}
	}

}
